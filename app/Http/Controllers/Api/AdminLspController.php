<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\JadwalAsesmen;
use App\Models\PenugasanAsesor;
use App\Models\PengajuanUjk;
use App\Models\PengajuanUjkDetail;
use App\Models\PesertaPengajuanUjk;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Validation\Rule;

class AdminLspController extends Controller
{
    public function getAllPengajuan()
    {
        $data = PengajuanUjkDetail::whereHas('pengajuan', function ($query) {
            $query->whereIn('status', ['Menunggu', 'Disetujui']);
        })
        ->with([
            'pengajuan', 
            'skema', 
            'tuk',
            'jadwalAsesmen.penyilia', 
            'jadwalAsesmen.penugasanAsesor.asesor.user',
            'pesertaPengajuanUjk',
            'pengajuan.sumberAnggaran',
            'bidang',
            'statusDokumen',
            'pengajuan.dokumen_upload_lsp', 
            'dokumen_upload_lsp'
        ])
        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function getPengajuanSiapPloting ()
    {
        $pengajuanDetail = PengajuanUjkDetail::with([
            'pengajuan', 
            'pengajuan.dokumen_upload_lsp',
            'dokumen_upload_lsp',
            'pesertaPengajuanUjk',
            'skema',
            'tuk'
            ])
            ->whereHas('pengajuan', function ($query) {
                $query->whereIn ('status', ['Menunggu', 'Disetujui']);
            })
            ->doesntHave('jadwalAsesmen')
            ->get();

        if ($pengajuanDetail->isEmpty()) {
            return response()->json(['status'=>'error', 'message'=>'Data Pengajuan tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $pengajuanDetail
        ], 200);
    }

    public function plotingJadwal(Request $request, $detail_id)
    {
        $validator = Validator::make($request->all(), [
            'penyilia_id'             => 'required|exists:penyilia_lsp,id',
            'tanggal_mulai_asesmen'   => 'required|date',
            'tanggal_selesai_asesmen' => 'required|date|after_or_equal:tanggal_mulai_asesmen',
            'asesor_ids'              => 'required|array|min:1', 
            'asesor_ids.*'            => 'required|exists:asesor,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak lengkap atau format salah',
                'errors' => $validator->errors()
            ], 422);
        }

        $pengajuanDetail = PengajuanUjkDetail::with('pengajuan')->find($detail_id);

        if (!$pengajuanDetail || !$pengajuanDetail -> pengajuan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data pengajuan tidak ditemukan.'
            ], 404);
        }

        $statusInduk = $pengajuanDetail->pengajuan->status;

        if ($statusInduk !== 'Menunggu') {
            return response()->json([
                'status' => 'error',
                'message' => "Gagal ploting! Ploting jadwal hanya bisa dilakukan untuk pengajuan yang berstatus 'Menunggu'. Status pengajuan saat ini adalah '{$statusInduk}'."
            ], 403); 
        }

