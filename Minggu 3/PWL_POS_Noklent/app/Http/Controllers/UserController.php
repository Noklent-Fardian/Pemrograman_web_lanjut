<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {

        $data = [
            'username' =>'Pelanggan 1'
        ];
        UserModel::where('username', 'customer-1')->update($data);
        $data = UserModel::all(); //mengambil semua data dari tabel m_user
        return view('user', ['data' => $data]); 
    }
}
