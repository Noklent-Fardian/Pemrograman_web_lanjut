<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Level;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Logger\ConsoleLogger;

class UserController extends Controller
{

    public function index()
    {

        $breadcrumb = [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];
        $page = (object)[
            'title' => 'Daftar User Yang Terdaftar Dalam Sistem'

        ];
        $activeMenu = 'user';
        $levels = Level::all(); // mengambil semua data level
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
            ->addColumn('AJAX', function ($user) {
                $btn = '<button onclick="modalAction(\'' . url('/user/show_ajax/' . $user->user_id) . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi', 'AJAX']) // memberitahu bahwa kolom aksi dan AJAX adalah html
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
        $level = Level::all();
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
        $level = Level::all();
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

    public function delete($id)
    {
        $check = UserModel::find($id);
        if (!$check) {
            // untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak 
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }
        try {
            UserModel::destroy($id); // Hapus data level 
            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error 
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function create_ajax()
    {
        $level = Level::select('level_id', 'level_nama')->get();
        return view('user.create_ajax', compact('level'));
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username',
                'nama' => 'required|string|max:100',
                'password' => 'required|min:6'
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors() // pesan error validasi
                ]);
            }

            UserModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    // Menampilkan halaman form edit user ajax
    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = Level::select('level_id', 'level_nama')->get();

        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax 
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                'nama'     => 'required|max:100',
                'password' => 'nullable|min:6|max:20'
            ];
            // use Illuminate\Support\Facades\Validator; 
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,    // respon json, true: berhasil, false: gagal 
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors()  // menunjukkan field mana yang error 
                ]);
            }

            $check = UserModel::find($id);
            if ($check) {
                if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari request 
                    $request->request->remove('password');
                }

                $check->update($request->all());
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $user = UserModel::find($id);

        return view('user.confirm_ajax', ['user' => $user]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);
            if ($user) {
                try {
                    $user->delete();
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil dihapus'
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak bisa dihapus'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
    public function showAjax($id)
    {
        $user = UserModel::with('level')->find($id);
        return view('user.show_ajax', compact('user'));
    }
    public function import()
    {
        return view('user.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // Validate file is xlsx format, max 1MB
                'file_user' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_user');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);
            $insert = [];
            $errors = [];
            $row = 1;

            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    $row++;
                    if ($baris > 1) { // Skip header row
                        // Check if level_id exists
                        $level = DB::table('m_level')->where('level_id', $value['A'])->first();
                        if (!$level) {
                            $errors[] = "Baris $row: Level ID tidak valid";
                            continue;
                        }


                        $insert[] = [
                            'level_id' => $value['A'],
                            'username' => $value['B'],
                            'nama' => $value['C'],
                            'password' => Hash::make($value['D']), // Hash the password
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }

                if (!empty($errors)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Terdapat kesalahan pada data',
                        'errors' => $errors
                    ]);
                }

                if (count($insert) > 0) {
                    UserModel::insertOrIgnore($insert);
                    return response()->json([
                        'status' => true,
                        'message' => 'Data user berhasil diimport'
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Tidak ada data yang diimport'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'File tidak berisi data yang valid'
                ]);
            }
        }
        return redirect('/user');
    }

    public function export_excel()
    {
        $users = UserModel::with('level')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'DAFTAR USER SISTEM');
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Username');
        $sheet->setCellValue('C2', 'Nama Lengkap');
        $sheet->setCellValue('D2', 'Level');
        $sheet->setCellValue('E2', 'Kode Level');

        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '8664bc']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];
        $sheet->getStyle('A2:E2')->applyFromArray($headerStyle);

        $sheet->getRowDimension(2)->setRowHeight(25);
        $sheet->freezePane('A3');

        $no = 1;
        $row = 3;
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $user->username);
            $sheet->setCellValue('C' . $row, $user->nama);
            $sheet->setCellValue('D' . $row, $user->level->level_nama);
            $sheet->setCellValue('E' . $row, $user->level->level_kode);

            $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ]);

            $row++;
            $no++;
        }

        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data User');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data User ' . date('Y-m-d H:i:s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer->save('php://output');
        exit;
    }
    public function export_pdf()
    {
        $users = UserModel::orderBy('user_id')
            ->with('level')
            ->get();

        $pdf = Pdf::loadView('user.export_pdf', ['users' => $users]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", false);
        $pdf->setOption("isPhpEnabled", false);
        $pdf->setOption("isHtml5ParserEnabled", true);

        return $pdf->stream('Data User ' . date('Y-m-d H:i:s') . '.pdf');
    }
    public function profile()
    {
        $breadcrumb = [
            'title' => 'Profil Pengguna',
            'list' => ['Home', 'Profil']
        ];

        $page = (object)[
            'title' => 'Pengaturan Profil'
        ];

        $activeMenu = 'profile';
        $user = Auth::user();

        return view('user.profile', compact('breadcrumb', 'page', 'activeMenu', 'user'));
    }

    public function updatePhoto(Request $request)
    {
        try {
            
            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $user = Auth::user();

            if ($request->hasFile('photo')) {
                // Get the uploaded file
                $file = $request->file('photo');

                // Create a unique filename
                $fileName = time() . '_' . $user->username . '.' . $file->getClientOriginalExtension();

                // Store the file in the public/img/user directory
                $file->move(public_path('img/user'), $fileName);

                // Delete old photo if it exists and is not the default
                if ($user->photo && $user->photo != 'default.png' && file_exists(public_path('img/user/' . $user->photo))) {
                    unlink(public_path('img/user/' . $user->photo));
                }

                UserModel::where('user_id', $user->user_id)->update([
                    'photo' => $fileName
                ]);
                return redirect()->route('profile')->with('success', 'photo profil berhasil diperbarui');
            }

            return redirect()->route('profile')->with('error', 'Gagal mengunggah photo');
        } catch (\Exception $e) {
            
            return redirect()->route('profile')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Verify the current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('profile')->with('error', 'Password saat ini tidak valid');
        }


        UserModel::where('user_id', $user->user_id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('profile')->with('success', 'Password berhasil diperbarui');
    }
}
