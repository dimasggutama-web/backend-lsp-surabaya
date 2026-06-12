<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengajuanUjk extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_ujk';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function detailSkema()
    {
        return $this->hasMany(PengajuanUjkDetail::class, 'pengajuan_ujk_id', 'id')->with('skema');
    }

    public function skemas()
    {
        return $this->belongsToMany(DataSkemaSertifikasi::class, 'pengajuan_skema', 'pengajuan_id', 'skema_id')
            ->withPivot('jejaring_id') 
            ->withTimestamps();
    }

    public function adminBlk()
    {
        return $this->belongsTo(User::class, 'admin_blk_id');
    }

    public function jejaring()
    {
        return $this->belongsTo(JejaringLspBlk::class, 'jejaring_id');
    }
    
    public function sumberAnggaran()
    {
        return $this->belongsTo(SumberAnggaran::class, 'sumber_anggaran_id');
    }

    public function details()
    {
        return $this->hasMany(PengajuanUjkDetail::class, 'pengajuan_ujk_id');
    }
    public function dokumen_upload_lsp()
    {
        return $this->hasMany(DokumenUploadLsp::class, 'pengajuan_ujk_id', 'id');
    }
}
