<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class KategoriController extends Controller
{
    public function index()
    {
        $breadcrumb = [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];
        $page = (object)[
            'title' => 'Daftar Kategori'
        ];
        $activeMenu = 'kategori';
        return view('kategori.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $data = Kategori::query();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $btn = '<a href="' . url('/kategori/show/' . $row->kategori_id) . '" class="btn btn-info btn-sm mr-1">
                            <i class="fas fa-eye"></i> Lihat
                        </a>';
                $btn .= '<a href="' . url('/kategori/edit/' . $row->kategori_id) . '" class="btn btn-warning btn-sm mr-1">
                            <i class="fas fa-edit"></i> Edit
                        </a>';
                $btn .= '<form class="d-inline" method="POST" action="' . url('/kategori/delete/' . $row->kategori_id) . '">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>';
                return $btn;
            })
            ->addColumn('AJAX', function ($kategori) {
                $btn = '<button onclick="modalAction(\'' . url('/kategori/show_ajax/' . $kategori->kategori_id) . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi', 'AJAX'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = [
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah']
        ];
        $page = (object)[
            'title' => 'Tambah Kategori Baru'
        ];
        $activeMenu = 'kategori';
        return view('kategori.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_kode' => 'required|string|max:10|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max:100',
        ]);

        Kategori::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }

    public function show($id)
    {
        $kategori = Kategori::find($id);
        $breadcrumb = [
            'title' => 'Detail Kategori',
            'list' => ['Home', 'Kategori', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail Kategori'
        ];
        $activeMenu = 'kategori';
        return view('kategori.show', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    public function edit($id)
    {
        $kategori = Kategori::find($id);
        $breadcrumb = [
            'title' => 'Edit Kategori',
            'list' => ['Home', 'Kategori', 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit Kategori'
        ];
        $activeMenu = 'kategori';
        return view('kategori.edit', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_kode' => 'required|string|max:10|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
            'kategori_nama' => 'required|string|max:100',
        ]);

        Kategori::where('kategori_id', $id)->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
    }

    public function delete($id)
    {
        $kategori = Kategori::find($id);
        
        if (!$kategori) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }
        
        try {
            Kategori::destroy($id);
            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terdapat data barang yang terkait dengan kategori ini.');
        }
    }
    public function showAjax($id)
    {
        $kategori = Kategori::find($id);
        return view('kategori.show_ajax', compact('kategori'));
    }

    public function create_ajax()
    {
        return view('kategori.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // Check if request is AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|string|max:10|unique:m_kategori,kategori_kode',
                'kategori_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            Kategori::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data kategori berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $kategori = Kategori::find($id);
        return view('kategori.edit_ajax', compact('kategori'));
    }

    public function update_ajax(Request $request, $id)
    {
        // Check if request is AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|string|max:10|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
                'kategori_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $kategori = Kategori::find($id);
            if ($kategori) {
                $kategori->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data kategori berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data kategori tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $kategori = Kategori::find($id);
        return view('kategori.confirm_ajax', ['kategori' => $kategori]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // Check if request is AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $kategori = Kategori::find($id);
            if ($kategori) {
                try {
                    $kategori->delete();
                    return response()->json([
                        'status' => true,
                        'message' => 'Data kategori berhasil dihapus'
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data kategori tidak bisa dihapus karena masih digunakan'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data kategori tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
}