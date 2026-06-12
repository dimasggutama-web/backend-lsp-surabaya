<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JejaringLspBlk extends Model
{
    use HasFactory;
    protected $table = 'jejaring_lsp_blk_sby';
    protected $fillable = [
        'namaInstitusi',
        'alamat',
        'kota',
        'kodeInstitusi',
        'status'
    ];
    public function getNamaInstitusiAttribute($value)
    {
        return ucwords($value);
    }
}
