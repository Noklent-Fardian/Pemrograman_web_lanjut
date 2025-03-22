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
        // $user = UserModel::findor(21, ['username', 'nama'], function () {
        //     abort(404);
        // $user = UserModel::findOrFail(1);

        /*========================= JS 4-2.3 ===============================*/
        // try {
        //     $users = UserModel::Where('level_id', 2)->get();
        //     $userCount = UserModel::where('level_id', 2)->count();

        //     if ($userCount === 0) {
        //         return response()->json(['message' => 'No users found'], 404);
        //     }

        //     return view('user', ['userCount' => $userCount, 'data' => $users]);
        // } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
        //     return response()->json(['message' => 'No users found'], 404);
        // }

        /*========================= JS 4-2.4 ===============================*/
        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager33',
        //         'nama' => 'Manager Tiga Tiga',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ],
        // );
        // $user->save();
        // return view('user', ['data' => $user]);

        /*========================= JS 4-2.5 ===============================*/
        // $user = UserModel::create([
        //     'username' => 'manager11',
        //     'nama' => 'Manager11',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2,
        // ]);
        // $user->username = 'manager12';
        // $user->save();
        // $user->wasChanged(); // true 
        // $user->wasChanged('username'); // true 
        // $user->wasChanged(['username', 'level_id']); // true 
        // $user->wasChanged('nama'); // false 
        // dd($user->wasChanged(['nama', 'username'])); // true

        /*========================= JS 4-2.6 ===============================*/
        //     $user = UserModel::all();
        //     return view('user', ['data' => $user]);
        // }
        // public function tambah()
        // {
        //     return view('user.tambah');
        // }
        // public function tambah_simpan(Request $request)
        // {
        //     $data = [

        //         'username' => $request->username,
        //         'nama' => $request->nama,
        //         'password' => Hash::make($request->password),
        //         'level_id' => $request->level_id
        //     ];
        //     UserModel::create($data);
        //     return redirect('/user');
        // }
        // public function edit($id)
        // {
        //     $user = UserModel::find($id);
        //     return view('user.ubah', ['data' => $user]);
        // }
        // public function ubah_simpan( $id,Request $request)
        // {
        //     $user = UserModel::find($id);
        //     $data = [
        //         'username' => $request->username,
        //         'nama' => $request->nama,
        //         'password' => Hash::make($request->password),
        //         'level_id' => $request->level_id,
        //     ];
        //     UserModel::where('user_id', $id)->update($data);
        //     return redirect('/user');
        // }
        // public function hapus($id)
        // {
        //     UserModel::where('user_id', $id)->delete();
        //     return redirect('/user');
        // }

        /*========================= JS 4-2.7 ===============================*/
        $user = UserModel::with('level')->get();
        //  dd($user);
        return view('user', ['data' => $user]);
    }
}
