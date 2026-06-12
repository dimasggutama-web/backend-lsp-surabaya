<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenugasanAsesor extends Model
{
    use HasFactory;
    protected $table = 'penugasan_asesor';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function jadwalAsesmen()
    {
        return $this->belongsTo(JadwalAsesmen::class, 'jadwal_asesmen_id');
    }
    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'asesor_id');
    }
}
