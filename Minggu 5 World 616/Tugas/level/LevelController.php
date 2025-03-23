<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    public function index()
    {
        $breadcrumb = [
            'title' => 'Daftar Level',
            'list' => ['Home', 'Level']
        ];
        $page = (object)[
            'title' => 'Daftar Level'
        ];
        $activeMenu = 'level';
        return view('level.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $data = Level::query();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $btn = '<a href="' . url('/level/show/' . $row->level_id) . '" class="btn btn-info btn-sm mr-1">
                            <i class="fas fa-eye"></i> Lihat
                        </a>';
                $btn .= '<a href="' . url('/level/edit/' . $row->level_id) . '" class="btn btn-warning btn-sm mr-1">
                            <i class="fas fa-edit"></i> Edit
                        </a>';
                $btn .= '<form class="d-inline" method="POST" action="' . url('/level/delete/' . $row->level_id) . '">
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
            'title' => 'Tambah Level',
            'list' => ['Home', 'Level', 'Tambah']
        ];
        $page = (object)[
            'title' => 'Tambah Level Baru'
        ];
        $activeMenu = 'level';
        return view('level.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_kode' => 'required|string|max:10|unique:m_level,level_kode',
            'level_nama' => 'required|string|max:100',
        ]);

        Level::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);

        return redirect('/level')->with('success', 'Data level berhasil disimpan');
    }

    public function show($id)
    {
        $level = Level::find($id);
        $breadcrumb = [
            'title' => 'Detail Level',
            'list' => ['Home', 'Level', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail Level'
        ];
        $activeMenu = 'level';
        return view('level.show', compact('breadcrumb', 'page', 'activeMenu', 'level'));
    }

    public function edit($id)
    {
        $level = Level::find($id);
        $breadcrumb = [
            'title' => 'Edit Level',
            'list' => ['Home', 'Level', 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit Level'
        ];
        $activeMenu = 'level';
        return view('level.edit', compact('breadcrumb', 'page', 'activeMenu', 'level'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'level_kode' => 'required|string|max:10|unique:m_level,level_kode,' . $id . ',level_id',
            'level_nama' => 'required|string|max:100',
        ]);

        Level::where('level_id', $id)->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);

        return redirect('/level')->with('success', 'Data level berhasil diubah');
    }

    public function delete($id)
    {
        $level = Level::find($id);
        
        if (!$level) {
            return redirect('/level')->with('error', 'Data level tidak ditemukan');
        }
        
        try {
            Level::destroy($id);
            return redirect('/level')->with('success', 'Data level berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terdapat data terkait.');
        }
    }
}