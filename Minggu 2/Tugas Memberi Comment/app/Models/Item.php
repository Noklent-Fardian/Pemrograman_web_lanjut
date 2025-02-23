<?php
// Commitan setelah dipindahkan
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory; // 
    protected $fillable = [ 
        'name', 
        'description',
    ]; // membuat mass assignment atau mengizinkan kolom name dan description untuk diisi pada tabel items
}