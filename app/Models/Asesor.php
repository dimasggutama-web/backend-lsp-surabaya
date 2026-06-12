<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesor extends Model
{
    use HasFactory;

    protected $table = 'asesor';

    protected $fillable = [
        'user_id',
        'noRegistrasi',
        'masa_berlaku_sertifikat',
        'sertifikat',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function bidang()
    {
        return $this->belongsToMany(Bidang::class, 'asesor_bidang', 'asesor_id', 'bidang_id');
    }
    public function skema()
    {
        return $this->belongsToMany(DataSkemaSertifikasi::class, 'asesor_skema', 'asesor_id', 'skema_id');
    }
    public function penugasanAsesor()
    {
        return $this->hasMany(PenugasanAsesor::class, 'asesor_id');
    }
}
