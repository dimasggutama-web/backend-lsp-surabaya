<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SertifikatAsesi; 
use App\Models\PesertaPengajuanUjk;
use Carbon\Carbon; 

class SertifikatController extends Controller
{
    public function listDataSertifikat()
    {
        try {
            $sertifikat = SertifikatAsesi::with(['pesertaPengajuanUjk.detailPengajuan.skema'])
                ->orderBy('created_at', 'desc')
                ->get();

            $data = $sertifikat->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama_peserta' => $item->pesertaPengajuanUjk->namaPeserta ?? '-',
                    'nik' => $item->pesertaPengajuanUjk->nik ?? '-',
                    'no_sertifikat' => $item->no_sertifikat,
                    'no_registrasi' => $item->no_registrasi,
                    'skema_sertifikasi' => $item->pesertaPengajuanUjk->detailPengajuan->skema->namaSkema ?? '-',
                    'tanggal_penerbitan' => Carbon::parse($item->tanggal_penerbitan)->locale('id')->translatedFormat('d F Y'),
                    'masa_berlaku' => Carbon::parse($item->masa_berlaku)->locale('id')->translatedFormat('d F Y'),
                    'status' => $item->status
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengambil daftar sertifikat',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function cekSertifikat(Request $request)
    {
        $keyword = $request->query('keyword');

        if (!$keyword) {
            return response()->json(['message' => 'Masukkan kata kunci pencarian'], 400);
        }

        $sertifikat = SertifikatAsesi::with(['pesertaPengajuanUjk', 'pesertaPengajuanUjk.detailPengajuan.skema'])
            ->where('no_sertifikat', 'like', "%{$keyword}%")
            ->orWhere('no_registrasi', 'like', "%{$keyword}%")
            ->orWhereHas('pesertaPengajuanUjk', function ($query) use ($keyword) {
                $query->where('nik', $keyword)
                      ->orWhere('namaPeserta', 'like', "%{$keyword}%");
            })
            ->first(); 

        if (!$sertifikat) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sertifikat tidak ditemukan atau tidak valid.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'nama_peserta' => $sertifikat->pesertaPengajuanUjk->namaPeserta,
                'nik' => $sertifikat->pesertaPengajuanUjk->nik,
                'nomor_sertifikat' => $sertifikat->no_sertifikat,
                'nomor_registrasi' => $sertifikat->no_registrasi,
                'skema_sertifikasi' => $sertifikat->pesertaPengajuanUjk->detailPengajuan->skema->namaSkema ?? '-',
                'tanggal_terbit' => Carbon::parse($sertifikat->tanggal_penerbitan)->locale('id')->translatedFormat('d F Y'),
                'masa_berlaku' => Carbon::parse($sertifikat->masa_berlaku)->locale('id')->translatedFormat('d F Y'),
                'status' => $sertifikat->status
            ]
        ], 200);
    }

    public function tambahSertifikat(Request $request)
    {
        $request->validate([
            'peserta_pengajuan_ujk_id' => 'required|exists:peserta_pengajuan_ujk,id',
            'no_sertifikat' => 'required|string|unique:sertifikat_asesi,no_sertifikat',
            'no_registrasi' => 'required|string|unique:sertifikat_asesi,no_registrasi',
            'tanggal_penerbitan' => 'required|date',
            'masa_berlaku' => 'required|date|after_or_equal:tanggal_penerbitan',
            'status' => 'nullable|in:Aktif,Tidak Aktif,Kedaluwarsa'
        ], [
            'no_sertifikat.unique' => 'Nomor sertifikat ini sudah pernah diinput!',
            'no_registrasi.unique' => 'Nomor registrasi ini sudah pernah diinput!',
            'peserta_pengajuan_ujk_id.exists' => 'Data peserta tidak valid.'
        ]);

        $peserta = PesertaPengajuanUjk::find($request->peserta_pengajuan_ujk_id);
        if (empty($peserta->keputusan_uji)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sertifikat tidak dapat dibuat karena peserta belum memiliki keputusan uji yang valid.'
            ], 403);
        }

        if ($peserta->keputusan_uji !== 'kompeten') {
            return response()->json([
                'status' => 'error',
                'message' => 'Sertifikat tidak dapat dibuat karena peserta belum kompeten.'
            ], 403);
        }

        try {
            $sertifikat = SertifikatAsesi::create([
                'peserta_pengajuan_ujk_id' => $request->peserta_pengajuan_ujk_id,
                'no_sertifikat' => $request->no_sertifikat,
                'no_registrasi' => $request->no_registrasi,
                'tanggal_penerbitan' => $request->tanggal_penerbitan,
                'masa_berlaku' => $request->masa_berlaku,
                'status' => $request->status ?? 'Aktif'
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data sertifikat berhasil ditambahkan!',
                'data' => $sertifikat
            ], 201); 

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data sertifikat: ' . $e->getMessage()
            ], 500);
        }
    }
    public function pesertaKompeten(Request $request)
    {
        $keyword = $request->query('keyword');
        if (!$keyword) {
            return response()->json([
                'status' => 'success',
                'data' => []
            ], 200);
        }

        $peserta = PesertaPengajuanUjk::with(['detailPengajuan.skema'])
            ->where('keputusan_uji', 'kompeten') 
            ->where(function ($query) use ($keyword) {
                $query->where('nik', 'like', "%{$keyword}%")
                      ->orWhere('namaPeserta', 'like', "%{$keyword}%");
            })
            ->take(10) 
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $peserta
        ], 200);
    }
}