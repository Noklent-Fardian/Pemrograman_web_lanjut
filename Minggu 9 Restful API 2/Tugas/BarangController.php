<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    /**
     * Display a listing of products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::with('kategori')->get();
        return response()->json([
            'status' => true,
            'message' => 'Data barang berhasil diambil',
            'data' => $barang
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|string|max:10|unique:m_barang',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric|gte:harga_beli',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Data barang yang akan disimpan
        $barangData = [
            'kategori_id' => $request->kategori_id,
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
        ];

        // Upload gambar jika ada
        if ($request->hasFile('photo')) {
            $barangData['photo'] = $this->uploadImage($request->file('photo'));
        }

        $barang = Barang::create($barangData);

        return response()->json([
            'status' => true,
            'message' => 'Barang berhasil ditambahkan',
            'data' => $barang->load('kategori')
        ], 201);
    }

    /**
     * Update the specified product with image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'kategori_id' => 'sometimes|exists:m_kategori,kategori_id',
            'barang_kode' => 'sometimes|string|max:10|unique:m_barang,barang_kode,' . $id . ',barang_id',
            'barang_nama' => 'sometimes|string|max:100',
            'harga_beli' => 'sometimes|numeric',
            'harga_jual' => 'sometimes|numeric|gte:harga_beli',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Data barang yang akan diupdate
        $barangData = $request->only([
            'kategori_id',
            'barang_kode',
            'barang_nama',
            'harga_beli',
            'harga_jual'
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('photo')) {
            // Hapus gambar lama jika ada
            if ($barang->photo && file_exists(public_path('img/barang/' . $barang->photo))) {
                unlink(public_path('img/barang/' . $barang->photo));
            }

            $barangData['photo'] = $this->uploadImage($request->file('photo'));
        }

        $barang->update($barangData);

        return response()->json([
            'status' => true,
            'message' => 'Barang berhasil diupdate',
            'data' => $barang->fresh('kategori')
        ]);
    }

    /**
     * Get product image.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPhoto($id)
    {
        $barang = Barang::find($id);

        if (!$barang || !$barang->photo) {
            return response()->json([
                'status' => false,
                'message' => 'Foto barang tidak ditemukan'
            ], 404);
        }

        $imagePath = public_path('img/barang/' . $barang->photo);

        if (!file_exists($imagePath)) {
            return response()->json([
                'status' => false,
                'message' => 'File foto tidak ditemukan'
            ], 404);
        }

        // Return the image URL
        $imageUrl = url('img/barang/' . $barang->photo);

        return response()->json([
            'status' => true,
            'message' => 'Foto barang berhasil diambil',
            'data' => [
                'photo_url' => $imageUrl,
                'barang_id' => $barang->barang_id,
                'barang_nama' => $barang->barang_nama
            ]
        ]);
    }

    /**
     * Helper function to upload images.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return string
     */
    private function uploadImage($file)
    {
        // Generate a unique filename
        $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

        // Make sure the directory exists
        if (!file_exists(public_path('img/barang'))) {
            mkdir(public_path('img/barang'), 0777, true);
        }

        // Move the file to the public/img/barang directory
        $file->move(public_path('img/barang'), $fileName);

        return $fileName;
    }
    /**
     * Display the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $barang = Barang::with(['kategori', 'stocks'])->find($id);

        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail barang berhasil diambil',
            'data' => $barang
        ]);
    }
    /**
     * Remove the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }

        // Check if product has associated stock items
        if ($barang->stocks()->count() > 0) {
            return response()->json([
                'status' => false,
                'message' => 'Barang tidak dapat dihapus karena masih memiliki stok terkait'
            ], 422);
        }

        $barang->delete();

        return response()->json([
            'status' => true,
            'message' => 'Barang berhasil dihapus'
        ]);
    }
}
