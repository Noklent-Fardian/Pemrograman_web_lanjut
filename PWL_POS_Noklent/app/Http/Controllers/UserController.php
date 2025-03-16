<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Level;
use App\DataTables\UserDataTable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(UserDataTable $dataTable)
    {
               /*========================= JS 3 ===============================*/
    // $data = [
    //     'username' =>'Pelanggan 1'
    // ];
    // UserModel::where('username', 'customer-1')->update($data);
    // $data = UserModel::all(); //mengambil semua data dari tabel m_user
    // return view('user', ['data' => $data]); 

    /*========================= JS 4 ===============================*/
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
        // $user = User::with('level')->get();
        // //  dd($user);
        // return view('user', ['data' => $user]);
        return $dataTable->render('user.index');
    }

    public function tambah()
    {
        // Get all levels for the dropdown selection
        $levels = Level::all();
        return view('user.create', compact('levels'));
    }

    public function tambah_simpan(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:20|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|string|min:5',
            'level_id' => 'required|exists:m_level,level_id',
        ]);

        User::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id,
        ]);

        return redirect('/user')->with('status', 'Data user berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $levels = Level::all();
        return view('user.edit', compact('user', 'levels'));
    }

    public function ubah_simpan($id, Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:20|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|string|max:100',
            'level_id' => 'required|exists:m_level,level_id',
        ]);

        $user = User::findOrFail($id);
        
        $data = [
            'username' => $request->username,
            'nama' => $request->nama,
            'level_id' => $request->level_id,
        ];

        // Only update password if it's provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect('/user')->with('status', 'Data user berhasil diperbarui');
    }

    public function hapus($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/user')->with('status', 'Data user berhasil dihapus');
    }
}