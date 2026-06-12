<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataSkemaSertifikasi extends Model
{
    use HasFactory;

    protected $table = 'data_skema_sertifikasi_lsp_blk_sby';

    protected $fillable = [
        'namaSkema',
        'kodeSkema',
        'profesi',
        'bidang_id',
        'jenisSkema',
        'status'
    ];

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }
}
