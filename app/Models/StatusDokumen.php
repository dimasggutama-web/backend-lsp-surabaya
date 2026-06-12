<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusDokumen extends Model
{
    protected $table = 'status_dokumen';
    protected $fillable = [
        'pengajuan_ujk_detail_id', 'kategori', 'nama_surat', 'status', 'user_id', 'waktu_cetak'
    ];

    public function pengajuanUjkDetail()
    {
        return $this->belongsTo(PengajuanUjkDetail::class, 'pengajuan_ujk_detail_id');
    }
}
