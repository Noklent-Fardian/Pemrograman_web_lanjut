<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    /*========================= JS 3 ===============================*/
    // $data = [
    //     'username' =>'Pelanggan 1'
    // ];
    // UserModel::where('username', 'customer-1')->update($data);
    // $data = UserModel::all(); //mengambil semua data dari tabel m_user
    // return view('user', ['data' => $data]); 

    /*========================= JS 4 ===============================*/
    public function index()
    {
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345')
        // ];
        // UserModel::create($data);
        // $user = UserModel::all();
        // return view('user', ['data' => $user]);

        // $user = UserModel::find(1);
        // $user = UserModel::Where('level_id', 1)->first();
        // $user = UserModel::firstWhere('level_id', 1);
        $user = UserModel::findor(21, ['username', 'nama'], function () {
            abort(404);
        });
        return view('user', ['data' => $user]);
    }
}
