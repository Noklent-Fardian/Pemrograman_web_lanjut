<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenjualanDetail extends Model
{
    use HasFactory;

    protected $table = 't_penjualan_detail';  // Define the table name
    protected $primaryKey = 'penjualan_detail_id';  // Define the primary key

    protected $fillable = [
        'penjualan_id',
        'barang_id',
        'jumlah',
        'harga'
    ];

    /**
     * Get the penjualan associated with the penjualan detail.
     */
    public function penjualan(): BelongsTo
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id', 'penjualan_id');
    }

    /**
     * Get the barang associated with the penjualan detail.
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'barang_id');
    }
}