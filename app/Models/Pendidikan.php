<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pendidikan extends Model
{
    use HasFactory;

    protected $table = 'pendidikan';

    protected $fillable = [
        'namaPendidikan',
        'kodePendidikan',
        'status'
    ];

    public function getNamaPendidikanAttribute($value)
    {
        return ucwords($value);
    }
}
