<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 't_penjualan';  // Define the table name
    protected $primaryKey = 'penjualan_id';  // Define the primary key

    protected $fillable = [
        'user_id',
        'pembeli',
        'penjualan_kode',
        'tanggal_penjualan'
    ];

    /**
     * Get the user associated with the penjualan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the details for this penjualan.
     */
    public function details(): HasMany
    {
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id', 'penjualan_id');
    }

    /**
     * Get transaction ID
     */
    public function getId()
    {
        return $this->penjualan_id;
    }
    
    /**
     * Get transaction date
     */
    public function getTanggal()
    {
        return $this->tanggal_penjualan;
    }
    
    /**
     * Get buyer name
     */
    public function getNamaPembeli()
    {
        return $this->pembeli; 
    }
    
    /**
     * Calculate total purchase price
     */
    public function getTotalHarga()
    {
        // Calculate total from all items in detail
        $total = 0;
        foreach ($this->details as $detail) {
            $total += $detail->jumlah_barang * $detail->harga_barang;
        }
        return $total;
    }
    
    /**
     * Get a formatted array of transaction data
     */
    public function getTransactionData()
    {
        return [
            'id' => $this->getId(),
            'tanggal' => $this->getTanggal(),
            'nama_pembeli' => $this->getNamaPembeli(),
            'total_harga' => $this->getTotalHarga()
        ];
    }
    public function prepareItemsData()
{
    $items = [];
    
    foreach ($this->details as $detail) {
        $items[] = [
            'kode_barang' => $detail->barang->barang_kode,
            'nama_barang' => $detail->barang->barang_nama,
            'qty' => $detail->jumlah,
            'harga' => $detail->harga,
            'subtotal' => $detail->jumlah * $detail->harga
        ];
    }
    
    return $items;
}
}