        $penyilia = \App\Models\Penyilia::find($request->penyilia_id);
        if ($penyilia && $penyilia->status !== 'Aktif') {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi Gagal! Penyilia yang dipilih saat ini berstatus Non-aktif.'
            ], 422);
        }

        $skemaId = $pengajuanDetail->skema_id; 

        $jumlahAsesorValid = Asesor::whereIn('id', $request->asesor_ids)
            ->whereHas('skema', function ($query) use ($skemaId) {
                $query->where('skema_id', $skemaId); 
            }) 
            ->whereHas('user', function ($query) {
                $query->where('status', 'Aktif');
            })
            ->count();
            
        if ($jumlahAsesorValid !== count($request->asesor_ids)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi Gagal! Terdapat Asesor yang dipilih namun tidak menguasai Skema Kompetensi ini.'
            ], 422);
        }

        $tukId = $pengajuanDetail->jejaring_id; 

        $penyiliaBentrok = JadwalAsesmen::where('penyilia_id', $request->penyilia_id)
            ->where(function($q) use ($request) {
                $q->where('tanggal_mulai_asesmen', '<=', $request->tanggal_selesai_asesmen)
                  ->where('tanggal_selesai_asesmen', '>=', $request->tanggal_mulai_asesmen);
            })
            ->whereHas('pengajuanUjkDetail', function ($q) use ($tukId, $skemaId) {
                // Bentrok jika di waktu yang sama, dia ditugaskan di TUK lain
                // ATAU di waktu & TUK yang sama, tapi ngerjain skema yang sama (duplicate)
                $q->where('jejaring_id', '!=', $tukId)
                  ->orWhere('skema_id', $skemaId);
            })
            ->first();

        if ($penyiliaBentrok) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal ploting! Penyilia sudah memiliki jadwal UJK di rentang tanggal tersebut dengan TUK/Skema yang bentrok.'
            ], 422);
        }

        $asesorBentrok = PenugasanAsesor::whereIn('asesor_id', $request->asesor_ids)
            ->whereHas('jadwalAsesmen', function ($query) use ($request, $tukId, $skemaId) {
                $query->where(function($q) use ($request) {
                    $q->where('tanggal_mulai_asesmen', '<=', $request->tanggal_selesai_asesmen)
                      ->where('tanggal_selesai_asesmen', '>=', $request->tanggal_mulai_asesmen);
                })
                ->whereHas('pengajuanUjkDetail', function ($q) use ($tukId, $skemaId) {
                    $q->where('jejaring_id', '!=', $tukId)
                      ->orWhere('skema_id', $skemaId);
                });
            })
            ->first();

        if ($asesorBentrok) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal ploting! Ada Asesor yang sudah memiliki jadwal UJK di rentang tanggal tersebut dengan TUK/Skema yang bentrok.'
            ], 422);
        }
        
        DB::beginTransaction();
        try {
            $jadwalBaru = JadwalAsesmen::create([
                'pengajuan_ujk_detail_id'  => $detail_id,
                'penyilia_id'              => $request->penyilia_id,
                'tanggal_mulai_asesmen'    => $request->tanggal_mulai_asesmen,
                'tanggal_selesai_asesmen'  => $request->tanggal_selesai_asesmen,
            ]);

            $pengajuanDetail->update([
                'tanggal_mulai' => $request->tanggal_mulai_asesmen,
                'tanggal_selesai' => $request->tanggal_selesai_asesmen
            ]);

            $pengajuanDetail->pengajuan()->update([
                'status' => 'Disetujui'
            ]);

            foreach ($request->asesor_ids as $id_asesor) {
                PenugasanAsesor::create([
                    'jadwal_asesmen_id' => $jadwalBaru->id,
                    'asesor_id'         => $id_asesor,
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Jadwal & Asesor berhasil di-ploting',
                'data' => ['jadwal_id' => $jadwalBaru->id]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem, ploting dibatalkan.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }

    public function batalkanPengajuan($detail_id)
    {
        $pengajuan = PengajuanUjkDetail::find($detail_id);
        if (!$pengajuan) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Data Pengajuan tidak ditemukan'
            ], 404);
        }

        $sudahDiplot = JadwalAsesmen::where('pengajuan_ujk_detail_id', $detail_id)->exists();
        if ($sudahDiplot) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal! Pengajuan ini tidak bisa dibatalkan karena jadwal sudah FIXED (Asesor sudah diplot).'
            ], 403);
        }

        $pengajuan->update([
            'status_pengajuan' => 'Dibatalkan'
        ]);
        if ($pengajuan->pengajuan_ujk_id) {
            $masihAdaYangAktif = PengajuanUjkDetail::where('pengajuan_ujk_id', $pengajuan->pengajuan_ujk_id)
                ->where('status_pengajuan', '!=', 'Dibatalkan')
                ->exists();

            if (!$masihAdaYangAktif) {
                PengajuanUjk::where('id', $pengajuan->pengajuan_ujk_id)
                    ->update(['status' => 'Ditolak']);
            }
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Pengajuan berhasil dibatalkan.'
        ], 200);
    }

    public function simpanPlotingPeserta(Request $request, $detail_id) 
    {
        // 1. Cari Jadwal Asesmen yang terkait sama detail_id ini
        $jadwalIds = JadwalAsesmen::where('pengajuan_ujk_detail_id', $detail_id)->pluck('id');

        if ($jadwalIds->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Jadwal belum dibuat! Silakan lakukan Ploting Jadwal terlebih dahulu.'
            ], 404);
        }

        // 2. Ambil list ID Asesor yang udah di-plot khusus untuk jadwal ini
        $validAsesorIds = PenugasanAsesor::whereIn('jadwal_asesmen_id', $jadwalIds)
                            ->pluck('asesor_id')
                            ->toArray();

        // 3. Validasi JSON (Pakai Rule::in biar gak bisa milih asesor luar)
        $request->validate([
            'plotting' => 'required|array',
            'plotting.*.peserta_id' => 'required|exists:peserta_pengajuan_ujk,id',
            'plotting.*.asesor_id' => [
                'required',
                Rule::in($validAsesorIds)
            ],
        ], [
            'plotting.*.asesor_id.in' => 'Aksi ditolak! Terdapat asesor yang dipilih namun belum diploting pada jadwal ini.'
        ]);

        foreach ($request->plotting as $item) {
            PesertaPengajuanUjk::where('id', $item['peserta_id'])
                ->where('pengajuan_ujk_detail_id', $detail_id) 
                ->update(['asesor_id' => $item['asesor_id']]);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => "Plotting peserta untuk Detail ID $detail_id berhasil disimpan!"
        ]);
    }

    public function hasilKeputusanUji(Request $request, $detail_id)
    {
        $request->validate([
            'hasil_uji' => 'required|array',
            'hasil_uji.*.peserta_id' => 'required|exists:peserta_pengajuan_ujk,id',
            'hasil_uji.*.keputusan_uji' => 'required|in:kompeten,belum kompeten',
        ]);

        foreach ($request->hasil_uji as $item) {
            PesertaPengajuanUjk::where('id', $item['peserta_id'])
                ->where('pengajuan_ujk_detail_id', $detail_id) 
                ->update(['keputusan_uji' => $item['keputusan_uji']]);
        }

        return response()->json(['message' => "Hasil keputusan uji untuk Detail ID $detail_id berhasil disimpan!"]);
    }

    public function updateStatusTracking(Request $request, $detail_id)
    {
        $request->validate([
            'jenis_status' => 'required|in:pelaksanaan,pembayaran,draft,cetak,dikirim,diterima,tt_sertifikat',
            'status' => 'required|in:Selesai,Belum Selesai' 
        ]);

        $detail = PengajuanUjkDetail::find($detail_id);
        
        if (!$detail) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        }

        $kolom = 'status_' . $request->jenis_status;
        
        $detail->$kolom = $request->status;
        $detail->save();

        return response()->json([
            'status' => 'success', 
            'message' => "Status {$request->jenis_status} berhasil diubah menjadi {$request->status}!"
        ], 200);
    }

    public function inputResi(Request $request, $detail_id)
    {
        $request->validate([
            'no_resi' => 'required|string|max:100'
        ]);

        $detail = PengajuanUjkDetail::find($detail_id);
        
        if (!$detail) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        }

        $detail->no_resi = $request->no_resi;
        $detail->status_dikirim = 'Selesai'; 
        $detail->save();

        return response()->json([
            'status' => 'success', 
            'message' => 'Nomor Resi berhasil disimpan!',
            'data' => ['no_resi' => $detail->no_resi]
        ], 200);
    }
}
