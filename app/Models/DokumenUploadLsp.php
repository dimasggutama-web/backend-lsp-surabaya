<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenUploadLsp extends Model
{
    protected $table = 'dokumen_upload_lsp';
    protected $fillable = [
    'pengajuan_ujk_id',
    'pengajuan_ujk_detail_id', 
    'jenis_dokumen', 
    'nama_file', 
    'path_file', 
    'uploaded_by'
];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
