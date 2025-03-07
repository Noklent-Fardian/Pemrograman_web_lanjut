<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    
    public function index(){
        // $data =[
        //     'kategori_kode' =>'SNK',
        //     'kategori_nama' =>'Snack/Makanan Ringan',
        //     'created_at' => now()
        // ];
        // DB::table('m_kategori')->insert($data);
        // return 'Data berhasil ditambahkan';

        // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->update(['kategori_nama' => 'Snack']);
        // return 'Data berhasil diupdate. Jumlah data yang diupdate: '. $row. ' baris';

        $data = DB::table('m_kategori')->where('kategori_kode', 'SNK')->delete();
        $data = DB::table('m_kategori')->get();
        return view('kategori', ['data' => $data]);
    }

}
