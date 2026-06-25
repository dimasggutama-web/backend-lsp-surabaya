<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateFile extends Model
{
    protected $table = 'template_files';

    protected $fillable = [
        'nama',
        'nama_file',
        'mime_type',
        'data', // base64 encoded
    ];

    /**
     * Ambil template berdasarkan nama identifier.
     */
    public static function findByNama(string $nama): ?self
    {
        return static::where('nama', $nama)->first();
    }
}
