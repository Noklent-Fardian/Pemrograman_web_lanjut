<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\User;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenjualanController extends Controller
{
    public function index()
    { // Get all penjualan records
        $penjualanList = Penjualan::with(['user', 'details.barang'])->get();

        // Prepare transaction data for display
        $transactions = [];
        foreach ($penjualanList as $penjualan) {
            $transactions[] = $penjualan->getTransactionData();
        }

        // Pass data to the view
        return view('penjualan.index', compact('transactions'));
    }

    public function create()
    {
        // Get users and barang for dropdowns
        $users = User::all();
        $barangs = Barang::all();

        return view('penjualan.create', compact('users', 'barangs'));
    }

    public function store(Request $request)
    {
        // Validate the main transaction data
        $request->validate([
            'user_id' => 'required|exists:m_user,user_id',
            'tanggal' => 'required|date',
            'barang_id' => 'required|array',
            'barang_id.*' => 'exists:m_barang,barang_id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
            'harga' => 'required|array',
            'harga.*' => 'numeric|min:0',
        ]);

        // Begin a database transaction
        DB::beginTransaction();

        try {
            // Calculate total from all items
            $total = 0;
            foreach ($request->jumlah as $key => $jumlah) {
                $total += $jumlah * $request->harga[$key];
            }

            // Create the penjualan (transaction header)
            $penjualan = Penjualan::create([
                'user_id' => $request->user_id,
                'tanggal' => $request->tanggal,
                'total_harga' => $total,
            ]);

            // Create the penjualan_detail records (transaction details)
            foreach ($request->barang_id as $key => $barang_id) {
                PenjualanDetail::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id' => $barang_id,
                    'jumlah' => $request->jumlah[$key],
                    'harga' => $request->harga[$key],
                ]);

                // You could also update stock here if needed
            }

            // Commit the transaction
            DB::commit();

            return redirect()->route('penjualan.index')
                ->with('success', 'Transaksi berhasil dibuat');
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        // Get the penjualan with its details and relationships
        $penjualan = Penjualan::with(['user', 'details.barang'])
            ->findOrFail($id);
        
        // Prepare items data for display
        $items = $penjualan->prepareItemsData();
        
        return view('penjualan.show', compact('penjualan', 'items'));
    }
    
}
