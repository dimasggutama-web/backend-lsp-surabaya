<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'username',
        'password',
        'role',
        'status',
        'instansi_id',
        'email',
        'tanggalLahir',
        'jenisKelamin',
        'fotoProfil',
        'namaLengkap',
        'nomorTelpon',
        'alamatDomisili',   
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isSuperAdmin()
    {
        return $this->role === 'superAdmin';
    }
    public function asesor()
    {
        return $this->hasOne(Asesor::class, 'user_id');
    }
    public function tuk()
    {
        return $this->belongsToMany(
            \App\Models\JejaringLspBlk::class, 
            'akses_admin_tuk', 
            'user_id',       
            'jejaring_id'
        );
    }
    public function instansi()
    {
        return $this->belongsTo(\App\Models\JejaringLspBlk::class, 'instansi_id');
    }

    public function penugasanAsesor()
    {
        // Relasi ke tabel penugasan_asesors
        return $this->hasManyThrough(PenugasanAsesor::class, Asesor::class, 'user_id', 'asesor_id');
    }
} 