<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SertifikatAsesi extends Model
{
    use HasFactory;

    protected $table = 'sertifikat_asesi';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function pesertaPengajuanUjk()
    {
        return $this->belongsTo(PesertaPengajuanUjk::class, 'peserta_pengajuan_ujk_id');
    }
}