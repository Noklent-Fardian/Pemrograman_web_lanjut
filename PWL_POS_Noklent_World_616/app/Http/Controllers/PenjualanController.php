<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PenjualanController extends Controller
{
    public function index()
    {
        $breadcrumb = [
            'title' => 'Transaksi Penjualan',
            'list' => ['Home', 'Penjualan']
        ];

        $page = (object)[
            'title' => 'Daftar Transaksi Penjualan'
        ];

        $activeMenu = 'penjualan';

        return view('penjualan.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $data = Penjualan::with(['user'])
            ->orderBy('created_at', 'desc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('tanggal_formatted', function ($row) {
                return date('d M Y', strtotime($row->tanggal_penjualan));
            })
            ->addColumn('user_nama', function ($row) {
                return $row->user->nama;
            })
            ->addColumn('total_item', function ($row) {
                return $row->details->count() . ' items';
            })
            ->addColumn('total_harga', function ($row) {
                $total = $row->details->sum(function ($detail) {
                    return $detail->jumlah_barang * $detail->harga_barang;
                });
                return 'Rp. ' . number_format($total, 0, ',', '.');
            })
            ->addColumn('aksi', function ($row) {
                $btn = '<div class="btn-group" role="group">';
                $btn .= '<a href="' . url('/penjualan/' . $row->penjualan_id) . '" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>';
                $btn .= '<a href="' . url('/penjualan/' . $row->penjualan_id . '/pdf') . '" target="_blank" class="btn btn-danger btn-sm">
                            <i class="fas fa-file-pdf"></i>
                        </a>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = [
            'title' => 'Buat Transaksi Baru',
            'list' => ['Home', 'Penjualan', 'Buat Transaksi']
        ];

        $page = (object)[
            'title' => 'Buat Transaksi Penjualan Baru'
        ];

        $activeMenu = 'penjualan';
        $barang = Barang::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('t_stock')
                ->whereRaw('t_stock.barang_id = m_barang.barang_id')
                ->groupBy('barang_id')
                ->havingRaw('SUM(stok_jumlah) > 0');
        })->orderBy('barang_nama')->get();

        
        $date = date('Ymd');
        $code_fisrt='TR-';
        $latestPenjualan = Penjualan::where('penjualan_kode', 'like', $code_fisrt . $date . '-%')
            ->orderBy('penjualan_kode', 'desc')
            ->first();

        $lastNumber = $latestPenjualan ? (int)substr($latestPenjualan->penjualan_kode, -4) : 0;
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $transactionCode = $code_fisrt . $date . '-' . $newNumber;

        return view('penjualan.create', compact('breadcrumb', 'page', 'activeMenu', 'barang', 'transactionCode'));
    }

    public function getBarangInfo($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Barang tidak ditemukan'
            ]);
        }

        
        $totalStock = DB::table('t_stock')
            ->where('barang_id', $id)
            ->sum('stok_jumlah');

        return response()->json([
            'status' => true,
            'data' => [
                'barang_id' => $barang->barang_id,
                'barang_kode' => $barang->barang_kode,
                'barang_nama' => $barang->barang_nama,
                'harga_jual' => $barang->harga_jual,
                'stok' => $totalStock
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penjualan_kode' => 'required|unique:t_penjualan,penjualan_kode',
            'tanggal_penjualan' => 'required|date',
            'pembeli' => 'required|string|max:100',
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:m_barang,barang_id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Create the transaction header
            $penjualan = Penjualan::create([
                'user_id' => Auth::id(),
                'pembeli' => $request->pembeli,
                'penjualan_kode' => $request->penjualan_kode,
                'tanggal_penjualan' => $request->tanggal_penjualan
            ]);

         
            foreach ($request->items as $item) {
              
                $availableStock = DB::table('t_stock')
                    ->where('barang_id', $item['barang_id'])
                    ->sum('stok_jumlah');

                if ($availableStock < $item['jumlah']) {
                    throw new \Exception('Stok barang ' . $item['nama_barang'] . ' tidak mencukupi.');
                }

            
                PenjualanDetail::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id' => $item['barang_id'],
                    'jumlah_barang' => $item['jumlah'],
                    'harga_barang' => $item['harga']
                ]);

               
                $remaining = $item['jumlah'];
                $stocks = DB::table('t_stock')
                    ->where('barang_id', $item['barang_id'])
                    ->where('stok_jumlah', '>', 0)
                    ->orderBy('stok_tanggal_masuk')
                    ->get();

                foreach ($stocks as $stock) {
                    if ($remaining <= 0) break;

                    $take = min($stock->stok_jumlah, $remaining);
                    DB::table('t_stock')
                        ->where('stock_id', $stock->stock_id)
                        ->update(['stok_jumlah' => $stock->stok_jumlah - $take]);

                    $remaining -= $take;
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Transaksi berhasil disimpan',
                'data' => [
                    'penjualan_id' => $penjualan->penjualan_id,
                    'penjualan_kode' => $penjualan->penjualan_kode
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Transaksi gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $penjualan = Penjualan::with(['user', 'details.barang'])->find($id);

        if (!$penjualan) {
            abort(404, 'Transaksi tidak ditemukan');
        }

        $breadcrumb = [
            'title' => 'Detail Transaksi',
            'list' => ['Home', 'Penjualan', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Transaksi Penjualan'
        ];

        $activeMenu = 'penjualan';

        return view('penjualan.show', compact('breadcrumb', 'page', 'activeMenu', 'penjualan'));
    }

    public function generatePdf($id)
    {
        $penjualan = Penjualan::with(['user', 'details.barang'])->find($id);

        if (!$penjualan) {
            abort(404, 'Transaksi tidak ditemukan');
        }

        $pdf = Pdf::loadView('penjualan.receipt_pdf', ['penjualan' => $penjualan]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", false);
        $pdf->setOption("isPhpEnabled", false);
        $pdf->setOption("isHtml5ParserEnabled", true);

        return $pdf->stream('Struk_' . $penjualan->penjualan_kode . '.pdf');
    }

    public function export_excel()
    {
        $penjualans = Penjualan::with(['user', 'details.barang'])
            ->orderBy('tanggal_penjualan', 'desc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set title
        $sheet->setCellValue('A1', 'LAPORAN PENJUALAN');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Set headers
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Kode Transaksi');
        $sheet->setCellValue('C2', 'Tanggal');
        $sheet->setCellValue('D2', 'Pembeli');
        $sheet->setCellValue('E2', 'Petugas');
        $sheet->setCellValue('F2', 'Total');

        // Style the header row
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '8664bc']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];
        $sheet->getStyle('A2:F2')->applyFromArray($headerStyle);

        $sheet->getRowDimension(2)->setRowHeight(25);
        $sheet->freezePane('A3');


        $no = 1;
        $row = 3;
        foreach ($penjualans as $penjualan) {
            $total = $penjualan->details->sum(function ($detail) {
                return $detail->jumlah_barang * $detail->harga_barang;
            });

            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $penjualan->penjualan_kode);
            $sheet->setCellValue('C' . $row, date('d-m-Y', strtotime($penjualan->tanggal_penjualan)));
            $sheet->setCellValue('D' . $row, $penjualan->pembeli);
            $sheet->setCellValue('E' . $row, $penjualan->user->nama);
            $sheet->setCellValue('F' . $row, 'Rp. ' . number_format($total, 0, ',', '.'));

           
            $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ]);

            $row++;
            $no++;
        }

   
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Laporan Penjualan');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Laporan Penjualan ' . date('Y-m-d H:i:s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $penjualans = Penjualan::with(['user', 'details.barang'])
            ->orderBy('tanggal_penjualan', 'desc')
            ->get();

        $pdf = Pdf::loadView('penjualan.export_pdf', ['penjualans' => $penjualans]);
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOption("isRemoteEnabled", false);
        $pdf->setOption("isPhpEnabled", false);
        $pdf->setOption("isHtml5ParserEnabled", true);

        return $pdf->stream('Laporan Penjualan ' . date('Y-m-d H:i:s') . '.pdf');
    }
}
