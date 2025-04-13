<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
            ->addColumn('AJAX', function ($level) {
                $btn = '<button onclick="modalAction(\'' . url('/level/show_ajax/' . $level->level_id) . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi', 'AJAX'])
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


    public function showAjax($id)
    {
        $level = Level::find($id);
        return view('level.show_ajax', compact('level'));
    }

    public function create_ajax()
    {
        return view('level.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // Check if request is AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|max:10|unique:m_level,level_kode',
                'level_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            Level::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data level berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $level = Level::find($id);
        return view('level.edit_ajax', compact('level'));
    }

    public function update_ajax(Request $request, $id)
    {
        // Check if request is AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|max:10|unique:m_level,level_kode,' . $id . ',level_id',
                'level_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $level = Level::find($id);
            if ($level) {
                $level->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data level berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data level tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $level = Level::find($id);
        return view('level.confirm_ajax', ['level' => $level]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // Check if request is AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $level = Level::find($id);
            if ($level) {
                try {
                    $level->delete();
                    return response()->json([
                        'status' => true,
                        'message' => 'Data level berhasil dihapus'
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data level tidak bisa dihapus karena masih digunakan'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data level tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }


    public function import()
    {
        return view('level.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_level' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_level');
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
                        if (empty($value['A']) || empty($value['B'])) {
                            $errors[] = "Baris $row: Kode Level dan Nama Level harus diisi";
                            continue;
                        }

                        $insert[] = [
                            'level_kode' => $value['A'],
                            'level_nama' => $value['B'],
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
                    Level::insertOrIgnore($insert);
                    return response()->json([
                        'status' => true,
                        'message' => 'Data level berhasil diimport'
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
        return redirect('/level');
    }
}
