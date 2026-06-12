<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalAsesmen extends Model
{
    use HasFactory;
    protected $table = 'jadwal_asesmen';
    protected $guarded = ['id', 'created_at', 'updated_at'];    

    public function pengajuanUjkDetail()
    {
        return $this->belongsTo(PengajuanUjkDetail::class, 'pengajuan_ujk_detail_id');
    }
    public function penyilia()
    {
        return $this->belongsTo(Penyilia::class, 'penyilia_id');
    }
    public function penugasanAsesor()
    {
        return $this->hasMany(PenugasanAsesor::class, 'jadwal_asesmen_id');
    }
    public function dokumenAdministrasi()
    {
        return $this->hasMany(DokumenAdministrasiUjk::class, 'jadwal_asesmen_id');
    }
    public function absensiPesertaUjk()
    {
        return $this->hasMany(AbsensiPesertaUjk::class, 'jadwal_asesmen_id');
    }
}
