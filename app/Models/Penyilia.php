<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyilia extends Model
{
    use HasFactory;
    protected $table = 'penyilia_lsp';
    
    protected $fillable = [
        'namaPenyilia',
        'status',
        'jabatan',
        'noRegistrasi',
        'institusi',
        'alamat',
        'kota',
    ];

    public function getNamaPenyiliaAttribute($value)
    {
        return ucwords($value);
    }

}
