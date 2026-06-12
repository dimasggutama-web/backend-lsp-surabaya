<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Asesor;
use App\Models\PenugasanAsesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Log;       
use Carbon\Carbon;

class AsesorController extends Controller
{

    public function getJadwalPenugasan(Request $request)
    {
        try {
            $user = Auth::user();

            if ($user->role !== 'asesor') {
                return response()->json([
                    'success' => false, 
                    'message' => 'Akses ditolak. Anda bukan asesor.'
                ], 403);
            }

            $asesor = Asesor::where('user_id', $user->id)->first();

            if (!$asesor) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Data detail asesor tidak ditemukan.'
                ], 404);
            }

            $penugasan = PenugasanAsesor::with([
                    'jadwalAsesmen.pengajuanUjkDetail.skema', 
                    'jadwalAsesmen.pengajuanUjkDetail.tuk' 
                ])
                ->where('asesor_id', $asesor->id)
                ->get();

            $dataTabel = $penugasan->map(function ($item) {
                $jadwal = $item->jadwalAsesmen;
                
                $detailPengajuan = optional($jadwal)->pengajuanUjkDetail;
                
                return [
                    'id_penugasan'   => $item->id, 
                    'pengajuan_ujk_detail_id' => optional($detailPengajuan)->id,
                    'tanggal'        => optional($jadwal)->tanggal_mulai_asesmen ? Carbon::parse($jadwal->tanggal_mulai_asesmen)->translatedFormat('d F Y') : '-', 
                    'skema_judul'    => optional(optional($detailPengajuan)->skema)->namaSkema ?? '-', 
                    'lokasi_tuk'     => optional(optional($detailPengajuan)->tuk)->namaInstitusi ?? '-',
                    'jumlah_peserta' => optional($detailPengajuan)->jumlah_peserta ?? 0, 
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil daftar penugasan asesor',
                'data'    => $dataTabel
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error getJadwalPenugasan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat mengambil jadwal.',
                'error'   => env('APP_DEBUG') ? $e->getMessage() : 'Internal Server Error'
            ], 500);
        }
    }

    public function getAllAsesor (Request $request)
    {
        try {
            $query = Asesor::with(['skema', 'user']);
            $filterStatus = $request->query('status');

            if ($filterStatus === 'semua') {
            } elseif ($filterStatus === 'non-aktif' || $filterStatus === 'Non-aktif') {
                $query->whereHas('user', function ($q) {
                    $q->where('status', 'Non-aktif'); 
                });
            } else {
                $query->whereHas('user', function ($q) {
                    $q->where('status', 'Aktif');
                });
            }

            $asesor = $query->get();

            if ($asesor->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Belum ada data asesor yang sesuai filter.',
                    'data' => []
                ], 200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengambil data asesor',
                'data' => $asesor
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'terjadi kesalahan saat mengambil data asessor',
                'error_detail' => $e->getMessage() 
            ], 500);
        }
    }

    public function getAsesorBySkema(Request $request, $skema_id)
    {
        $tanggal_mulai = $request->query('tanggal_mulai');
        $tanggal_selesai = $request->query('tanggal_selesai');

        $asesorValid = Asesor::with('user')->withCount('penugasanAsesor')
        ->whereHas('skema', function ($query) use ($skema_id) {
            $query->where('skema_id', $skema_id); 
        })->whereHas('user', function ($query){
            $query->where('status', 'Aktif');
        })->orderBy('penugasan_asesor_count', 'asc') 
        ->get();

        if ($asesorValid->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada Asesor yang menguasai skema ini.'
            ], 404);
        }

        if ($tanggal_mulai && $tanggal_selesai) {
            $asesorDenganStatus = $asesorValid->map(function ($asesor) use ($tanggal_mulai, $tanggal_selesai) {
                $bentrok = PenugasanAsesor::where('asesor_id', $asesor->id)
                ->whereHas('jadwalAsesmen', function ($query) use ($tanggal_mulai, $tanggal_selesai) {
                    $query->where(function($q) use ($tanggal_mulai, $tanggal_selesai) {
                        $q->where('tanggal_mulai_asesmen', '<=', $tanggal_selesai)
                          ->where('tanggal_selesai_asesmen', '>=', $tanggal_mulai);
                    });
                }) ->exists();

                $asesorArray = $asesor->toArray();
                $asesorArray['is_available'] = !$bentrok;
                $asesorArray['status_jadwal'] = $bentrok ? 'Jadwal Penuh/Bentrok' : 'Tersedia';

                return $asesorArray;
            });
            return response()->json([
                'status' => 'success',
                'data' => $asesorDenganStatus
            ], 200);
        }
        return response()->json([
            'status' => 'success',
            'data' => $asesorValid
        ], 200);
    }

    public function statusAsesor($id)
    {
        try {
            $asesor = Asesor::with('user')->find($id);
            if (!$asesor || !$asesor->user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data Asesor atau Akun login tidak ditemukan'
                ], 404);
            }
            $user = $asesor->user;
            $statusBaru = ($user->status === 'Aktif') ? 'Non-aktif' : 'Aktif';

            $user->update([
                'status' => $statusBaru
            ]);

            return response()->json([
                'status' => 'success',
                'message' => "Status akun Asesor berhasil diubah menjadi {$statusBaru}.",
                'data' => [
                    'asesor_id' => $asesor->id,
                    'status_sekarang' => $statusBaru
                ]    
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem saat mengubah status.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }

    public function dataAsesor(Request $request)
    {
        $user = auth()->user();
        
        if ($user->role !== 'asesor') {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak. Anda bukan asesor.'
            ], 403);
        }
        $isUpdate = $user->asesor()->exists();
        $ruleRequired = $isUpdate ? 'nullable' : 'required';

        $validator = Validator::make($request->all(), [
            'noRegistrasi' => "{$ruleRequired}|string|unique:asesor,noRegistrasi," . optional($user->asesor)->id,
            'masa_berlaku_sertifikat' => 'nullable|date',
            'bidang_id'    => "{$ruleRequired}|array",
            'bidang_id.*'  => 'exists:bidang,id',
            'skema_id'     => "{$ruleRequired}|array",
            'skema_id.*'   => 'exists:data_skema_sertifikasi_lsp_blk_sby,id',
            'sertifikat'   => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal! Periksa kembali data yang Anda masukkan.',
                'errors' => $validator->errors()
            ], 422); 
        }

        try {
            $dataToSave = [];

            if ($request->has('noRegistrasi')) {
                $dataToSave['noRegistrasi'] = $request->noRegistrasi;
            }
            if ($request->has('masa_berlaku_sertifikat')) {
                $dataToSave['masa_berlaku_sertifikat'] = $request->masa_berlaku_sertifikat;
            }
            if ($request->hasFile('sertifikat')) {
                $dataToSave['sertifikat'] = $request->file('sertifikat')->store('sertifikat_asesor', 'public');
            }
            $asesor = $user->asesor()->updateOrCreate(
                ['user_id' => $user->id],
                $dataToSave               
            );

            if ($request->has('bidang_id')) {
                $asesor->bidang()->sync($request->bidang_id);
            }
            if ($request->has('skema_id')) {
                $asesor->skema()->sync($request->skema_id);
            }

            $asesor->load('bidang', 'skema'); 

            return response()->json([
                'status' => 'success',
                'message' => 'Data asesor berhasil disimpan/diperbarui.',
                'data' => $asesor
            ], 201);

        } catch (\Exception $e) {
            Log::error('Asesor Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    public function getDataAsesor()
    {
        $user = auth()->user();
        
        if ($user->role !== 'asesor') {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak. Anda bukan asesor.'
            ], 403);
        }

        $asesor = $user->asesor()->with('bidang', 'skema')->first();

        if (!$asesor) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data asesor masih kosong.',
                'data' => null
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'data' => $asesor
        ]);
    }  

    public function getHistoryBebanKerja()
    {
        $rekapAsesor = User::where('role', 'asesor')
            ->where('status', 'aktif') 
            // withCount buat ngitung berapa kali user ini ada di tabel penugasan_asesors
            ->withCount('penugasanAsesor') 
            ->orderBy('penugasan_asesor_count', 'asc') // Urutin dari yang paling nganggur
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $rekapAsesor
        ]);
    }

    public function getDokumenAsesor($detail_id)
    {
        $dokumen = \App\Models\DokumenUploadLsp::where('pengajuan_ujk_detail_id', $detail_id)
            ->whereIn('jenis_dokumen', ['spt_asesor_1', 'spt_asesor_2', 'berita_acara_1', 'berita_acara_2'])
            ->get();

        if ($dokumen->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Belum ada dokumen resmi untuk jadwal ini.',
                'data' => []
            ], 200);
        }

        $dataResponse = $dokumen->map(function ($doc) {
            return [
                'id' => $doc->id,
                'pengajuan_ujk_detail_id' => $doc->pengajuan_ujk_detail_id,
                'jenis_dokumen' => $doc->jenis_dokumen, 
                'nama_file' => $doc->nama_file,
                'url_download' => url('/api/asesor/download-file/' . $doc->id),
                'uploaded_at' => $doc->created_at->format('Y-m-d H:i:s')
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $dataResponse
        ], 200);
    }
    public function downloadDokumenFisik($id)
    {
        $dokumen = \App\Models\DokumenUploadLsp::find($id);
        
        if (!$dokumen || !file_exists(storage_path('app/public/' . $dokumen->path_file))) {
            return response()->json(['message' => 'File tidak ditemukan di server'], 404);
        }

        return response()->file(storage_path('app/public/' . $dokumen->path_file));
    }
}