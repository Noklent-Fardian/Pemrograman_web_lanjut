<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    use HasFactory;

    protected $table = 't_stock';  // Define the table name
    protected $primaryKey = 'stock_id';  // Define the primary key

    protected $fillable = [
        'barang_id',
        'user_id',
        'stok_tanggal_masuk',
        'stok_jumlah'
    ];

    /**
     * Get the barang associated with the stock.
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'barang_id');
    }

    /**
     * Get the user associated with the stock.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}