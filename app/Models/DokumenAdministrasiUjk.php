<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DokumenAdministrasiUjk extends Model
{
    use HasFactory;
    protected $table = 'dokumen_administrasi_ujk';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function jadwalAsesmen()
    {
        return $this->belongsTo(JadwalAsesmen::class, 'jadwal_asesmen_id');
    }
    public function pembuatDokumen()
    {
        return $this->belongsTo(User::class, 'upload_by');
    }
}
