<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PengajuanUjk;
use App\Models\PengajuanUjkDetail;
use App\Models\DokumenUploadLsp;
use App\Models\JejaringLspBlk;
use App\Models\PesertaPengajuanUjk;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;


class AdminBlkController extends Controller
{
    public function pengajuanUjk (Request $request)
    {
        $allowedTuks = auth()->user()->tuk()
            ->where('jejaring_lsp_blk_sby.status', 'Aktif')
            ->pluck('jejaring_lsp_blk_sby.id')
            ->toArray();

        $validator = Validator::make($request->all(), [
            'sumber_anggaran_id' => [
                'required', 
                Rule::exists('sumber_anggaran', 'id')->where('status', 'Aktif')
            ],
            'nomor_surat_pengajuan' => 'required|unique:pengajuan_ujk,nomor_surat_pengajuan',
            'file_surat_pengajuan' => 'required|mimes:pdf|max:5120', 
            'skemas' => 'required|array|min:1',
            'skemas.*.skema_id' => [
                'required',
                Rule::exists('data_skema_sertifikasi_lsp_blk_sby', 'id')->where('status', 'Aktif')
            ], 
            'skemas.*.jejaring_id' => ['required', Rule::in($allowedTuks)],
            'skemas.*.tanggal_mulai' => 'required|date',
            'skemas.*.tanggal_selesai' => 'required|date|after_or_equal:skemas.*.tanggal_mulai',
            'skemas.*.file_nominatif' => 'required|mimes:xlsx,xls|max:5120',
            'skemas.*.file_kurikulum' => 'required|mimes:pdf|max:5120',
        ], [    
            'sumber_anggaran_id.exists' => 'Sumber Anggaran tidak valid atau sedang Non-aktif.',
            'skemas.*.skema_id.exists' => 'Skema Sertifikasi tidak valid atau sedang Non-aktif.',
            'skemas.*.jejaring_id.in' => 'Anda tidak memiliki akses ke TUK ini, atau TUK sedang Non-aktif.'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak lengkap atau format salah',
                'errors' => $validator->errors()
            ], 422);
        }
        DB::beginTransaction();
        try {
            $suratPath = $request->file('file_surat_pengajuan')->store('surat_pengajuan', 'public');
            $pengajuan = PengajuanUjk::create([
                'admin_blk_id' => auth()->id(),
                'sumber_anggaran_id' => $request->sumber_anggaran_id,
                'nomor_surat_pengajuan' => $request->nomor_surat_pengajuan,
                'file_surat_pengajuan' => $suratPath,
                'status' => 'Draft'
            ]);
            foreach ($request->skemas as $index => $skema) {
                $master = \App\Models\DataSkemaSertifikasi::find($skema['skema_id']);
                $nominatifPath = $request->hasFile("skemas.{$index}.file_nominatif") 
                    ? $request->file("skemas.{$index}.file_nominatif")->store('file_nominatif', 'public') 
                    : null;
                $kurikulumPath = $request->hasFile("skemas.{$index}.file_kurikulum") 
                    ? $request->file("skemas.{$index}.file_kurikulum")->store('file_kurikulum', 'public') 
                    : null;
                $jumlahPesertaAsli = 0;
                if ($request->hasFile("skemas.{$index}.file_nominatif")) {
                    $file = $request->file("skemas.{$index}.file_nominatif");
                    $dataExcel = Excel::toArray(new \stdClass(), $file);
                    $headerExcel = $dataExcel[0][10] ?? null;
                    $kolomNik  = strtolower(trim($headerExcel[2] ?? ''));
                    $kolomNama = strtolower(trim($headerExcel[1] ?? ''));
                    if ($kolomNik !== 'nik' || $kolomNama !== 'namaPeserta') {
                    }
                    for ($x = 12; $x < count($dataExcel[0]); $x++) {
                        if (empty(trim($dataExcel[0][$x][1] ?? '')) && empty(trim($dataExcel[0][$x][2] ?? ''))) {
                            break;
                        }
                        $jumlahPesertaAsli++;
                    }
                    $nominatifPath = $file->store('file_nominatif', 'public');
                }
               if ($request->hasFile("skemas.{$index}.file_kurikulum")) {
                    $kurikulumPath = $request->file("skemas.{$index}.file_kurikulum")->store('file_kurikulum', 'public');
                }
                $detailSkemaBaru = PengajuanUjkDetail::create([
                    'pengajuan_ujk_id' => $pengajuan->id,
                    'skema_id'         => $skema['skema_id'],
                    'jejaring_id'      => $skema['jejaring_id'],
                    'bidang_id'        => $master->bidang_id,
                    'jenisSkema'       => $master->jenisSkema,
                    'tanggal_mulai'    => $skema['tanggal_mulai'],
                    'tanggal_selesai'  => $skema['tanggal_selesai'],
                    'jumlah_peserta'   => $jumlahPesertaAsli, 
                    'file_nominatif'   => $nominatifPath,
                    'file_kurikulum'   => $kurikulumPath,
                ]);
                if ($dataExcel && $jumlahPesertaAsli > 0) {
                    for ($i = 12; $i < (12 + $jumlahPesertaAsli); $i++) {
                        $baris = $dataExcel[0][$i];
                        $tglLahir = $baris[5] ?? '';
                        if (is_numeric($tglLahir)) {
                            $tglLahir = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tglLahir)->format('Y-m-d');
                        } else {
                            $tglLahirBersih = preg_replace('!\s+!', ' ', strtolower($tglLahir));
                            $parts = explode(' ', $tglLahirBersih);
                            if (count($parts) === 3) {
                                $kamusBulan = [
                                    'januari' => '01', 'jan' => '01',
                                    'februari' => '02', 'pebruari' => '02', 'feb' => '02',
                                    'maret' => '03', 'mar' => '03',
                                    'april' => '04', 'apr' => '04',
                                    'mei' => '05',
                                    'juni' => '06', 'jun' => '06',
                                    'juli' => '07', 'jul' => '07',
                                    'agustus' => '08', 'agu' => '08', 'ags' => '08',
                                    'september' => '09', 'sep' => '09',
                                    'oktober' => '10', 'okt' => '10',
                                    'november' => '11', 'nov' => '11',
                                    'desember' => '12', 'des' => '12'
                                ];
                            }
                            $hari = str_pad($parts[0], 2, '0', STR_PAD_LEFT);
                            $namaBulan = $parts[1];
                            $tahun = $parts[2];
                            $angkaBulan = is_numeric($namaBulan) ? str_pad($namaBulan, 2, '0', STR_PAD_LEFT) : ($kamusBulan[$namaBulan] ?? '01');
                            $tglLahir = "$tahun-$angkaBulan-$hari";
                        }    
                        PesertaPengajuanUjk::create([
                            'pengajuan_ujk_detail_id' => $detailSkemaBaru->id,
                            'namaPeserta'  => $baris[1], 
                            'nik'          => $baris[2], 
                            'jenisKelamin' => $baris[3], 
                            'tempatLahir'  => $baris[4], 
                            'tanggalLahir' => $tglLahir, 
                            'alamat'       => $baris[6], 
                            'rt'           => $baris[7], 
                            'rw'           => $baris[8], 
                            'kelurahan'    => $baris[9], 
                            'kecamatan'    => $baris[10], 
                            'nomorTelepon' => $baris[11] ?? null, 
                            'email'        => $baris[12] ?? null, 
                            'pendidikanTerakhir' => $baris[13] ?? null,
                        ]);
                    }
                }
            }            
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Pengajuan UJK berhasil disimpan sebagai Draft!',
                'data' => [
                    'pengajuan_id' => $pengajuan->id
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem, pengajuan dibatalkan.',
                'error_detail' => $e->getMessage() 
            ], 500);
        }
    }
    
    public function updateDraftPengajuan(Request $request, $id){
        $allowedTuks = auth()->user()->tuk()
            ->where('jejaring_lsp_blk_sby.status', 'Aktif')
            ->pluck('jejaring_lsp_blk_sby.id')
            ->toArray();
        $validator = validator::make($request->all(), [
            'sumber_anggaran_id' => [
                'required',
                Rule::exists('sumber_anggaran', 'id')->where('status', 'Aktif')
            ],
            'nomor_surat_pengajuan' => 'required|unique:pengajuan_ujk,nomor_surat_pengajuan,' . $id,
            'file_surat_pengajuan' => 'nullable|mimes:pdf|max:5120', 
            'skemas' => 'required|array|min:1',
            'skemas.*.skema_id' => [
                'required',
                Rule::exists('data_skema_sertifikasi_lsp_blk_sby', 'id')->where('status', 'Aktif')
            ],
            'skemas.*.jejaring_id' => ['required', Rule::in($allowedTuks)],
            'skemas.*.tanggal_mulai' => 'required|date',
            'skemas.*.tanggal_selesai' => 'required|date|after_or_equal:skemas.*.tanggal_mulai',
            'skemas.*.file_nominatif' => 'nullable|mimes:xlsx,xls|max:5120',
            'skemas.*.file_kurikulum' => 'nullable|mimes:pdf|max:5120',
        ], [
            'sumber_anggaran_id.exists' => 'Sumber Anggaran tidak valid atau sedang Non-aktif.',
            'skemas.*.skema_id.exists' => 'Skema Sertifikasi tidak valid atau sedang Non-aktif.',
            'skemas.*.jejaring_id.in' => 'Anda tidak memiliki akses ke TUK ini, atau TUK sedang Non-aktif.'

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak lengkap atau format salah',
                'errors' => $validator->errors()
            ], 422);
        }
        DB::beginTransaction();
        try {
            $pengajuan = PengajuanUjk::where ('id', $id)
                ->where ('admin_blk_id', auth()->id())
                ->where ('status', 'Draft')
                ->first();
            if (!$pengajuan) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pengajuan tidak ditemukan atau tidak dalam status Draft'
                ], 404);
        }
        $suratPath = $pengajuan->file_surat_pengajuan;
            if ($request->hasFile('file_surat_pengajuan')) {
                $suratPath = $request->file('file_surat_pengajuan')->store('surat_pengajuan', 'public');
            }
            $pengajuan->update([
                'sumber_anggaran_id' => $request->sumber_anggaran_id,
                'nomor_surat_pengajuan' => $request->nomor_surat_pengajuan,
                'file_surat_pengajuan' => $suratPath,
            ]);

            $submittedSkemaIds = collect($request->skemas)->pluck('skema_id')->toArray();
            $skemaDihapus = PengajuanUjkDetail::where('pengajuan_ujk_id', $pengajuan->id)
                ->whereNotIn('skema_id', $submittedSkemaIds)
                ->get();
            foreach ($skemaDihapus as $hapus) {
                PesertaPengajuanUjk::where('pengajuan_ujk_detail_id', $hapus->id)->delete();
                $hapus->delete();
            }

            foreach ($request->skemas as $index => $skema) {
                $master = \App\Models\DataSkemaSertifikasi::find($skema['skema_id']);
                $detailLama = PengajuanUjkDetail::where('pengajuan_ujk_id', $pengajuan->id)
                    ->where('skema_id', $skema['skema_id'])
                    ->first();

                

                $nominatifPath = $detailLama ? $detailLama->file_nominatif : null;
                $kurikulumPath = $detailLama ? $detailLama->file_kurikulum : null;
                $jumlahPesertaAsli = $detailLama ? $detailLama->jumlah_peserta : 0;
                
                $pesertaValid = [];
                $updatePeserta = false;

                // Cek File Kurikulum
                if ($request->hasFile("skemas.{$index}.file_kurikulum")) {
                    $kurikulumPath = $request->file("skemas.{$index}.file_kurikulum")->store('file_kurikulum', 'public');
                }

                // Cek File Nominatif
                if ($request->hasFile("skemas.{$index}.file_nominatif")) {
                    $file = $request->file("skemas.{$index}.file_nominatif");
                    $nominatifPath = $file->store('file_nominatif', 'public');
                    $dataExcel = \Maatwebsite\Excel\Facades\Excel::toArray(new \stdClass(), $file);
                    
                    foreach ($dataExcel[0] as $indexBaris => $baris) {
                        if ($indexBaris < 11) continue; 
                        if (!empty(trim($baris[1] ?? '')) || !empty(trim($baris[2] ?? ''))) {
                            $pesertaValid[] = $baris;
                        }
                    }
                    $jumlahPesertaAsli = count($pesertaValid);
                    $updatePeserta = true; 
                }

                if ($detailLama) {
                    $detailLama->update([
                        'jejaring_id' => $skema['jejaring_id'],
                        'tanggal_mulai' => $skema['tanggal_mulai'],
                        'tanggal_selesai' => $skema['tanggal_selesai'],
                        'jumlah_peserta' => $jumlahPesertaAsli,
                        'file_nominatif' => $nominatifPath,
                        'file_kurikulum' => $kurikulumPath,
                    ]);
                    $detailSkemaId = $detailLama->id;
                } else {
                    $detailSkemaBaru = PengajuanUjkDetail::create([
                        'pengajuan_ujk_id' => $pengajuan->id,
                        'skema_id'         => $skema['skema_id'],
                        'jejaring_id'      => $skema['jejaring_id'],
                        'bidang_id'        => $master->bidang_id, 
                        'tanggal_mulai'    => $skema['tanggal_mulai'],
                        'tanggal_selesai'  => $skema['tanggal_selesai'],
                        'jumlah_peserta'   => $jumlahPesertaAsli, 
                        'file_nominatif'   => $nominatifPath,
                        'file_kurikulum'   => $kurikulumPath,
                    ]);
                    $detailSkemaId = $detailSkemaBaru->id;
                }

                if ($updatePeserta && count($pesertaValid) > 0) {
                    PesertaPengajuanUjk::where('pengajuan_ujk_detail_id', $detailSkemaId)->delete();
                    
                    foreach ($pesertaValid as $baris) {
                        $tglLahir = $baris[5] ?? '';                    
                        if (is_numeric($tglLahir)) {
                            $tglLahir = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tglLahir)->format('Y-m-d');
                        } else {
                            $tglLahirBersih = preg_replace('!\s+!', ' ', strtolower($tglLahir));
                            $parts = explode(' ', $tglLahirBersih);
                            if (count($parts) === 3) {
                                $kamusBulan = [
                                    'januari' => '01', 'jan' => '01', 'februari' => '02', 'pebruari' => '02', 'feb' => '02',
                                    'maret' => '03', 'mar' => '03', 'april' => '04', 'apr' => '04', 'mei' => '05',
                                    'juni' => '06', 'jun' => '06', 'juli' => '07', 'jul' => '07', 'agustus' => '08', 'agu' => '08', 'ags' => '08',
                                    'september' => '09', 'sep' => '09', 'oktober' => '10', 'okt' => '10', 'november' => '11', 'nov' => '11',
                                    'desember' => '12', 'des' => '12'
                                ];
                                $hari = str_pad($parts[0], 2, '0', STR_PAD_LEFT);
                                $namaBulan = $parts[1];
                                $tahun = $parts[2];
                                $angkaBulan = is_numeric($namaBulan) ? str_pad($namaBulan, 2, '0', STR_PAD_LEFT) : ($kamusBulan[$namaBulan] ?? '01');
                                $tglLahir = "$tahun-$angkaBulan-$hari";
                            }
                        }
                        PesertaPengajuanUjk::create([
                            'pengajuan_ujk_detail_id' => $detailSkemaId,
                            'namaPeserta'  => $baris[1], 'nik' => $baris[2], 'jenisKelamin' => $baris[3], 
                            'tempatLahir'  => $baris[4], 'tanggalLahir' => $tglLahir, 'alamat' => $baris[6], 
                            'rt' => $baris[7], 'rw' => $baris[8], 'kelurahan' => $baris[9], 'kecamatan' => $baris[10], 
                            'nomorTelepon' => $baris[11] ?? null, 'email' => $baris[12] ?? null, 'pendidikanTerakhir' => $baris[13] ?? null,
                        ]);
                    }
                }
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Draft Pengajuan berhasil diperbarui.',
                'data' => [
                    'pengajuan_id' => $pengajuan->id
                ]
            ], 200);
        }    catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem, pembaruan dibatalkan.',
                'error_detail' => $e->getMessage() 
            ], 500);
        }
    }
    public function getDrafts(){
        $drafts = PengajuanUjk::with(['detailSkema.tuk', 'detailSkema.skema', 'detailSkema.pesertaPengajuanUjk']) 
            ->where('admin_blk_id', auth()->id())
            ->where('status', 'Draft')
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $drafts
        ]);    
    }
    
    public function submitPengajuan($id){
        $pengajuan = PengajuanUjk::where ('id', $id)
            ->where('admin_blk_id', auth()->id())
            ->where('status', 'Draft')
            ->first();
            if (!$pengajuan) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pengajuan tidak ditemukan atau sudah diajukan'
                ], 404);
            }
            if ($pengajuan->status !== 'Draft') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pengajuan sudah diajukan sebelumnya'
                ], 400);
            }
            $pengajuan->update(['status' => 'Menunggu']);
            return response()->json([
                'status' => 'success',
                'message' => 'Pengajuan berhasil diajukan!'
            ]);
    }
    public function cancelPengajuan($id){
        DB::beginTransaction();
        try {
            $pengajuan = PengajuanUjk::where('id', $id)
                ->where('admin_blk_id', auth()->id())
                ->where('status', 'Draft')
                ->first();
            if (!$pengajuan) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pengajuan tidak ditemukan atau tidak dalam status Draft'
                ], 404);
            }
            foreach ($pengajuan->detailSkema as $detail) {
                PesertaPengajuanUjk::where('pengajuan_ujk_detail_id', $detail->id)->delete();
                $detail->delete();
            }
            $pengajuan->delete();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Pengajuan berhasil dibatalkan dan dihapus!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membatalkan pengajuan.',
                'error_detail' => $e->getMessage() 
            ], 500);
        }
    }
    public function getDashboard(){
        $pengajuanFix = PengajuanUjk::with(['detailSkema.tuk', 'detailSkema.skema', 'detailSkema.pesertaPengajuanUjk'])
            ->where('admin_blk_id', auth()->id())
            ->where('status', '!=', 'Draft')
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $pengajuanFix
        ]);
    }

    public function getListTuk()
    {
        $allowedTuks = auth()->user()->tuk()
            ->where('jejaring_lsp_blk_sby.status', 'Aktif')
            ->pluck('jejaring_lsp_blk_sby.id'); 

        $dataTuk = JejaringLspBlk::whereIn('id', $allowedTuks)
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil daftar TUK',
            'data' => $dataTuk
        ], 200);
    }

    public function getSuratBalasan($pengajuan_id)
    {
        $dokumen = DokumenUploadLsp::where('pengajuan_ujk_id', $pengajuan_id)
            ->where('jenis_dokumen', 'surat_balasan')
            ->first();

        if (!$dokumen) {
            return response()->json([
                'status' => 'success',
                'message' => 'Surat balasan belum di-upload oleh pihak LSP.',
                'data' => null
            ], 200);
        }

        $dataResponse = [
            'id' => $dokumen->id,
            'pengajuan_ujk_id' => $dokumen->pengajuan_ujk_id,
            'nama_file' => $dokumen->nama_file,
            'url_download' => url('/api/admin-blk/download-file/' . $dokumen->id),
            'uploaded_at' => $dokumen->created_at->format('Y-m-d H:i:s')
        ];

        return response()->json([
            'status' => 'success',
            'data' => $dataResponse
        ], 200);
    }
    public function suratPengajuan(Request $request, $detail_id)
    {
        $pengajuan = PengajuanUjk::find($detail_id);
        if (!$pengajuan || empty($pengajuan->file_surat_pengajuan)) {
            return response()->json([
                'status' => 'error', 
                'message' => 'File surat pengajuan tidak ditemukan'
            ], 404);
        }
        $pathFisik = storage_path('app/public/' . $pengajuan->file_surat_pengajuan);

        if (!file_exists($pathFisik)) {
            return response()->json([
                'status' => 'error', 
                'message' => 'File surat pengajuan tidak ditemukan di server'
            ], 404);
        }
        return response()->file($pathFisik);
    }
    public function suratKurikulum(Request $request, $detail_id)
    {
        $kurikulum = PengajuanUjkDetail::find($detail_id);
        if (!$kurikulum || empty($kurikulum->file_kurikulum)) {
            return response()->json([
                'status' => 'error', 
                'message' => 'File kurikulum tidak ditemukan'
            ], 404);
        }
        $pathFisik = storage_path('app/public/' . $kurikulum->file_kurikulum);
        
        if (!file_exists($pathFisik)) {
            return response()->json([
                'status' => 'error', 
                'message' => 'File kurikulum tidak ditemukan di server'
            ], 404);
        }
        return response()->file($pathFisik);
    }
    public function downloadDokumenFisik($id)
    {
        $dokumen = DokumenUploadLsp::find($id);
        
        if (!$dokumen || !file_exists(storage_path('app/public/' . $dokumen->path_file))) {
            return response()->json(['message' => 'File tidak ditemukan di server'], 404);
        }

        return response()->file(storage_path('app/public/' . $dokumen->path_file));
    }
}
