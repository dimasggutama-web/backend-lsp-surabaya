<?php

use App\Http\Controllers\Api\AdminBlkController;
use App\Http\Controllers\Api\AdminLspController;
use App\Http\Controllers\Api\AsesorController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MasterDataController;
use App\Http\Controllers\Api\SuperAdminController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DokumenLspController;
use App\Http\Controllers\Api\SertifikatController;
use App\Http\Controllers\Api\LspUploadController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::prefix('master')->group(function () {
    Route::get('/bidang', [MasterDataController::class, 'getListBidang']);
    Route::get('/skema', [MasterDataController::class, 'getListSkema']);
    Route::get('/jejaring', [MasterDataController::class, 'getListJejaring']);
    Route::get('/kementerian', [MasterDataController::class, 'getListKementerian']);
    Route::get('/pekerjaan', [MasterDataController::class, 'getListPekerjaan']);
    Route::get('/pendidikan', [MasterDataController::class, 'getListPendidikan']);
    Route::get('/sumber-anggaran', [MasterDataController::class, 'getListSumberAnggaran']);
    Route::get('/penyilia', [MasterDataController::class, 'getListPenyilia']);
    Route::get('/asesor', [AsesorController::class, 'getAllAsesor']);
    Route::get('/statistik-landing', [MasterDataController::class, 'getStatistikLanding']);
});


Route::prefix('sertifikat')->group(function () {
    Route::get('/cek-sertifikat', [SertifikatController::class, 'cekSertifikat']);
});

