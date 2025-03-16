<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\LevelDataTable;
use App\Models\Level;

class LevelController extends Controller
{
    public function index(LevelDataTable $dataTable)
    {
         // DB::insert('insert into m_level(level_kode, level_nama, created_at) values(?, ?, ?)', ['CUS', 'Pelanggan', now()]);
        // return 'Insert data baru berhasil';

        // $row = DB::update('update m_level set level_nama=? where level_kode = ?', ['Customer', 'cus']);
        // return 'Update data berhasil. Jumlah data yang diupdate: '. $row. ' baris';

        // $row = DB::delete('delete from m_level where level_kode = ?', ['CUS']);
        // return 'Delete data berhasil. Jumlah data yang dihapus:' . $row . 'baris';
        return $dataTable->render('level.index');
    }

    public function tambah()
    {
        return view('level.create');
    }

    public function tambah_simpan(Request $request)
    {
        $request->validate([
            'level_kode' => 'required|string|max:10|unique:m_level,level_kode',
            'level_nama' => 'required|string|max:100',
        ]);

        Level::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
            'created_at' => now()
        ]);

        return redirect('/level')->with('status', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $level = Level::findOrFail($id);
        return view('level.edit', compact('level'));
    }

    public function ubah_simpan(Request $request, $id)
    {
        $request->validate([
            'level_kode' => 'required|string|max:10|unique:m_level,level_kode,' . $id . ',level_id',
            'level_nama' => 'required|string|max:100',
        ]);

        $level = Level::findOrFail($id);
        $level->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);

        return redirect('/level')->with('status', 'Data berhasil diperbarui');
    }

    public function hapus($id)
    {
        $level = Level::findOrFail($id);
        $level->delete();

        return redirect('/level')->with('status', 'Data berhasil dihapus');
    }
}