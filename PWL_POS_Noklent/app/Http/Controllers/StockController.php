<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\StockDataTable;
use App\Models\Stock;
use App\Models\Barang;
use App\Models\User;

class StockController extends Controller
{
    public function index(StockDataTable $dataTable)
    {
        return $dataTable->render('stock.index');
    }

    public function create()
    {
        $barangs = Barang::all();
        $users = User::all();
        return view('stock.create', compact('barangs', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:m_barang,barang_id',
            'user_id' => 'required|exists:m_user,user_id',
            'stok_tanggal_masuk' => 'required|date',
            'stok_jumlah' => 'required|integer|min:1',
        ]);

        $existingStock = Stock::where('barang_id', $request->barang_id)->first();

        if ($existingStock) {
            // If stock with same nama barang exists, increment the quantity
            $existingStock->update([
            'stok_jumlah' => $existingStock->stok_jumlah + $request->stok_jumlah,
            'stok_tanggal_masuk' => $request->stok_tanggal_masuk,
            'user_id' => $request->user_id,
            ]);
        } else {
            // If no stock with same barang_id, create new record
            Stock::create([
            'barang_id' => $request->barang_id,
            'user_id' => $request->user_id,
            'stok_tanggal_masuk' => $request->stok_tanggal_masuk,
            'stok_jumlah' => $request->stok_jumlah,
            ]);
        }

        return redirect()->route('stock.index')->with('status', 'Data stock berhasil ditambahkan');
    }

    public function edit($id)
    {
        $stock = Stock::findOrFail($id);
        $barangs = Barang::all();
        $users = User::all();
        return view('stock.edit', compact('stock', 'barangs', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'required|exists:m_barang,barang_id',
            'user_id' => 'required|exists:m_user,user_id',
            'stok_tanggal_masuk' => 'required|date',
            'stok_jumlah' => 'required|integer|min:1',
        ]);

        $stock = Stock::findOrFail($id);
        $stock->update([
            'barang_id' => $request->barang_id,
            'user_id' => $request->user_id,
            'stok_tanggal_masuk' => $request->stok_tanggal_masuk,
            'stok_jumlah' => $request->stok_jumlah,
        ]);

        return redirect()->route('stock.index')->with('status', 'Data stok berhasil diperbarui');
    }

    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return redirect()->route('stock.index')->with('status', 'Data stok berhasil dihapus');
    }
}