Route::get('/cek-waktu', function () {
    return response()->json([
        '1_waktu_php_asli' => date('Y-m-d H:i:s'),
        '2_waktu_laravel' => now()->toDateTimeString(),
        '3_waktu_database' => \Illuminate\Support\Facades\DB::select("SELECT NOW() as db_time")[0]->db_time
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    //Fitur semua user
    Route::get('/getProfile', [UserController::class, 'getProfile']);
    Route::get('/getFotoProfile', [UserController::class, 'getFotoProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/change-password', [UserController::class, 'changePassword']);
    Route::put('/profile/update', [UserController::class, 'updateProfile']);
    Route::post('/profile/update-picture', [UserController::class, 'updateProfilePicture']);
    Route::delete('/profile/delete-picture', [UserController::class, 'deleteProfilePicture']);
    
    //Fitur superAdmin
    Route::middleware('role:superAdmin')->group(function () {
        Route::get('/superAdmin/users', [SuperAdminController::class, 'getAllUsers']);
        Route::post('/superAdmin/create-user', [SuperAdminController::class, 'registerByAdmin']);
        Route::post('/superAdmin/reset-password', [SuperAdminController::class, 'resetPasswordByAdmin']);
        Route::put('/superAdmin/edit-user/{id}', [SuperAdminController::class, 'editUserByAdmin']);
        Route::patch('/superAdmin/user/{id}/status', [SuperAdminController::class, 'statusUser']);
    });

    //Fitur Admin LSP
    Route::middleware('role:adminLsp')->group(function () {
        Route::get('/admin-lsp/semua-pengajuan', [AdminLspController::class, 'getAllPengajuan']);
        Route::get('/admin-lsp/asesor', [AsesorController::class, 'getAllAsesor']);
        Route::get('/admin-lsp/asesor-history-beban-kerja', [AsesorController::class, 'getHistoryBebanKerja']);
        Route::get('/admin-lsp/Penyilia', [MasterDataController::class, 'getListPenyilia']);

        Route::get('/admin-lsp/asesor-by-skema/{skema_id}', [AsesorController::class, 'getAsesorBySkema']);
        Route::patch('/admin-lsp/asesor/{id}/status', [AsesorController::class, 'statusAsesor']);

        Route::patch('/admin-lsp/skema/{id}/status', [MasterDataController::class, 'statusSkema']);
        Route::post('/admin-lsp/skema/add', [MasterDataController::class, 'addSkema']);
        Route::put('/admin-lsp/skema/{id}/edit', [MasterDataController::class, 'editSkema']);

        Route::patch('/admin-lsp/bidang/{id}/status', [MasterDataController::class, 'statusBidang']);
        Route::post('/admin-lsp/bidang/add', [MasterDataController::class, 'addBidang']);
        Route::put('/admin-lsp/bidang/{id}/edit', [MasterDataController::class, 'editBidang']);

        Route::patch('/admin-lsp/penyilia/{id}/status', [MasterDataController::class, 'statusPenyilia']);
        Route::post('/admin-lsp/penyilia/add', [MasterDataController::class, 'addPenyilia']);
        Route::put('/admin-lsp/penyilia/{id}/edit', [MasterDataController::class, 'editPenyilia']);

        Route::patch('/admin-lsp/jejaring/{id}/status', [MasterDataController::class, 'statusJejaring']);
        Route::post('/admin-lsp/jejaring/add', [MasterDataController::class, 'addJejaring']);
        Route::put('/admin-lsp/jejaring/{id}/edit', [MasterDataController::class, 'editJejaring']);

        Route::patch('/admin-lsp/pekerjaan/{id}/status', [MasterDataController::class, 'statusPekerjaan']);
        Route::post('/admin-lsp/pekerjaan/add', [MasterDataController::class, 'addPekerjaan']);
        Route::put('/admin-lsp/pekerjaan/{id}/edit', [MasterDataController::class, 'editPekerjaan']);

        Route::patch('/admin-lsp/pendidikan/{id}/status', [MasterDataController::class, 'statusPendidikan']);
        Route::post('/admin-lsp/pendidikan/add', [MasterDataController::class, 'addPendidikan']);
        Route::put('/admin-lsp/pendidikan/{id}/edit', [MasterDataController::class, 'editPendidikan']);

        Route::patch('/admin-lsp/sumber-anggaran/{id}/status', [MasterDataController::class, 'statusSumberAnggaran']);
        Route::post('/admin-lsp/sumber-anggaran/add', [MasterDataController::class, 'addSumberAnggaran']);
        Route::put('/admin-lsp/sumber-anggaran/{id}/edit', [MasterDataController::class, 'editSumberAnggaran']);

        Route::patch('/admin-lsp/kementerian/{id}/status', [MasterDataController::class, 'statusKementerian']);
        Route::post('/admin-lsp/kementerian/add', [MasterDataController::class, 'addKementerian']);
        Route::put('/admin-lsp/kementerian/{id}/edit', [MasterDataController::class, 'editKementerian']);
        //Surat balasan
        Route::get('/admin-lsp/cetak-surat-balasan/{pengajuan_id}', [DokumenLspController::class, 'cetakSuratBalasan']);
        Route::get('/admin-lsp/cetak-surat-balasan-ttd/{pengajuan_id}', [DokumenLspController::class, 'cetakSuratBalasanTTD']);
        //Surat SPT
        Route::get('/admin-lsp/cetak-surat-spt-asesor/{detail_id}', [DokumenLspController::class, 'cetakSptAsesor']);
        Route::get('/admin-lsp/cetak-surat-spt-asesor-ttd/{detail_id}', [DokumenLspController::class, 'cetakSptAsesorTTD']);
        Route::get('/admin-lsp/cetak-surat-spt-penyilia/{detail_id}', [DokumenLspController::class, 'cetakSptPenyilia']);
        Route::get('/admin-lsp/cetak-surat-spt-penyilia-ttd/{detail_id}', [DokumenLspController::class, 'cetakSptPenyiliaTTD']);
        //Surat Permohonan
        Route::get('/admin-lsp/cetak-surat-permohonan-asesor1/{detail_id}', [DokumenLspController::class, 'cetakPermohonanAsesor1']);
        Route::get('/admin-lsp/cetak-surat-permohonan-asesor1-ttd/{detail_id}', [DokumenLspController::class, 'cetakPermohonanAsesor1TTD']);
        Route::get('/admin-lsp/cetak-surat-permohonan-asesor2/{detail_id}', [DokumenLspController::class, 'cetakPermohonanAsesor2']);
        Route::get('/admin-lsp/cetak-surat-permohonan-asesor2-ttd/{detail_id}', [DokumenLspController::class, 'cetakPermohonanAsesor2TTD']);
        Route::get('/admin-lsp/cetak-surat-permohonan-penyilia/{detail_id}', [DokumenLspController::class, 'cetakPermohonanPenyilia']);
        //Surat Administrasi lainnya
        Route::get('/admin-lsp/cetak-surat-laporan-penyilia/{detail_id}', [DokumenLspController::class, 'cetakLaporanPenyilia']);
        Route::get('/admin-lsp/cetak-surat-berita-acara/{detail_id}', [DokumenLspController::class, 'cetakBeritaAcara']);
        Route::get('/admin-lsp/cetak-surat-penetapan-TUK/{detail_id}', [DokumenLspController::class, 'cetakPenetapanTuk']);
        Route::get('/admin-lsp/cetak-surat-SK-penyelanggara/{detail_id}', [DokumenLspController::class, 'cetakSkPenyelenggara']);
        Route::get('/admin-lsp/cetak-surat-lampiran-SK/{detail_id}', [DokumenLspController::class, 'cetakLampiranSk']);
        Route::get('/admin-lsp/cetak-surat-daftar-hadir-pra-asesmen/{detail_id}', [DokumenLspController::class, 'cetakDhPraAsesmen']);
        Route::get('/admin-lsp/cetak-surat-daftar-hadir-asesmen-h1/{detail_id}', [DokumenLspController::class, 'cetakDhAsesmenH1']);
        Route::get('/admin-lsp/cetak-surat-daftar-hadir-asesmen-h2/{detail_id}', [DokumenLspController::class, 'cetakDhAsesmenH2']);
        Route::get('/admin-lsp/cetak-surat-tanda-terima-dokumen/{detail_id}', [DokumenLspController::class, 'cetakTandaTerimaDok']);
        Route::get('/admin-lsp/cetak-surat-pernyataan-asesor-1/{detail_id}', [DokumenLspController::class, 'cetakPernyataanAsesor1']);
        Route::get('/admin-lsp/cetak-surat-pernyataan-asesor-2/{detail_id}', [DokumenLspController::class, 'cetakPernyataanAsesor2']);
        Route::get('admin-lsp/cetak-surat-pengembalian-dokumen/{detail_id}', [DokumenLspController::class, 'cetakPengembalianDok']);
        Route::get('/admin-lsp/cetak-surat-rencana-verif-TUK/{detail_id}', [DokumenLspController::class, 'cetakRencanaVerifikasi']);
        //Pleno
        Route::get('/admin-lsp/cetak-surat-sk-pleno/{detail_id}', [DokumenLspController::class, 'cetakSkPleno']);
        Route::get('/admin-lsp/cetak-surat-berita-acara-pleno/{detail_id}', [DokumenLspController::class, 'cetakBeritaAcaraPleno']);
        Route::get('/admin-lsp/cetak-surat-hasil-sidang-pleno/{detail_id}', [DokumenLspController::class, 'cetakHasilSidangPleno']);
        Route::get('/admin-lsp/cetak-surat-sk-penetapan-hasil/{detail_id}', [DokumenLspController::class, 'cetakSkPenetapanHasil']);
        Route::get('/admin-lsp/cetak-surat-hasil-final-pleno/{detail_id}', [DokumenLspController::class, 'cetakHasilFinalPleno']);

        Route::patch('/admin-lsp/pemantauan/{detail_id}/status', [AdminLspController::class, 'updateStatusTracking']);
        Route::post('/admin-lsp/pemantauan/{detail_id}/resi', [AdminLspController::class, 'inputResi']);

        Route::get('/admin-lsp/peserta-kompeten', [SertifikatController::class, 'pesertaKompeten']);
        Route::get('/admin-lsp/list-sertifikat', [SertifikatController::class, 'listDataSertifikat']);
        Route::post('/admin-lsp/tambah-data-sertifikat', [SertifikatController::class, 'tambahSertifikat']);

        Route::get('/admin-lsp/pengajuan/surat/{id}', [AdminBlkController::class, 'suratPengajuan']);

        Route::get('/admin-lsp/pengajuan-siap-ploting', [AdminLspController::class, 'getPengajuanSiapPloting']);
        Route::put('/admin-lsp/keputusan-uji/{detail_id}', [AdminLspController::class, 'hasilKeputusanUji']);
        Route::post('/admin-lsp/upload-dokumen/{detail_id}', [LspUploadController::class, 'uploadDokumenLsp']);
        Route::post('/admin-lsp/ploting-jadwal/{detail_id}', [AdminLspController::class, 'plotingJadwal']);
        Route::post('/admin-lsp/simpan-plotting-peserta/{detail_id}', [AdminLspController::class, 'simpanPlotingPeserta']);
        Route::put('/admin-lsp/{id}/batalkan-pengajuan', [AdminLspController::class, 'batalkanPengajuan']);
    });

    //Fitur Staf LSP
    Route::middleware('role:stafLsp')->group(function () {
        Route::get('/staf-lsp/semua-pengajuan', [AdminLspController::class, 'getAllPengajuan']);
        //Surat balasan
        Route::get('/staf-lsp/cetak-surat-balasan/{pengajuan_id}', [DokumenLspController::class, 'cetakSuratBalasan']);
        Route::get('/staf-lsp/cetak-surat-balasan-ttd/{pengajuan_id}', [DokumenLspController::class, 'cetakSuratBalasanTTD']);
        //Surat SPT
        Route::get('/staf-lsp/cetak-surat-spt-asesor/{detail_id}', [DokumenLspController::class, 'cetakSptAsesor']);
        Route::get('/staf-lsp/cetak-surat-spt-asesor-ttd/{detail_id}', [DokumenLspController::class, 'cetakSptAsesorTTD']);
        Route::get('/staf-lsp/cetak-surat-spt-penyilia/{detail_id}', [DokumenLspController::class, 'cetakSptPenyilia']);
        Route::get('/staf-lsp/cetak-surat-spt-penyilia-ttd/{detail_id}', [DokumenLspController::class, 'cetakSptPenyiliaTTD']);
        //Surat Permohonan
        Route::get('/staf-lsp/cetak-surat-permohonan-asesor1/{detail_id}', [DokumenLspController::class, 'cetakPermohonanAsesor1']);
        Route::get('/staf-lsp/cetak-surat-permohonan-asesor1-ttd/{detail_id}', [DokumenLspController::class, 'cetakPermohonanAsesor1TTD']);
        Route::get('/staf-lsp/cetak-surat-permohonan-asesor2/{detail_id}', [DokumenLspController::class, 'cetakPermohonanAsesor2']);
        Route::get('/staf-lsp/cetak-surat-permohonan-asesor2-ttd/{detail_id}', [DokumenLspController::class, 'cetakPermohonanAsesor2TTD']);
        Route::get('/staf-lsp/cetak-surat-permohonan-penyilia/{detail_id}', [DokumenLspController::class, 'cetakPermohonanPenyilia']);
        //Surat Administrasi lainnya
        Route::get('/staf-lsp/cetak-surat-laporan-penyilia/{detail_id}', [DokumenLspController::class, 'cetakLaporanPenyilia']);
        Route::get('/staf-lsp/cetak-surat-berita-acara/{detail_id}', [DokumenLspController::class, 'cetakBeritaAcara']);
        Route::get('/staf-lsp/cetak-surat-penetapan-TUK/{detail_id}', [DokumenLspController::class, 'cetakPenetapanTuk']);
        Route::get('/staf-lsp/cetak-surat-SK-penyelanggara/{detail_id}', [DokumenLspController::class, 'cetakSkPenyelenggara']);
        Route::get('/staf-lsp/cetak-surat-lampiran-SK/{detail_id}', [DokumenLspController::class, 'cetakLampiranSk']);
        Route::get('/staf-lsp/cetak-surat-daftar-hadir-pra-asesmen/{detail_id}', [DokumenLspController::class, 'cetakDhPraAsesmen']);
        Route::get('/staf-lsp/cetak-surat-daftar-hadir-asesmen-h1/{detail_id}', [DokumenLspController::class, 'cetakDhAsesmenH1']);
        Route::get('/staf-lsp/cetak-surat-daftar-hadir-asesmen-h2/{detail_id}', [DokumenLspController::class, 'cetakDhAsesmenH2']);
        Route::get('/staf-lsp/cetak-surat-tanda-terima-dokumen/{detail_id}', [DokumenLspController::class, 'cetakTandaTerimaDok']);
        Route::get('/staf-lsp/cetak-surat-pernyataan-asesor-1/{detail_id}', [DokumenLspController::class, 'cetakPernyataanAsesor1']);
        Route::get('/staf-lsp/cetak-surat-pernyataan-asesor-2/{detail_id}', [DokumenLspController::class, 'cetakPernyataanAsesor2']);
        Route::get('staf-lsp/cetak-surat-pengembalian-dokumen/{detail_id}', [DokumenLspController::class, 'cetakPengembalianDok']);
        Route::get('/staf-lsp/cetak-surat-rencana-verif-TUK/{detail_id}', [DokumenLspController::class, 'cetakRencanaVerifikasi']);
        //Pleno
        Route::get('/staf-lsp/cetak-surat-sk-pleno/{detail_id}', [DokumenLspController::class, 'cetakSkPleno']);
        Route::get('/staf-lsp/cetak-surat-berita-acara-pleno/{detail_id}', [DokumenLspController::class, 'cetakBeritaAcaraPleno']);
        Route::get('/staf-lsp/cetak-surat-hasil-sidang-pleno/{detail_id}', [DokumenLspController::class, 'cetakHasilSidangPleno']);
        Route::get('/staf-lsp/cetak-surat-sk-penetapan-hasil/{detail_id}', [DokumenLspController::class, 'cetakSkPenetapanHasil']);
        Route::get('/staf-lsp/cetak-surat-hasil-final-pleno/{detail_id}', [DokumenLspController::class, 'cetakHasilFinalPleno']);

        Route::patch('/staf-lsp/pemantauan/{detail_id}/status', [AdminLspController::class, 'updateStatusTracking']);
        Route::post('/staf-lsp/pemantauan/{detail_id}/resi', [AdminLspController::class, 'inputResi']);

        Route::post('/staf-lsp/upload-dokumen/{detail_id}', [LspUploadController::class, 'uploadDokumenLsp']);
    });
    
    //Fitur admin BLK
    Route::middleware('role:adminBlk')->group(function () {
        Route::get('/admin-blk/surat-balasan/{pengajuan_id}', [AdminBlkController::class, 'getSuratBalasan']);
        Route::get('/admin-blk/surat/{id}', [AdminBlkController::class, 'suratPengajuan']);
        Route::get('/admin-blk/kurikulum/{id}', [AdminBlkController::class, 'suratKurikulum']);
        Route::get('/admin-blk/download-file/{id}', [AdminBlkController::class, 'downloadDokumenFisik']);
        Route::get('/admin-blk/list-skema-pengajuan', [MasterDataController::class, 'getListSkema']);
        Route::get('/admin-blk/list-bidang-pengajuan', [MasterDataController::class, 'getListBidang']);
        Route::get('/admin-blk/list-jejaring-pengajuan', [AdminBlkController::class, 'getListTuk']);
        Route::get('/admin-blk/draft-pengajuan', [AdminBlkController::class, 'getDrafts']);
        Route::get('/admin-blk/history-pengajuan', [AdminBlkController::class, 'getDashboard']);
        
        Route::post('/admin-blk/pengajuan-ujk', [AdminBlkController::class, 'pengajuanUjk']);
        Route::post('/admin-blk/update-draft-pengajuan/{id}', [AdminBlkController::class, 'updateDraftPengajuan']);
        Route::put('/admin-blk/simpan-pengajuan-ujk/{id}', [AdminBlkController::class, 'submitPengajuan']);
        Route::delete('/admin-blk/cancel-pengajuan-ujk/{id}', [AdminBlkController::class, 'cancelPengajuan']);
    });

    //Fitur asesor
    Route::middleware('role:asesor')->group(function(){
        Route::get('/asesor/jadwal-penugasan', [AsesorController::class, 'getJadwalPenugasan']);
        Route::get('/asesor/data', [AsesorController::class, 'getDataAsesor']);
        Route::post('/asesor/edit-data', [AsesorController::class, 'dataAsesor']);  
        Route::get('/asesor/dokumen/{detail_id}', [AsesorController::class, 'getDokumenAsesor']);
        Route::get('/asesor/download-file/{id}', [AsesorController::class, 'downloadDokumenFisik']);
        Route::get('/asesor/sertifikat/{path}', [AsesorController::class, 'sertifikatAsesor'])->where('path', '.*');
    });
    
});
