<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Barang;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class StockController extends Controller
{
    public function index()
    {
        $breadcrumb = [
            'title' => 'Data Stok Barang',
            'list' => ['Home', 'Stok']
        ];

        $page = (object)[
            'title' => 'Daftar Stok Barang'
        ];

        $activeMenu = 'stok';
        $suppliers = Supplier::where('supplier_aktif', 1)->get();
        $barangs = Barang::orderBy('barang_nama')->get();

        return view('stok.index', compact('breadcrumb', 'page', 'activeMenu', 'suppliers', 'barangs'));
    }

    public function list(Request $request)
    {
        $data = Stock::with(['barang', 'supplier', 'user'])
            ->orderBy('stok_tanggal_masuk', 'desc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('tanggal_formatted', function ($row) {
                return date('d M Y', strtotime($row->stok_tanggal_masuk));
            })
            ->addColumn('barang_nama', function ($row) {
                return $row->barang->barang_nama;
            })
            ->addColumn('supplier_nama', function ($row) {
                return $row->supplier->name_supplier;
            })
            ->addColumn('user_nama', function ($row) {
                return $row->user->nama;
            })
            ->addColumn('aksi', function ($row) {
                $btn = '<div class="btn-group" role="group">';
                $btn .= '<button onclick="showDetail(' . $row->stock_id . ')" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </button>';
                $btn .= '<button onclick="editStock(' . $row->stock_id . ')" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </button>';
                $btn .= '<button onclick="deleteStock(' . $row->stock_id . ')" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                        </button>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }


    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $validator = Validator::make($request->all(), [
                'barang_id' => 'required|exists:m_barang,barang_id',
                'supplier_id' => 'required|exists:m_supplier,supplier_id',
                'stok_tanggal_masuk' => 'required|date',
                'stok_jumlah' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            DB::beginTransaction();
            try {

                $existingStock = Stock::where('barang_id', $request->barang_id)
                    ->where('supplier_id', $request->supplier_id)
                    ->where('stok_tanggal_masuk', $request->stok_tanggal_masuk)
                    ->first();

                if ($existingStock) {

                    $existingStock->update([
                        'stok_jumlah' => $existingStock->stok_jumlah + $request->stok_jumlah
                    ]);

                    $message = 'Jumlah stok barang berhasil diperbarui';
                } else {

                    Stock::create([
                        'barang_id' => $request->barang_id,
                        'user_id' => Auth::id(),
                        'supplier_id' => $request->supplier_id,
                        'stok_tanggal_masuk' => $request->stok_tanggal_masuk,
                        'stok_jumlah' => $request->stok_jumlah
                    ]);

                    $message = 'Stok barang baru berhasil ditambahkan';
                }

                DB::commit();

                return response()->json([
                    'status' => true,
                    'message' => $message
                ]);
            } catch (\Exception $e) {
                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }

        return redirect('/stok');
    }

    public function show($id)
    {
        $stock = Stock::with(['barang', 'supplier', 'user'])->find($id);
        return response()->json($stock);
    }

    public function edit($id)
    {
        $stock = Stock::find($id);
        $suppliers = Supplier::where('supplier_aktif', 1)->get();
        $barangs = Barang::orderBy('barang_nama')->get();

        return response()->json([
            'stock' => $stock,
            'suppliers' => $suppliers,
            'barangs' => $barangs
        ]);
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $validator = Validator::make($request->all(), [
                'barang_id' => 'required|exists:m_barang,barang_id',
                'supplier_id' => 'required|exists:m_supplier,supplier_id',
                'stok_tanggal_masuk' => 'required|date',
                'stok_jumlah' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            DB::beginTransaction();
            try {
                $stock = Stock::find($id);

                if (!$stock) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data stok tidak ditemukan'
                    ]);
                }

                $stock->update([
                    'barang_id' => $request->barang_id,
                    'supplier_id' => $request->supplier_id,
                    'stok_tanggal_masuk' => $request->stok_tanggal_masuk,
                    'stok_jumlah' => $request->stok_jumlah
                ]);

                DB::commit();

                return response()->json([
                    'status' => true,
                    'message' => 'Data stok berhasil diperbarui'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }

        return redirect('/stok');
    }

    public function destroy($id)
    {
        if (request()->ajax() || request()->wantsJson()) {
            try {
                $stock = Stock::find($id);

                if (!$stock) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data stok tidak ditemukan'
                    ]);
                }

                $stock->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Data stok berhasil dihapus'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }

        return redirect('/stok');
    }

    public function export_excel()
    {
        $stocks = Stock::with(['barang', 'supplier', 'user'])->orderBy('stok_tanggal_masuk', 'desc')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set title
        $sheet->setCellValue('A1', 'LAPORAN DATA STOK BARANG');
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Set headers
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Tanggal');
        $sheet->setCellValue('C2', 'Nama Barang');
        $sheet->setCellValue('D2', 'Supplier');
        $sheet->setCellValue('E2', 'Petugas');
        $sheet->setCellValue('F2', 'Jumlah');
        $sheet->setCellValue('G2', 'Kode Barang');

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
        $sheet->getStyle('A2:G2')->applyFromArray($headerStyle);

        $sheet->getRowDimension(2)->setRowHeight(25);
        $sheet->freezePane('A3');

        // Fill data
        $no = 1;
        $row = 3;
        foreach ($stocks as $stock) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, date('d-m-Y', strtotime($stock->stok_tanggal_masuk)));
            $sheet->setCellValue('C' . $row, $stock->barang->barang_nama);
            $sheet->setCellValue('D' . $row, $stock->supplier->name_supplier);
            $sheet->setCellValue('E' . $row, $stock->user->nama);
            $sheet->setCellValue('F' . $row, $stock->stok_jumlah);
            $sheet->setCellValue('G' . $row, $stock->barang->barang_kode);

            // Add border to data
            $sheet->getStyle('A' . $row . ':G' . $row)->applyFromArray([
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

       
        foreach (range('A', 'G') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Set title and prepare for download
        $sheet->setTitle('Data Stok Barang');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Stok Barang ' . date('Y-m-d H:i:s') . '.xlsx';

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
        $stocks = Stock::with(['barang', 'supplier', 'user'])
            ->orderBy('stok_tanggal_masuk', 'desc')
            ->get();

        $pdf = Pdf::loadView('stok.export_pdf', ['stocks' => $stocks]);
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOption("isRemoteEnabled", false);
        $pdf->setOption("isPhpEnabled", false);
        $pdf->setOption("isHtml5ParserEnabled", true);

        return $pdf->stream('Data Stok Barang ' . date('Y-m-d H:i:s') . '.pdf');
    }

    public function showAllBarang()
    {
        $breadcrumb = [
            'title' => 'Total Stok Per Barang pada Gudang ',
            'list' => ['Home', 'Stok', 'Gudang']
        ];

        $page = (object)[
            'title' => 'Total Stok Per Barang'
        ];

        $activeMenu = 'stok';

     
        $stockByBarang = DB::table('t_stock')
            ->select(
                'm_barang.barang_id',
                'm_barang.barang_kode',
                'm_barang.barang_nama',
                DB::raw('SUM(stok_jumlah) as total_stok'),
                'm_kategori.kategori_nama'
            )
            ->join('m_barang', 'm_barang.barang_id', '=', 't_stock.barang_id')
            ->join('m_kategori', 'm_kategori.kategori_id', '=', 'm_barang.kategori_id')
            ->groupBy('m_barang.barang_id', 'm_barang.barang_kode', 'm_barang.barang_nama', 'm_kategori.kategori_nama')
            ->orderBy('m_barang.barang_nama')
            ->get();

        return view('stok.show_allBarang', compact('breadcrumb', 'page', 'activeMenu', 'stockByBarang'));
    }
}
