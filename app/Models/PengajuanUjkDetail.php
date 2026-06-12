<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengajuanUjkDetail extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_ujk_details';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = ['status_ploting'];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanUjk::class, 'pengajuan_ujk_id');
    }

    public function skema()
    {
        return $this->belongsTo(DataSkemaSertifikasi::class, 'skema_id');
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id'); 
    }

    public function pesertaPengajuanUjk()
    {
        return $this->hasMany(PesertaPengajuanUjk::class, 'pengajuan_ujk_detail_id');
    }

    public function jadwalAsesmen()
    {
        return $this->hasOne(JadwalAsesmen::class, 'pengajuan_ujk_detail_id');
    }

    public function getStatusPlotingAttribute()
    {
        if ($this->status_pengajuan === 'Dibatalkan') {
            return 'Dibatalkan';
        }

        return $this->jadwalAsesmen ? 'Selesai Diplot' : 'Belum Diplot';
    }

    public function tuk()
    {
        return $this->belongsTo(JejaringLspBlk::class, 'jejaring_id');
    }

    public function statusDokumen()
    {
        return $this->hasMany(StatusDokumen::class, 'pengajuan_ujk_detail_id');
    }
    public function dokumen_upload_lsp()
    {
        return $this->hasMany(DokumenUploadLsp::class, 'pengajuan_ujk_detail_id', 'id');
    }
}
