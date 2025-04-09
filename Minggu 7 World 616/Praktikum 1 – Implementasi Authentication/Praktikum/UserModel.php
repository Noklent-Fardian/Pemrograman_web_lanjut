<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable; // Import the Authenticatable class for user authentication

class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_user';  //mendefisikan nama table
    protected $primaryKey = 'user_id';   //mendefisikan nama primary key

    protected $fillable = [
        'level_id',
        'username',
        'nama',
        'password'
    ];
    protected $hidden = [
        'password'
    ]; //menyembunyikan password dari hasil query

    protected $casts = [
        'password' => 'hashed', //menggunakan casting hashed password
    ];

    
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'level_id', 'level_id');
    }
}