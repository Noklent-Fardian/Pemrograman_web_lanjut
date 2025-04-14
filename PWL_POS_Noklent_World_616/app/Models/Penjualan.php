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

  
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

 
    public function details(): HasMany
    {
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id', 'penjualan_id');
    }

  
    public function getId()
    {
        return $this->penjualan_id;
    }
    
  
    public function getTanggal()
    {
        return $this->tanggal_penjualan;
    }
    
 
    public function getNamaPembeli()
    {
        return $this->pembeli; 
    }
    
   
    public function getTotalHarga()
    {
        // Calculate total from all items in detail
        $total = 0;
        foreach ($this->details as $detail) {
            $total += $detail->jumlah_barang * $detail->harga_barang;
        }
        return $total;
    }
    
 
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