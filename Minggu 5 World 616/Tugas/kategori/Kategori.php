<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'm_kategori';  // Define the table name
    protected $primaryKey = 'kategori_id';  // Define the primary key

    protected $fillable = [
        'kategori_kode',
        'kategori_nama'
    ];

    /**
     * Get the barangs associated with the kategori.
     */
    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class, 'kategori_id', 'kategori_id');// Define the relationship
    }
}