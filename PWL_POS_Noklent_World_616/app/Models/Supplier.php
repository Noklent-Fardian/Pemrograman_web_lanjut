<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'm_supplier';  // Define the table name
    protected $primaryKey = 'supplier_id';  // Define the primary key

    protected $fillable = [
        'supplier_kode',
        'name_supplier',
        'supplier_contact',
        'supplier_alamat',
        'supplier_email',
        'supplier_aktif',
        'supplier_keterangan'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'supplier_aktif' => 'boolean',
    ];

   
    public function scopeActive($query)
    {
        return $query->where('supplier_aktif', true);
    }

    /**
     * Get supplier status as a formatted badge.
     *
     * @return string
     */
    public function getStatusBadgeAttribute()
    {
        return $this->supplier_aktif
            ? '<span class="badge badge-success">Aktif</span>'
            : '<span class="badge badge-danger">Tidak Aktif</span>';
    }
}