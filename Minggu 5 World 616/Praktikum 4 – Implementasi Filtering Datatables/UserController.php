<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Monolog\Level;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LevelModel;

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
        // $user = UserModel::with('level')->get();
        // //  dd($user);
        // return view('user', ['data' => $user]);

        $breadcrumb = [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];
        $page = (object)[
            'title' => 'Daftar User Yang Terdaftar Dalam Sistem'

        ];
        $activeMenu = 'user';
        $levels = LevelModel::all(); // mengambil semua data level
        return view('user.index', compact('breadcrumb', 'page', 'activeMenu', 'levels'));
    }
    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->with('level');

        // Filter data user berdasarkan level_id 
        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($user) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/user/show/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/user/edit/' . $user->user_id . '/') . '"class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/delete/' . $user->user_id) . '">' . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }
    // create
    public function create()
    {
        $breadcrumb = [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];
        $page = (object)[
            'title' => 'Tambah User Baru'
        ];
        $level = LevelModel::all();
        $activeMenu = 'user';
        return view('user.create', compact('breadcrumb', 'page', 'activeMenu', 'level'));
    }

    public function store(Request $request) 
    { 
        $request->validate([ 
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_user kolom username 
            'username' => 'required|string|min:3|unique:m_user,username', 
            'nama' => 'required|string|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter 
            'password' => 'required|min:5', // password harus diisi dan minimal 5 karakter 
            'level_id' => 'required|integer' // level_id harus diisi dan berupa angka 
        ]); 
        
        UserModel::create([ 
            'username' => $request->username, 
            'nama' => $request->nama, 
            'password' => bcrypt($request->password), // password dienkripsi sebelum disimpan 
            'level_id' => $request->level_id 
        ]); 
        
        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    public function show($id)
    {
        $user = UserModel::with('level')->find($id);
        $breadcrumb = [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail User'
        ];
        $activeMenu = 'user';
        return view('user.show', compact('breadcrumb', 'page', 'activeMenu', 'user'));
    }

    public function edit($id)
    {
        $user = UserModel::find($id);
        $breadcrumb = [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit User'
        ];
        $level = LevelModel::all();
        $activeMenu = 'user';
        return view('user.edit', compact('breadcrumb', 'page', 'activeMenu', 'user', 'level'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id|max:20',
            'nama' => 'required|string|max:100',
            'password' => 'nullable|min:5',
            'level_id' => 'required|integer'
        ]);

        $data = [
            'username' => $request->username,
            'nama' => $request->nama,
            'level_id' => $request->level_id
        ];

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        UserModel::where('user_id', $id)->update($data);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }

public function delete($id){
    $check = UserModel::find($id); 
    if (!$check) { 
        // untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak 
        return redirect('/user')->with('error', 'Data user tidak ditemukan'); 
    }
    try{ 
        UserModel::destroy($id); // Hapus data level 
        return redirect('/user')->with('success', 'Data user berhasil dihapus'); 
    } catch (\Illuminate\Database\QueryException $e) { 
        // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error 
        return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
    }
}

}
