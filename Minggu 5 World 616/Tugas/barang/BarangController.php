<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function index()
    {
        $breadcrumb = [
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];
        $page = (object)[
            'title' => 'Daftar Barang'
        ];
        $activeMenu = 'barang';
        $kategoris = Kategori::all();
        return view('barang.index', compact('breadcrumb', 'page', 'activeMenu', 'kategoris'));
    }

    public function list(Request $request)
    {
        $data = Barang::with('kategori');

        if ($request->filled('kategori_id')) {
            $data->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('harga_jual_formatted', function ($row) {
                return 'Rp ' . number_format($row->harga_jual, 0, ',', '.');
            })
            ->addColumn('harga_beli_formatted', function ($row) {
                return 'Rp ' . number_format($row->harga_beli, 0, ',', '.');
            })
            ->addColumn('aksi', function ($row) {
                $btn = '<a href="' . url('/barang/show/' . $row->barang_id) . '" class="btn btn-info btn-sm mr-1">
                            <i class="fas fa-eye"></i> Lihat
                        </a>';
                $btn .= '<a href="' . url('/barang/edit/' . $row->barang_id) . '" class="btn btn-warning btn-sm mr-1">
                            <i class="fas fa-edit"></i> Edit
                        </a>';
                $btn .= '<form class="d-inline" method="POST" action="' . url('/barang/delete/' . $row->barang_id) . '">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = [
            'title' => 'Tambah Barang',
            'list' => ['Home', 'Barang', 'Tambah']
        ];
        $page = (object)[
            'title' => 'Tambah Barang Baru'
        ];
        $kategori = Kategori::all();
        $activeMenu = 'barang';
        return view('barang.create', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|string|max:10|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|numeric|min:1',
            'harga_jual' => 'required|numeric|min:1|gt:harga_beli',
        ], [
            'harga_jual.gt' => 'Harga jual harus lebih besar dari harga beli.'
        ]);

        Barang::create([
            'kategori_id' => $request->kategori_id,
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }

    public function show($id)
    {
        $barang = Barang::with('kategori')->find($id);
        $breadcrumb = [
            'title' => 'Detail Barang',
            'list' => ['Home', 'Barang', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail Barang'
        ];
        $activeMenu = 'barang';
        return view('barang.show', compact('breadcrumb', 'page', 'activeMenu', 'barang'));
    }

    public function edit($id)
    {
        $barang = Barang::find($id);
        $breadcrumb = [
            'title' => 'Edit Barang',
            'list' => ['Home', 'Barang', 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit Barang'
        ];
        $kategori = Kategori::all();
        $activeMenu = 'barang';
        return view('barang.edit', compact('breadcrumb', 'page', 'activeMenu', 'barang', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|string|max:10|unique:m_barang,barang_kode,' . $id . ',barang_id',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|numeric|min:1',
            'harga_jual' => 'required|numeric|min:1|gt:harga_beli',
        ], [
            'harga_jual.gt' => 'Harga jual harus lebih besar dari harga beli.'
        ]);

        Barang::where('barang_id', $id)->update([
            'kategori_id' => $request->kategori_id,
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil diubah');
    }

    public function delete($id)
    {
        $barang = Barang::find($id);
        
        if (!$barang) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }
        
        try {
            Barang::destroy($id);
            return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/barang')->with('error', 'Data barang gagal dihapus karena masih terdapat data terkait.');
        }
    }
}