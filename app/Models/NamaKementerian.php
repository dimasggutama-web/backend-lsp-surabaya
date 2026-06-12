<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NamaKementerian extends Model
{
    use HasFactory;

    protected $table = 'nama_kementerian';

    protected $fillable = [
        'namaKementerian',
        'kodeKementerian',
        'status'
    ];

    public function getNamaKementerianAttribute($value)
    {
        return ucwords($value);
    }
}
