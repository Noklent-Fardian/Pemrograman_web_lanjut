<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'm_barang';  // Define the table name
    protected $primaryKey = 'barang_id';  // Define the primary key

    protected $fillable = [
        'kategori_id',
        'barang_kode',
        'barang_nama',
        'harga_jual',
        'harga_beli'
    ];

    /**
     * Get the kategori associated with the barang.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'kategori_id');
    }

    /**
     * Get the stocks associated with the barang.
     */
    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'barang_id', 'barang_id');
    }
}