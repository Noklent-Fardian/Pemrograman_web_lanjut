<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Model
{
    use HasFactory;
    
    protected $table = 'm_user';  // Define the table name
    protected $primaryKey = 'user_id';  // Define the primary key

    protected $fillable = [
        'level_id',
        'username',
        'nama',
        'password'
    ];

    /**
     * Get the level associated with the user.
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'level_id', 'level_id');
    }
}