<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class PesertaPengajuanUjk extends Model
{
    use HasFactory;

    protected $table = 'peserta_pengajuan_ujk';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function pengajuanDetail()
    {
        return $this->belongsTo(PengajuanUjkDetail::class, 'pengajuan_ujk_detail_id');
    }
    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'asesor_id');
    }
    public function sertifikat()
    {
        return $this->hasOne(SertifikatAsesi::class, 'peserta_pengajuan_ujk_id');
    }
    public function detailPengajuan()
    {
        return $this->belongsTo(PengajuanUjkDetail::class, 'pengajuan_ujk_detail_id');
    }
}
