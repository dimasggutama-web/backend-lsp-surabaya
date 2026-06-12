<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pekerjaan extends Model
{
    use HasFactory;
    protected $table = 'pekerjaan';
    protected $fillable = [
        'namaPekerjaan',
        'kodePekerjaan',
        'status'
    ];
    public function getNamaPekerjaanAttribute($value)
    {
        return ucwords($value);
    }
}
