<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class SupplierController extends Controller
{
    public function index()
    {
        $breadcrumb = [
            'title' => 'Daftar Supplier',
            'list' => ['Home', 'Supplier']
        ];
        $page = (object)[
            'title' => 'Daftar Supplier'
        ];
        $activeMenu = 'supplier';
        return view('supplier.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $data = Supplier::query();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $btn = '<a href="' . url('/supplier/show/' . $row->supplier_id) . '" class="btn btn-info btn-sm mr-1">
                            <i class="fas fa-eye"></i> Lihat
                        </a>';
                $btn .= '<a href="' . url('/supplier/edit/' . $row->supplier_id) . '" class="btn btn-warning btn-sm mr-1">
                            <i class="fas fa-edit"></i> Edit
                        </a>';
                $btn .= '<form class="d-inline" method="POST" action="' . url('/supplier/delete/' . $row->supplier_id) . '">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>';
                return $btn;
            })
            ->addColumn('AJAX', function ($row) {
                $btn = '<button onclick="modalAction(\'' . url('/supplier/show_ajax/' . $row->supplier_id) . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $row->supplier_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $row->supplier_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi', 'AJAX'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = [
            'title' => 'Tambah Supplier',
            'list' => ['Home', 'Supplier', 'Tambah']
        ];
        $page = (object)[
            'title' => 'Tambah Supplier Baru'
        ];
        $activeMenu = 'supplier';
        return view('supplier.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_kode' => 'required|string|max:10|unique:m_supplier,supplier_kode',
            'name_supplier' => 'required|string|max:100',
            'supplier_contact' => 'required|string|max:15',
            'supplier_alamat' => 'nullable|string|max:255',
            'supplier_email' => 'nullable|email|max:100',
            'supplier_keterangan' => 'nullable|string',
        ]);

        Supplier::create([
            'supplier_kode' => $request->supplier_kode,
            'name_supplier' => $request->name_supplier,
            'supplier_contact' => $request->supplier_contact,
            'supplier_alamat' => $request->supplier_alamat,
            'supplier_email' => $request->supplier_email,
            'supplier_aktif' => true,
            'supplier_keterangan' => $request->supplier_keterangan,
        ]);

        return redirect('/supplier')->with('success', 'Data supplier berhasil disimpan');
    }

    public function show($id)
    {
        $supplier = Supplier::find($id);
        $breadcrumb = [
            'title' => 'Detail Supplier',
            'list' => ['Home', 'Supplier', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail Supplier'
        ];
        $activeMenu = 'supplier';
        return view('supplier.show', compact('breadcrumb', 'page', 'activeMenu', 'supplier'));
    }

    public function edit($id)
    {
        $supplier = Supplier::find($id);
        $breadcrumb = [
            'title' => 'Edit Supplier',
            'list' => ['Home', 'Supplier', 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit Supplier'
        ];
        $activeMenu = 'supplier';
        return view('supplier.edit', compact('breadcrumb', 'page', 'activeMenu', 'supplier'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'supplier_kode' => 'required|string|max:10|unique:m_supplier,supplier_kode,' . $id . ',supplier_id',
            'name_supplier' => 'required|string|max:100',
            'supplier_contact' => 'required|string|max:15',
            'supplier_alamat' => 'nullable|string|max:255',
            'supplier_email' => 'nullable|email|max:100',
            'supplier_aktif' => 'boolean',
            'supplier_keterangan' => 'nullable|string',
        ]);

        Supplier::where('supplier_id', $id)->update([
            'supplier_kode' => $request->supplier_kode,
            'name_supplier' => $request->name_supplier,
            'supplier_contact' => $request->supplier_contact,
            'supplier_alamat' => $request->supplier_alamat,
            'supplier_email' => $request->supplier_email,
            'supplier_aktif' => (int)$request->supplier_status,
            'supplier_keterangan' => $request->supplier_keterangan,
        ]);

        return redirect('/supplier')->with('success', 'Data supplier berhasil diubah');
    }

    public function delete($id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
        }

        try {
            Supplier::destroy($id);
            return redirect('/supplier')->with('success', 'Data supplier berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/supplier')->with('error', 'Data supplier gagal dihapus karena masih terdapat data terkait.');
        }
    }
    public function showAjax($id)
    {
        $supplier = Supplier::find($id);
        return view('supplier.show_ajax', compact('supplier'));
    }

    public function create_ajax()
    {
        return view('supplier.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // Check if request is AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_kode' => 'required|string|max:10|unique:m_supplier,supplier_kode',
                'name_supplier' => 'required|string|max:100',
                'supplier_contact' => 'required|string|max:15',
                'supplier_alamat' => 'nullable|string|max:255',
                'supplier_email' => 'nullable|email|max:100',
                'supplier_keterangan' => 'nullable|string'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                Supplier::create([
                    'supplier_kode' => $request->supplier_kode,
                    'name_supplier' => $request->name_supplier,
                    'supplier_contact' => $request->supplier_contact,
                    'supplier_alamat' => $request->supplier_alamat,
                    'supplier_email' => $request->supplier_email,
                    'supplier_aktif' => true, // Default to active for new suppliers
                    'supplier_keterangan' => $request->supplier_keterangan,
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Data supplier berhasil disimpan'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menyimpan data: ' . $e->getMessage()
                ]);
            }
        }

        return redirect('/');
    }
    public function edit_ajax($id)
    {
        $supplier = Supplier::find($id);
        return view('supplier.edit_ajax', compact('supplier'));
    }

    public function update_ajax(Request $request, $id)
    {
        // Check if request is AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_kode' => 'required|string|max:10|unique:m_supplier,supplier_kode,' . $id . ',supplier_id',
                'name_supplier' => 'required|string|max:100',
                'supplier_contact' => 'required|string|max:15',
                'supplier_alamat' => 'nullable|string|max:255',
                'supplier_email' => 'nullable|email|max:100',
                'supplier_aktif' => 'required',
                'supplier_keterangan' => 'nullable|string'
            ];
            // punya Nokurento
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                $supplier = Supplier::find($id);

                if (!$supplier) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data supplier tidak ditemukan'
                    ]);
                }

                $supplier->update([
                    'supplier_kode' => $request->supplier_kode,
                    'name_supplier' => $request->name_supplier,
                    'supplier_contact' => $request->supplier_contact,
                    'supplier_alamat' => $request->supplier_alamat,
                    'supplier_email' => $request->supplier_email,
                    'supplier_aktif' => $request->supplier_aktif,
                    'supplier_keterangan' => $request->supplier_keterangan,
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Data supplier berhasil diupdate'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal mengupdate data: ' . $e->getMessage()
                ]);
            }
        }

        return redirect('/');
    }
    //delete
    public function confirm_ajax($id)
    {
        $supplier = Supplier::find($id);
        return view('supplier.confirm_ajax', compact('supplier'));
    }
    public function delete_ajax($id)
    {
        $supplier = Supplier::find($id);
        if ($supplier) {
            try {
                $supplier->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data supplier berhasil dihapus'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menghapus data: ' . $e->getMessage()
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data supplier tidak ditemukan'
            ]);
        }
    }
}
