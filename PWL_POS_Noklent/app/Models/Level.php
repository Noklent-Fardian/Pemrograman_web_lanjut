<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    use HasFactory;

    protected $table = 'm_level';  // Define the table name
    protected $primaryKey = 'level_id';  // Define the primary key

    protected $fillable = [
        'level_kode',
        'level_nama'
    ];

    /**
     * Get the users associated with the level.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'level_id', 'level_id');
    }
}