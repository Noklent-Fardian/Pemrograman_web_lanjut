<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';  // Define the table name
    protected $primaryKey = 'penjualan_id';  // Define the primary key

    protected $fillable = [
        'user_id',
        'barang_id',
        'jumlah',
        'total_harga'
    ];

    /**
     * Get the user associated with the penjualan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the barang associated with the penjualan.
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'barang_id');
    }
}