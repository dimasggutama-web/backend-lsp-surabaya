<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DokumenUploadLsp;
use App\Models\PengajuanUjkDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LspUploadController extends Controller
{
    public function uploadDokumenLsp(Request $request, $detail_id)
    {
        $validator = Validator::make($request->all(), [
            'jenis_dokumen' => 'required|in:surat_balasan,berita_acara_1,berita_acara_2,spt_asesor_1,spt_asesor_2',
            'file_dokumen'  => 'required|file|mimes:pdf|max:4096', 
        ], [
            'file_dokumen.required' => 'File dokumen wajib diunggah.',
            'file_dokumen.mimes'    => 'Validasi Gagal! Format file harus berupa PDF resmi.',
            'file_dokumen.max'      => 'Ukuran file terlalu besar, maksimal adalah 4MB.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengunggah dokumen.',
                'errors' => $validator->errors()
            ], 422);
        }

        $detail = PengajuanUjkDetail::with('pengajuan', 'dokumen_upload_lsp')->find($detail_id);
        if (!$detail) {
            return response()->json(['status' => 'error', 'message' => 'Detail pengajuan tidak ditemukan.'], 404);
        }

        try {
            $file = $request->file('file_dokumen');
            $namaAsli = $file->getClientOriginalName();
            
            $folderTujuan = 'dokumen_lsp/' . $request->jenis_dokumen;
            $pathFile = $file->store($folderTujuan, 'public');

            if ($request->jenis_dokumen === 'surat_balasan') {
                $searchAttributes = [
                    'pengajuan_ujk_id' => $detail->pengajuan_ujk_id,
                    'jenis_dokumen'    => 'surat_balasan'
                ];
                $saveData = [
                    'pengajuan_ujk_detail_id' => null, 
                    'nama_file'               => $namaAsli,
                    'path_file'               => $pathFile,
                    'uploaded_by'             => auth()->id()
                ];
            } else {
                $searchAttributes = [
                    'pengajuan_ujk_detail_id' => $detail_id,
                    'jenis_dokumen'           => $request->jenis_dokumen 
                ];
                $saveData = [
                    'pengajuan_ujk_id' => null, 
                    'nama_file'        => $namaAsli,
                    'path_file'        => $pathFile,
                    'uploaded_by'      => auth()->id()
                ];
            }

            $dokumen = DokumenUploadLsp::updateOrCreate($searchAttributes, $saveData);

            if ($request->jenis_dokumen === 'surat_balasan' && $detail->pengajuan) {
                $detail->pengajuan->update(['status' => 'Disetujui']);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Dokumen PDF resmi berhasil dipublikasikan.',
                'data' => $dokumen
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi gangguan sistem saat mengunggah berkas.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }
}