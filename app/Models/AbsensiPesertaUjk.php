<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AbsensiPesertaUjk extends Model
{
    use HasFactory;
    protected $table = 'absensi_peserta_ujk';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function jadwalAsesmen()
    {
        return $this->belongsTo(JadwalAsesmen::class, 'jadwal_asesmen_id');
    }
    public function peserta()
    {
        return $this->belongsTo(PesertaPengajuanUjk::class, 'peserta_id');
    }
}
