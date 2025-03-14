<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\KategoriDataTable;
use App\Models\Kategori;

class KategoriController extends Controller
{

    public function index(KategoriDataTable $dataTable)
    {
        // $data =[
        //     'kategori_kode' =>'SNK',
        //     'kategori_nama' =>'Snack/Makanan Ringan',
        //     'created_at' => now()
        // ];
        // DB::table('m_kategori')->insert($data);
        // return 'Data berhasil ditambahkan';

        // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->update(['kategori_nama' => 'Snack']);
        // return 'Data berhasil diupdate. Jumlah data yang diupdate: '. $row. ' baris';

        // $data = DB::table('m_kategori')->where('kategori_kode', 'SNK')->delete();
        // $data = DB::table('m_kategori')->get();
        // return view('kategori', ['data' => $data]);

        return $dataTable->render('kategori.index');
    }

    public function create()
    {
        return view('kategori.create');
    }
    public function store(Request $request)
    {
        Kategori::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
            'created_at' => now()
        ]);
        return redirect('kategori')->with('status', 'Data berhasil ditambahkan');
    }
}
