<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SertifikatAsesi; 
use App\Models\PesertaPengajuanUjk;
use App\Models\TemplateFile;
use Carbon\Carbon; 

class SertifikatController extends Controller
{
    /**
     * Download file template Excel untuk import sertifikat lama.
     * File dibaca dari tabel template_files di database (bukan filesystem).
     */
    public function downloadTemplateSertifikat()
    {
        $template = TemplateFile::findByNama('template_sertifikat');

        if (!$template) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Template belum tersedia. Hubungi administrator.'
            ], 404);
        }

        $fileContent = base64_decode($template->data);

        return response($fileContent, 200, [
            'Content-Type'        => $template->mime_type,
            'Content-Disposition' => 'attachment; filename="' . $template->nama_file . '"',
            'Content-Length'      => strlen($fileContent),
            'Cache-Control'       => 'no-cache, no-store, must-revalidate',
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ]);
    }

    /**
     * Upload / ganti file template sertifikat (disimpan ke database).
     * Hanya bisa diakses oleh adminLsp.
     */
    public function uploadTemplateSertifikat(Request $request)
    {
        $request->validate([
            'file_template' => 'required|mimes:xlsx,xls|max:5120', // maks 5MB
        ], [
            'file_template.required' => 'File template wajib diunggah.',
            'file_template.mimes'    => 'File harus berformat .xlsx atau .xls.',
            'file_template.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        try {
            $file        = $request->file('file_template');
            $base64      = base64_encode(file_get_contents($file->getRealPath()));
            $namaFile    = $file->getClientOriginalName();
            $mimeType    = $file->getMimeType()
                           ?? 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

            TemplateFile::updateOrCreate(
                ['nama' => 'template_sertifikat'],
                [
                    'nama_file' => $namaFile,
                    'mime_type' => $mimeType,
                    'data'      => $base64,
                ]
            );

            return response()->json([
                'status'  => 'success',
                'message' => 'Template sertifikat berhasil diperbarui.',
                'file'    => $namaFile,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan template: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Upload / ganti file template nominatif asesi (disimpan ke database).
     * Hanya bisa diakses oleh adminLsp.
     */
    public function uploadTemplateNominatif(Request $request)
    {
        $request->validate([
            'file_template' => 'required|mimes:xlsx,xls|max:5120',
        ], [
            'file_template.required' => 'File template wajib diunggah.',
            'file_template.mimes'    => 'File harus berformat .xlsx atau .xls.',
            'file_template.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        try {
            $file        = $request->file('file_template');
            $base64      = base64_encode(file_get_contents($file->getRealPath()));
            $namaFile    = $file->getClientOriginalName();
            $mimeType    = $file->getMimeType() ?? 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

            TemplateFile::updateOrCreate(
                ['nama' => 'template_nominatif'],
                [
                    'nama_file' => $namaFile,
                    'mime_type' => $mimeType,
                    'data'      => $base64,
                ]
            );

            return response()->json([
                'status'  => 'success',
                'message' => 'Template nominatif berhasil diperbarui.',
                'file'    => $namaFile,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan template: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function listDataSertifikat()
    {
        try {
            $sertifikat = SertifikatAsesi::with(['pesertaPengajuanUjk.detailPengajuan.skema'])
                ->orderBy('created_at', 'desc')
                ->get();

            $data = $sertifikat->map(function ($item) {
                return [
                    'id' => $item->id,
                    'peserta_pengajuan_ujk_id' => $item->peserta_pengajuan_ujk_id,
                    'nama_peserta' => $item->pesertaPengajuanUjk->namaPeserta ?? $item->nama_peserta_lama ?? '-',
                    'nik' => $item->pesertaPengajuanUjk->nik ?? '-',
                    'no_sertifikat' => $item->no_sertifikat,
                    'no_registrasi' => $item->no_registrasi,
                    'skema_sertifikasi' => $item->pesertaPengajuanUjk->detailPengajuan->skema->namaSkema ?? $item->skema_sertifikasi_lama ?? '-',
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
            ->orWhere('nama_peserta_lama', 'like', "%{$keyword}%") // Tambah pencarian untuk nama peserta lama
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
                'nama_peserta' => $sertifikat->pesertaPengajuanUjk->namaPeserta ?? $sertifikat->nama_peserta_lama ?? '-',
                'nik' => $sertifikat->pesertaPengajuanUjk->nik ?? '-',
                'nomor_sertifikat' => $sertifikat->no_sertifikat,
                'nomor_registrasi' => $sertifikat->no_registrasi,
                'skema_sertifikasi' => $sertifikat->pesertaPengajuanUjk->detailPengajuan->skema->namaSkema ?? $sertifikat->skema_sertifikasi_lama ?? '-',
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
            'status' => 'nullable|in:Aktif,Tidak-Aktif,Kadaluwarsa'
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

    public function updateSertifikat(Request $request, $id)
    {
        $request->validate([
            'no_sertifikat' => 'required|string|unique:sertifikat_asesi,no_sertifikat,' . $id,
            'no_registrasi' => 'required|string|unique:sertifikat_asesi,no_registrasi,' . $id,
            'tanggal_penerbitan' => 'required|date',
            'masa_berlaku' => 'required|date|after_or_equal:tanggal_penerbitan',
            'status' => 'nullable|in:Aktif,Tidak-Aktif,Kadaluwarsa',
            'nama_peserta_lama' => 'nullable|string',
            'skema_sertifikasi_lama' => 'nullable|string'
        ], [
            'no_sertifikat.unique' => 'Nomor sertifikat ini sudah pernah diinput!',
            'no_registrasi.unique' => 'Nomor registrasi ini sudah pernah diinput!',
        ]);

        try {
            $sertifikat = SertifikatAsesi::find($id);
            if (!$sertifikat) {
                return response()->json(['status' => 'error', 'message' => 'Sertifikat tidak ditemukan'], 404);
            }

            // Jika peserta lama, perbarui nama & skema
            if (is_null($sertifikat->peserta_pengajuan_ujk_id)) {
                $sertifikat->nama_peserta_lama = $request->nama_peserta_lama;
                $sertifikat->skema_sertifikasi_lama = $request->skema_sertifikasi_lama;
            }

            $sertifikat->no_sertifikat = $request->no_sertifikat;
            $sertifikat->no_registrasi = $request->no_registrasi;
            $sertifikat->tanggal_penerbitan = $request->tanggal_penerbitan;
            $sertifikat->masa_berlaku = $request->masa_berlaku;
            $sertifikat->status = $request->status ?? $sertifikat->status;
            
            $sertifikat->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data sertifikat berhasil diperbarui!',
                'data' => $sertifikat
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui data sertifikat: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteSertifikat($id)
    {
        try {
            $sertifikat = SertifikatAsesi::find($id);
            if (!$sertifikat) {
                return response()->json(['status' => 'error', 'message' => 'Sertifikat tidak ditemukan'], 404);
            }

            $sertifikat->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Sertifikat berhasil dihapus!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus sertifikat: ' . $e->getMessage()
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

    public function importSertifikatExcel(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:5120'
        ]);

        $file = $request->file('file_excel');
        $dataExcel = \Maatwebsite\Excel\Facades\Excel::toArray(new \stdClass(), $file);

        if (empty($dataExcel) || count($dataExcel[0]) <= 1) {
            return response()->json(['status' => 'error', 'message' => 'File Excel kosong atau format tidak sesuai.'], 400);
        }

        // --- TAHAP 1: HASHMAP CACHING O(1) ---
        // Tarik SEMUA No Sertifikat & No Registrasi dari DB sekali aja di awal!
        $dbSertifikat = \App\Models\SertifikatAsesi::pluck('no_sertifikat', 'no_sertifikat')->toArray();
        $dbRegistrasi = \App\Models\SertifikatAsesi::whereNotNull('no_registrasi')->pluck('no_registrasi', 'no_registrasi')->toArray();

        $errorList = [];
        $cekNoSertifikatFile = [];
        $cekNoRegistrasiFile = [];

        // --- TAHAP 2: VALIDASI CEPAT (Tanpa Nyentuh Database Lagi) ---
        foreach ($dataExcel[0] as $index => $row) {
            if ($index == 0) continue; // Skip header
            
            // Cek kalau barisnya kosong semua
            if (empty(trim($row[1] ?? '')) && empty(trim($row[2] ?? '')) && empty(trim($row[4] ?? ''))) continue; 

            $barisExcel = $index + 1;

            $namaPeserta   = trim($row[1] ?? '');
            $skemaSertif   = trim($row[2] ?? '');
            $noSertifikat  = trim($row[3] ?? '');
            $noRegistrasi  = trim($row[4] ?? '');

            // A. Cek Kolom Wajib Kosong
            // Sesuai template: index 1=Nama, 2=Skema, 3=No Sertif, 4=No Reg
            if (empty($namaPeserta) || empty($noSertifikat)) {
                $errorList[] = "Baris $barisExcel: Nama dan No. Sertifikat wajib diisi.";
                continue; 
            }

            // B. Cek Duplikat DI DALAM File Excel
            if (isset($cekNoSertifikatFile[$noSertifikat])) {
                $errorList[] = "Baris $barisExcel: No. Sertifikat '$noSertifikat' data double di dalam file Excel.";
            } else {
                $cekNoSertifikatFile[$noSertifikat] = true;
            }

            if (!empty($noRegistrasi)) {
                if (isset($cekNoRegistrasiFile[$noRegistrasi])) {
                    $errorList[] = "Baris $barisExcel: No. Registrasi '$noRegistrasi' data double di dalam file Excel.";
                } else {
                    $cekNoRegistrasiFile[$noRegistrasi] = true;
                }
            }

            // C. Cek Duplikat KE DATABASE pakai HASHMAP (Pengecekan O(1) = Super Kilat!)
            if (isset($dbSertifikat[$noSertifikat])) {
                $errorList[] = "Baris $barisExcel: No. Sertifikat '$noSertifikat' data sudah terdaftar di sistem.";
            }

            if (!empty($noRegistrasi) && isset($dbRegistrasi[$noRegistrasi])) {
                $errorList[] = "Baris $barisExcel: No. Registrasi '$noRegistrasi' data sudah terdaftar di sistem.";
            }
        }

        // --- TAHAP 3: LEMPAR ERROR KE FRONT-END (REACT) ---
        if (count($errorList) > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Import dibatalkan! Ditemukan kesalahan pada data Excel.',
                'errors' => $errorList 
            ], 422);
        }

        // --- TAHAP 4: SIMPAN KE DATABASE KARENA UDAH 100% AMAN ---
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $berhasil = 0;
            $dataInsert = [];

            foreach ($dataExcel[0] as $index => $row) {
                if ($index == 0) continue;
                if (empty(trim($row[1] ?? '')) || empty(trim($row[3] ?? ''))) continue; 

                $tglTerbitExcel = $row[5] ?? null;
                $masaBerlakuExcel = $row[6] ?? null;

                $tglTerbit = null;
                $masaBerlaku = null;

                if (is_numeric($tglTerbitExcel)) {
                    $tglTerbit = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tglTerbitExcel)->format('Y-m-d');
                } else if (!empty($tglTerbitExcel)) {
                    try {
                        $tglTerbit = \Carbon\Carbon::createFromFormat('d/m/Y', trim($tglTerbitExcel))->format('Y-m-d');
                    } catch (\Exception $e) {
                        $tglTerbit = \Carbon\Carbon::parse(trim($tglTerbitExcel))->format('Y-m-d');
                    }
                }

                if (is_numeric($masaBerlakuExcel)) {
                    $masaBerlaku = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($masaBerlakuExcel)->format('Y-m-d');
                } else if (!empty($masaBerlakuExcel)) {
                    try {
                        $masaBerlaku = \Carbon\Carbon::createFromFormat('d/m/Y', trim($masaBerlakuExcel))->format('Y-m-d');
                    } catch (\Exception $e) {
                        $masaBerlaku = \Carbon\Carbon::parse(trim($masaBerlakuExcel))->format('Y-m-d');
                    }
                }

                $today = \Carbon\Carbon::today();
                $masaBerlakuCarbon = $masaBerlaku ? \Carbon\Carbon::parse($masaBerlaku)->startOfDay() : null;
                $status = ($masaBerlakuCarbon && $today > $masaBerlakuCarbon) ? 'Kadaluwarsa' : 'Aktif';

                $dataInsert[] = [
                    'peserta_pengajuan_ujk_id' => null, 
                    'nama_peserta_lama'        => trim($row[1] ?? ''),
                    'skema_sertifikasi_lama'   => trim($row[2] ?? ''),
                    'no_sertifikat'            => trim($row[3] ?? ''),
                    'no_registrasi'            => trim($row[4] ?? ''),
                    'tanggal_penerbitan'       => $tglTerbit,
                    'masa_berlaku'             => $masaBerlaku,
                    'status'                   => $status,
                    'created_at'               => now(),
                    'updated_at'               => now()
                ];
                $berhasil++;
            }

            // Insert massal biar makin ngebut!
            \App\Models\SertifikatAsesi::insert($dataInsert);

            \Illuminate\Support\Facades\DB::commit();
            return response()->json(['status' => 'success', 'message' => "$berhasil Sertifikat Lama berhasil di-import!"], 200);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Gagal membaca file Excel.', 'error_detail' => $e->getMessage()], 500);
        }
    }
}