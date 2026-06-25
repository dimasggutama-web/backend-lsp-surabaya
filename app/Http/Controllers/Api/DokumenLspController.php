<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PengajuanUjkDetail;
use App\Models\PengajuanUjk;
use App\Models\JadwalAsesmen;

class DokumenLspController extends Controller
{
    public function cetakSuratBalasan(Request $request, $pengajuan_id)
    {
        $sudahDiplot = JadwalAsesmen::whereHas('pengajuanUjkDetail', function($q) use ($pengajuan_id) {
            $q->where('pengajuan_ujk_id', $pengajuan_id);
        })->exists();

        if (!$sudahDiplot) {
            return response()->json([
                'status' => 'error',
                'message' => 'Surat Balasan tidak bisa dicetak karena belum ada jadwal/asesor yang di-ploting!'
            ], 403);
        }

        $pengajuan = PengajuanUjk::with([
            'adminBlk.instansi', 'details.skema', 'details.bidang', 'details.tuk',
            'details.jadwalAsesmen.penyilia', 'details.jadwalAsesmen.penugasanAsesor.asesor.user'
        ])->find($pengajuan_id);

        if (!$pengajuan) return response()->json(['message' => 'Data Pengajuan tidak ditemukan'], 404);

        foreach ($pengajuan->details as $d) {
            if ($d->status_pengajuan === 'Aktif') {
                $this->catatStatusCetak($d->id, 'surat_balasan', 'surat_balasan_non_ttd');
            }
        }

        $detailPertama = $pengajuan->details->first();

        $namaTUK = $detailPertama && $detailPertama->tuk ? $detailPertama->tuk->namaInstitusi : 'TUK_Tidak_Diketahui';
        $tglMulai = $detailPertama && $detailPertama->tanggal_mulai ? \Carbon\Carbon::parse($detailPertama->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detailPertama && $detailPertama->tanggal_selesai ? \Carbon\Carbon::parse($detailPertama->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFileCustom = "Surat Balasan UJK {$namaTUK} {$tglMulai}-{$tglSelesai}.pdf";

        return $this->generatePdf($request, 'pdf.lsp.surat_balasan', ['pengajuan' => $pengajuan], $namaFileCustom, 'portrait');
    }

    public function cetakSuratBalasanTTD(Request $request, $pengajuan_id)
    {
        $sudahDiplot = JadwalAsesmen::whereHas('pengajuanUjkDetail', function($q) use ($pengajuan_id) {
            $q->where('pengajuan_ujk_id', $pengajuan_id);
        })->exists();

        if (!$sudahDiplot) {
            return response()->json([
                'status' => 'error',
                'message' => 'Surat Balasan tidak bisa dicetak karena belum ada jadwal/asesor yang di-ploting!'
            ], 403);
        }

        $pengajuan = PengajuanUjk::with([
            'adminBlk.instansi', 'details.skema', 'details.bidang', 'details.tuk',
            'details.jadwalAsesmen.penyilia', 'details.jadwalAsesmen.penugasanAsesor.asesor.user'
        ])->find($pengajuan_id);

        if (!$pengajuan) return response()->json(['message' => 'Data Pengajuan tidak ditemukan'], 404);

        foreach ($pengajuan->details as $d) {
            if ($d->status_pengajuan === 'Aktif') {
                $this->catatStatusCetak($d->id, 'surat_balasan', 'surat_balasan_ttd');
            }
        }

        $detailPertama = $pengajuan->details->first();
        $namaTUK = $detailPertama && $detailPertama->tuk ? $detailPertama->tuk->namaInstitusi : 'TUK_Tidak_Diketahui';
        $tglMulai = $detailPertama && $detailPertama->tanggal_mulai ? \Carbon\Carbon::parse($detailPertama->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detailPertama && $detailPertama->tanggal_selesai ? \Carbon\Carbon::parse($detailPertama->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFileCustom = "Surat Balasan UJK {$namaTUK} {$tglMulai}-{$tglSelesai}.pdf";

        return $this->generatePdf($request, 'pdf.lsp.surat_balasan_ttd', ['pengajuan' => $pengajuan], $namaFileCustom, 'portrait');
    }

    public function cetakSptAsesor(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. SPT Asesor tidak bisa dicetak.'], 403);
        }

        $this->catatStatusCetak($detail_id, 'surat_spt', 'spt_asesor_non_ttd');

        $namaSkema = $detail->skema->namaSkema ?? 'Skema_Tidak_Diketahui';
        $tglMulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFile = "SPT Asesor {$namaSkema} {$tglMulai}-{$tglSelesai}.pdf";
        return $this->generatePdf($request, 'pdf.lsp.spt_asesor', ['detail' => $detail], $namaFile, 'portrait');
    }
    public function cetakSptAsesorTTD(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. SPT Asesor tidak bisa dicetak.'], 403);
        }

        $this->catatStatusCetak($detail_id, 'surat_spt', 'spt_asesor_ttd');

        $namaSkema = $detail->skema->namaSkema ?? 'Skema_Tidak_Diketahui';
        $tglMulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFile = "SPT Asesor {$namaSkema} {$tglMulai}-{$tglSelesai}.pdf";
        return $this->generatePdf($request, 'pdf.lsp.spt_asesor_ttd', ['detail' => $detail], $namaFile, 'portrait');
    }

    public function cetakSptPenyilia(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. SPT Penyilia tidak bisa dicetak.'], 403);
        }

        $this->catatStatusCetak($detail_id, 'surat_spt', 'spt_penyilia_non_ttd');

        $namaSkema = $detail->skema->namaSkema ?? 'Skema_Tidak_Diketahui';
        $tglMulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFile = "SPT Penyilia {$namaSkema} {$tglMulai}-{$tglSelesai}.pdf";
        return $this->generatePdf($request, 'pdf.lsp.spt_penyilia', ['detail' => $detail], $namaFile, 'portrait');
    }
    public function cetakSptPenyiliaTTD(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. SPT Penyilia tidak bisa dicetak.'], 403);
        }

        $this->catatStatusCetak($detail_id, 'surat_spt', 'spt_penyilia_ttd');

        $namaSkema = $detail->skema->namaSkema ?? 'Skema_Tidak_Diketahui';
        $tglMulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFile = "SPT Penyilia {$namaSkema} {$tglMulai}-{$tglSelesai}.pdf";
        return $this->generatePdf($request, 'pdf.lsp.spt_penyilia_ttd', ['detail' => $detail], $namaFile, 'portrait');
    }

    public function cetakPermohonanAsesor1(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. Permohonan Asesor 1 tidak bisa dicetak.'], 403);
        }

        $this->catatStatusCetak($detail_id, 'surat_permohonan', 'permohonan_asesor_1_non_ttd');

        $namaSkema = $detail->skema->namaSkema ?? 'Skema_Tidak_Diketahui';
        $tglMulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFile = "Permohonan Asesor 1 {$namaSkema} {$tglMulai}-{$tglSelesai}.pdf";
        return $this->generatePdf($request, 'pdf.lsp.permohonan_asesor_1', ['detail' => $detail], $namaFile, 'portrait');
    }
    public function cetakPermohonanAsesor1TTD(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. Permohonan Asesor 1 tidak bisa dicetak.'], 403);
        }

        $this->catatStatusCetak($detail_id, 'surat_permohonan', 'permohonan_asesor_1_ttd');

        $namaSkema = $detail->skema->namaSkema ?? 'Skema_Tidak_Diketahui';
        $tglMulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFile = "Permohonan Asesor 1 {$namaSkema} {$tglMulai}-{$tglSelesai}.pdf";
        return $this->generatePdf($request, 'pdf.lsp.permohonan_asesor_1_ttd', ['detail' => $detail], $namaFile, 'portrait');
    }

    public function cetakPermohonanAsesor2(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. Permohonan Asesor 2 tidak bisa dicetak.'], 403);
        }

        $this->catatStatusCetak($detail_id, 'surat_permohonan', 'permohonan_asesor_2_non_ttd');

        $namaSkema = $detail->skema->namaSkema ?? 'Skema_Tidak_Diketahui';
        $tglMulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFile = "Permohonan Asesor 2 {$namaSkema} {$tglMulai}-{$tglSelesai}.pdf";
        return $this->generatePdf($request, 'pdf.lsp.permohonan_asesor_2', ['detail' => $detail], $namaFile, 'portrait');
    }
    public function cetakPermohonanAsesor2TTD(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. Permohonan Asesor 2 tidak bisa dicetak.'], 403);
        }

        $this->catatStatusCetak($detail_id, 'surat_permohonan', 'permohonan_asesor_2_ttd');

        $namaSkema = $detail->skema->namaSkema ?? 'Skema_Tidak_Diketahui';
        $tglMulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFile = "Permohonan Asesor 2 TTD {$namaSkema} {$tglMulai}-{$tglSelesai}.pdf";
        return $this->generatePdf($request, 'pdf.lsp.permohonan_asesor_2_ttd', ['detail' => $detail], $namaFile, 'portrait');
    }

    public function cetakPermohonanPenyilia(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. Permohonan Penyilia tidak bisa dicetak.'], 403);
        }

        $this->catatStatusCetak($detail_id, 'surat_permohonan', 'permohonan_penyilia');

        $namaSkema = $detail->skema->namaSkema ?? 'Skema_Tidak_Diketahui';
        $tglMulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFile = "Permohonan Penyilia {$namaSkema} {$tglMulai}-{$tglSelesai}.pdf";
        return $this->generatePdf($request, 'pdf.lsp.permohonan_penyilia', ['detail' => $detail], $namaFile, 'portrait');
    }

    public function cetakLaporanPenyilia(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);

        if (!$detail) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. Laporan Penyilia tidak bisa dicetak.'], 403);
        }

        $this->catatStatusCetak($detail_id, 'surat_administrasi', 'laporan_penyilia');

        $namaSkema = $detail->skema->namaSkema ?? 'Skema_Tidak_Diketahui';
        $tglMulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $detail->load([
            'pesertaPengajuanUjk.asesor.user', 
            'jadwalAsesmen.penugasanAsesor.asesor.user',
            'jadwalAsesmen.penyilia',
            'tuk'
        ]);

        $namaFile = "Laporan Penyilia {$namaSkema} {$tglMulai}-{$tglSelesai}.pdf";
            
        return $this->generatePdf($request, 'pdf.lsp.laporan_penyilia', ['detail' => $detail], $namaFile, 'portrait');
   }

    public function cetakBeritaAcara(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. Berita Acara tidak bisa dicetak.'], 403);
        }

        $this->catatStatusCetak($detail_id, 'surat_administrasi', 'berita_acara');

        $namaSkema = $detail->skema->namaSkema ?? 'Skema_Tidak_Diketahui';
        $tglMulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFile = "Berita_Acara {$namaSkema} {$tglMulai}-{$tglSelesai}.pdf";
        return $this->generatePdf($request, 'pdf.lsp.berita_acara', ['detail' => $detail], $namaFile, 'portrait');
    }

    public function cetakPenetapanTuk(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. Penetapan TUK tidak bisa dicetak.'], 403);
        }

        $this->catatStatusCetak($detail_id, 'surat_administrasi', 'penetapan_tuk');

        $namaSkema = $detail->skema->namaSkema ?? 'Skema_Tidak_Diketahui';
        $tglMulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFile = "Penetapan TUK {$namaSkema} {$tglMulai}-{$tglSelesai}.pdf";
        return $this->generatePdf($request, 'pdf.lsp.penetapan_tuk', ['detail' => $detail], $namaFile, 'portrait');
    }

    public function cetakSkPenyelenggara(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. SK Penyelenggara tidak bisa dicetak.'], 403);
        }

        $this->catatStatusCetak($detail_id, 'surat_administrasi', 'sk_penyelenggara');

        $namaSkema = $detail->skema->namaSkema ?? 'Skema_Tidak_Diketahui';
        $tglMulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFile = "SK Penyelenggara {$namaSkema} {$tglMulai}-{$tglSelesai}.pdf";
        return $this->generatePdf($request, 'pdf.lsp.sk_penyelenggara', ['detail' => $detail], $namaFile, 'portrait');
    }

    public function cetakLampiranSk(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. Lampiran SK tidak bisa dicetak.'], 403);
        }

        // Ambil data Ketua LSP
        $ketuaLsp = \App\Models\Penyilia::where('jabatan', 'Ketua LSP')->first();
        $stafData = \App\Models\Penyilia::where('jabatan', 'Staf Data')->first();

        $namaSkema = $detail->skema->namaSkema ?? 'Skema_Tidak_Diketahui';
        $tglMulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFile = "Lampiran SK {$namaSkema} {$tglMulai}-{$tglSelesai}.pdf";

        // PASTIKAN SEMUA DATA MASUK DALAM SATU ARRAY $data
        $data = [
            'detail' => $detail,
            'ketuaLsp' => $ketuaLsp,
            'stafData' => $stafData,
            'penanggungJawab' => $request->query('penanggung_jawab'),
            'pengadministrasi' => $request->query('pengadministrasi'),
        ];

        $this->catatStatusCetak($detail_id, 'surat_administrasi', 'lampiran_sk');

        return $this->generatePdf($request, 'pdf.lsp.lampiran_sk', $data, $namaFile, 'landscape');
    }

    public function cetakDhPraAsesmen(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. Daftar Hadir Pra Asesmen tidak bisa dicetak.'], 403);
        }

        $data = [
            'detail' => $detail,
            'nomorSptAsesor' => $request->query('nomor_spt_asesor', '........./SPT-ASESOR/........./' . date('Y')),
            'nomorSptPenyilia' => $request->query('nomor_spt_penyilia', '........./SPT-PENYILIA/........./' . date('Y')),
        ];

        $this->catatStatusCetak($detail_id, 'surat_administrasi', 'daftar_hadir_pra_asesmen');

        $namaSkema = $detail->skema->namaSkema ?? 'Skema_Tidak_Diketahui';
        $tglMulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFile = "Daftar Hadir Pra Asesmen {$namaSkema} {$tglMulai}-{$tglSelesai}.pdf";
        return $this->generatePdf($request, 'pdf.lsp.daftar_hadir_pra-asesmen', $data, $namaFile, 'landscape');
    }

    public function cetakDhAsesmenH1(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. Daftar Hadir Asesmen H1 tidak bisa dicetak.'], 403);
        }

        $data = [
            'detail' => $detail,
            'nomorSptAsesor' => $request->query('nomor_spt_asesor', '........./SPT-ASESOR/........./' . date('Y')),
            'nomorSptPenyilia' => $request->query('nomor_spt_penyilia', '........./SPT-PENYILIA/........./' . date('Y')),
        ];

        $this->catatStatusCetak($detail_id, 'surat_administrasi', 'daftar_hadir_asesmen_h1');

        $namaSkema = $detail->skema->namaSkema ?? 'Skema_Tidak_Diketahui';
        $tglMulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFile = "Daftar Hadir Asesmen H1 {$namaSkema} {$tglMulai}-{$tglSelesai}.pdf";
        return $this->generatePdf($request, 'pdf.lsp.daftar_hadir_asesmen_h1', $data, $namaFile, 'landscape');
    }

    public function cetakDhAsesmenH2(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. Daftar Hadir Asesmen H2 tidak bisa dicetak.'], 403);
        }

        $data = [
            'detail' => $detail,
            'nomorSptAsesor' => $request->query('nomor_spt_asesor', '........./SPT-ASESOR/........./' . date('Y')),
            'nomorSptPenyilia' => $request->query('nomor_spt_penyilia', '........./SPT-PENYILIA/........./' . date('Y')),
        ];

        $this->catatStatusCetak($detail_id, 'surat_administrasi', 'daftar_hadir_asesmen_h2');

        $namaSkema = $detail->skema->namaSkema ?? 'Skema_Tidak_Diketahui';
        $tglMulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFile = "Daftar Hadir Asesmen H2 {$namaSkema} {$tglMulai}-{$tglSelesai}.pdf";
        return $this->generatePdf($request, 'pdf.lsp.daftar_hadir_asesmen_h2', $data, $namaFile, 'landscape');
    }

    public function cetakTandaTerimaDok(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. Tanda Terima Dokumen tidak bisa dicetak.'], 403);
        }

        $this->catatStatusCetak($detail_id, 'surat_administrasi', 'tanda_terima_dokumen');

        $namaSkema = $detail->skema->namaSkema ?? 'Skema_Tidak_Diketahui';
        $tglMulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFile = "Tanda Terima Dokumen {$namaSkema} {$tglMulai}-{$tglSelesai}.pdf";
        return $this->generatePdf($request, 'pdf.lsp.tanda_terima_dokumen', ['detail' => $detail], $namaFile, 'portrait');
    }

    public function cetakPernyataanAsesor1(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        $detail->load('skema.bidang');
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. Pernyataan Asesor 1 tidak bisa dicetak.'], 403);
        }

        $this->catatStatusCetak($detail_id, 'surat_administrasi', 'pernyataan_asesor_1');

        $namaSkema = $detail->skema->namaSkema ?? 'Skema_Tidak_Diketahui';
        $tglMulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFile = "Pernyataan Asesor 1 {$namaSkema} {$tglMulai}-{$tglSelesai}.pdf";
        return $this->generatePdf($request, 'pdf.lsp.pernyataan_asesor_1', ['detail' => $detail], $namaFile, 'portrait');
    }

    public function cetakPernyataanAsesor2(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        $detail->load('skema.bidang');
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. Pernyataan Asesor 2 tidak bisa dicetak.'], 403);
        }

        $this->catatStatusCetak($detail_id, 'surat_administrasi', 'pernyataan_asesor_2');

        $namaSkema = $detail->skema->namaSkema ?? 'Skema_Tidak_Diketahui';
        $tglMulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFile = "Pernyataan Asesor 2 {$namaSkema} {$tglMulai}-{$tglSelesai}.pdf";
        return $this->generatePdf($request, 'pdf.lsp.pernyataan_asesor_2', ['detail' => $detail], $namaFile, 'portrait');
    }

    public function cetakPengembalianDok(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. Pengembalian Dokumen tidak bisa dicetak.'], 403);
        }

        $this->catatStatusCetak($detail_id, 'surat_administrasi', 'pengembalian_dokumen');

        $namaSkema = $detail->skema->namaSkema ?? 'Skema_Tidak_Diketahui';
        $tglMulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFile = "Pengembalian Dokumen {$namaSkema} {$tglMulai}-{$tglSelesai}.pdf";
        return $this->generatePdf($request, 'pdf.lsp.pengembalian_dokumen_asesmen', ['detail' => $detail], $namaFile, 'portrait');
    }

    public function cetakRencanaVerifikasi(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. Rencana Verifikasi TUK tidak bisa dicetak.'], 403);
        }

        $inputTanggal = $request->query('tanggal_rencana_verif_tuk', $detail->tanggal_mulai);

        $tanggalVerifikasiFormatted = \Carbon\Carbon::parse($inputTanggal)
                                        ->locale('id')
                                        ->translatedFormat('l / d F Y');

        $data = [
            'detail' => $detail,
            'tanggalRencanaVerifikasi' => $tanggalVerifikasiFormatted
        ];

        $this->catatStatusCetak($detail_id, 'surat_administrasi', 'rencana_verifikasi_tuk');

        $namaSkema = $detail->skema->namaSkema ?? 'Skema_Tidak_Diketahui';
        $tglMulai = $detail->tanggal_mulai ? \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d') : 'Tanggal_Tidak_Diketahui';
        $tglSelesai = $detail->tanggal_selesai ? \Carbon\Carbon::parse($detail->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : 'Tanggal_Tidak_Diketahui';

        $namaFile = "Rencana Verifikasi TUK {$namaSkema} {$tglMulai}-{$tglSelesai}.pdf";

        return $this->generatePdf($request, 'pdf.lsp.rencana_verifikasi_tuk', $data, $namaFile, 'portrait');
    }

    public function cetakSkPleno(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. SK Pleno tidak bisa dicetak.'], 403);
        }

        $nomorSuratInput = $request->query('nomor_surat');
        $tanggalSuratInput = $request->query('tanggal_surat');
        
        if ($nomorSuratInput || $tanggalSuratInput) {
            $detail->no_pleno = $nomorSuratInput ?? $detail->no_pleno;
            
            if ($tanggalSuratInput) {
                $detail->tanggal_pleno = \Carbon\Carbon::parse($tanggalSuratInput)->format('Y-m-d');
            }
            
            $detail->status_cetak = 'Selesai'; 
            $detail->save();
        }

        $dbKomite1 = \App\Models\Penyilia::where('jabatan', 'Manajer Sertifikasi')->first();
        $komite1 = (object)[
            'nama' => $dbKomite1 ? $dbKomite1->namaPenyilia : '-', 
            'jabatan' => $dbKomite1 ? $dbKomite1->jabatan : '-'
        ];

        $namaKomite2 = $request->query('komite_2_nama', 'Risna Amalia'); 
        $dbKomite2 = \App\Models\Penyilia::where('namaPenyilia', $namaKomite2)->first();

        if (!$dbKomite2) {
            return response()->json(['message' => "Komite 2 dengan nama '{$namaKomite2}' tidak terdaftar di data Penyilia."], 404);
        }

        $komite2 = (object)[
            'nama' => $dbKomite2->namaPenyilia,
            'jabatan' => $dbKomite2->jabatan
        ];

        $namaKomite3 = $request->query('komite_3_nama', 'Riski Tri');
        $dbKomite3 = \App\Models\Penyilia::where('namaPenyilia', $namaKomite3)->first();

        if (!$dbKomite3) {
            return response()->json(['message' => "Komite 3 dengan nama '{$namaKomite3}' tidak terdaftar di data Penyilia."], 404);
        }

        $komite3 = (object)[
            'nama' => $dbKomite3->namaPenyilia,
            'jabatan' => $dbKomite3->jabatan
        ];

        $data = [
            'detail' => $detail,
            'komite1' => $komite1,
            'komite2' => $komite2,
            'komite3' => $komite3,
        ];

        $this->catatStatusCetak($detail_id, 'surat_pleno', 'sk_pleno');

        $namaFile = 'SK_Pleno_' . str_replace(' ', '_', $detail->skema->namaSkema) . '_' . $detail->id;
        return $this->generatePdf($request, 'pdf.lsp.sk_pleno', $data, $namaFile, 'portrait');
    }

    public function cetakBeritaAcaraPleno(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. Berita Acara Pleno tidak bisa dicetak.'], 403);
        }

        $dbKomite1 = \App\Models\Penyilia::where('jabatan', 'Manajer Sertifikasi')->first();
        $komite1 = (object)[
            'nama' => $dbKomite1 ? $dbKomite1->namaPenyilia : 'Yudo Sembodo H.L',
            'jabatan' => $dbKomite1 ? $dbKomite1->jabatan : 'Manajer Sertifikasi'
        ];

        $namaKomite2 = $request->query('komite_2_nama', 'Risna Amalia'); 
        $dbKomite2 = \App\Models\Penyilia::where('namaPenyilia', $namaKomite2)->first();
        if (!$dbKomite2) {
            return response()->json(['message' => "Komite 2 dengan nama '{$namaKomite2}' tidak terdaftar di data Penyilia."], 404);
        }

        $komite2 = (object)[
            'nama' => $dbKomite2->namaPenyilia,
            'jabatan' => $dbKomite2->jabatan
        ];

        $namaKomite3 = $request->query('komite_3_nama', 'Riski Tri');
        $dbKomite3 = \App\Models\Penyilia::where('namaPenyilia', $namaKomite3)->first();
        if (!$dbKomite3) {
            return response()->json(['message' => "Komite 3 dengan nama '{$namaKomite3}' tidak terdaftar di data Penyilia."], 404);
        }

        $komite3 = (object)[
            'nama' => $dbKomite3->namaPenyilia,
            'jabatan' => $dbKomite3->jabatan
        ];

        $data = [
            'detail' => $detail,
            'komite1' => $komite1,
            'komite2' => $komite2,
            'komite3' => $komite3,
        ];

        $this->catatStatusCetak($detail_id, 'surat_pleno', 'berita_acara_pleno');

        $namaFile = 'Berita_Acara_Pleno_' . str_replace(' ', '_', $detail->skema->namaSkema) . '_' . $detail->id;
        
        return $this->generatePdf($request, 'pdf.lsp.berita_acara_pleno', $data, $namaFile, 'portrait');
    }

    public function cetakHasilSidangPleno(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. Hasil Sidang Pleno tidak bisa dicetak.'], 403);
        }

        $data = [
            'detail' => $detail,
            'nomorSuratLampiran' => $request->query('nomor_surat_lampiran', '000.0A/BA-PLENO/LSP-BLK-SBY/II/' . date('Y'))
        ];

        $this->catatStatusCetak($detail_id, 'surat_pleno', 'hasil_sidang_pleno');

        $namaFile = 'Hasil_Sidang_Pleno_' . str_replace(' ', '_', $detail->skema->namaSkema) . '_' . $detail->id;
        
        return $this->generatePdf($request, 'pdf.lsp.hasil_sidang_pleno', $data, $namaFile, 'landscape');
    }

    public function cetakSkPenetapanHasil(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. SK Penetapan Hasil Pleno tidak bisa dicetak.'], 403);
        }

        $this->catatStatusCetak($detail_id, 'surat_pleno', 'sk_penetapan_hasil');

        $namaFile = 'SK_Penetapan_Hasil_' . str_replace(' ', '_', $detail->skema->namaSkema) . '_' . $detail->id;
        return $this->generatePdf($request, 'pdf.lsp.sk_penetapan_hasil', ['detail' => $detail], $namaFile, 'portrait');
    }

    public function cetakHasilFinalPleno(Request $request, $detail_id)
    {
        $detail = $this->getDetailData($detail_id);
        if (!$detail) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        if (!$detail->jadwalAsesmen) {
            return response()->json(['message' => 'Jadwal Asesmen belum dibuat. Hasil Final Pleno tidak bisa dicetak.'], 403);
        }
        
        $pesertaLulus = $detail->pesertaPengajuanUjk->filter(function($peserta) {
            return strtolower($peserta->keputusan_uji) === 'kompeten';
        })->values();

        $detail->setRelation('pesertaPengajuanUjk', $pesertaLulus);

        $data = [
            'detail' => $detail,
            'nomorSuratLampiran' => $request->query('nomor_surat_lampiran', '000.0A/BA-PLENO/LSP-BLK-SBY/II/' . date('Y'))
        ];

        $this->catatStatusCetak($detail_id, 'surat_pleno', 'hasil_final_pleno');

        $namaFile = 'Hasil_Final_Pleno_' . str_replace(' ', '_', $detail->skema->namaSkema) . '_' . $detail->id;
        
        return $this->generatePdf($request, 'pdf.lsp.hasil_final_pleno', $data, $namaFile, 'landscape');
    }

    private function getDetailData($detail_id)
    {
        return PengajuanUjkDetail::with([
            'pengajuan.adminBlk.instansi',
            'pengajuan.sumberAnggaran',
            'bidang',
            'skema',
            'tuk',
            'pesertaPengajuanUjk',
            'jadwalAsesmen.penyilia', 
            'jadwalAsesmen.penugasanAsesor.asesor.user.instansi'
        ])->find($detail_id);
    }

    private function generatePdf(Request $request, $view, $data, $namaFile, $orientasi = 'portrait')
    {
        \Carbon\Carbon::setLocale('id');
        // 1. Tangkap parameter dari URL
        $data['nomorSurat'] = $request->query('nomor_surat', '........./LSP BLK-SBY/........./' . date('Y'));
        
        $tanggalInput = $request->query('tanggal_surat');
        $data['tanggalCetak'] = $tanggalInput 
            ? \Carbon\Carbon::parse($tanggalInput)->translatedFormat('d F Y') 
            : \Carbon\Carbon::now()->translatedFormat('d F Y');

        // 2. Rakit PDF
        $pdf = Pdf::loadView($view, $data)
            ->setOptions(['defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf->setPaper('A4', $orientasi);

        // 3. Bersihkan garis miring ( / atau \ ) jadi underscore ( _ ) biar gak error di OS
        $amanNamaFile = str_replace(['/', '\\'], '_', $namaFile);

        // 4. Download PDF
        return $pdf->stream($amanNamaFile . '.pdf');
    }

    private function catatStatusCetak($detail_id, $kategori, $nama_surat)
    {
        \App\Models\StatusDokumen::updateOrCreate(
            [
                'pengajuan_ujk_detail_id' => $detail_id,
                'nama_surat' => $nama_surat
            ],
            [
                'kategori' => $kategori,
                'status' => 'Sudah Dicetak',
                'waktu_cetak' => now(),
                'user_id' => auth()->check() ? auth()->id() : null 
            ]
        );
    }
    public function getStatusDokumen($detail_id)
    {
        // 1. Tarik semua riwayat cetak yang ADA di database untuk jadwal ini
        $dokumenDicetak = \App\Models\StatusDokumen::where('pengajuan_ujk_detail_id', $detail_id)
            ->get()
            ->keyBy('nama_surat'); // Di-keyBy biar kita gampang nyari pake isset()

        // 2. Tulis DAFTAR MASTER SURAT (Ke-29 surat lu kelompokin per kategori)
        $masterSurat = [
            'surat_balasan' => [
                'surat_balasan_non_ttd' => 'Surat Balasan (Non-TTD)',
                'surat_balasan_ttd'     => 'Surat Balasan TTD',
            ],
            'surat_spt' => [
                'spt_asesor_non_ttd'   => 'Surat SPT Asesor (Non-TTD)',
                'spt_asesor_ttd'       => 'Surat SPT Asesor TTD',
                'spt_penyilia_non_ttd' => 'Surat SPT Penyilia (Non-TTD)',
                'spt_penyilia_ttd'     => 'Surat SPT Penyilia TTD',
            ],
            'surat_permohonan' => [
                'permohonan_asesor_1_non_ttd' => 'Surat Permohonan Asesor 1 (Non-TTD)',
                'permohonan_asesor_1_ttd'     => 'Surat Permohonan Asesor 1 TTD',
                'permohonan_asesor_2_non_ttd' => 'Surat Permohonan Asesor 2 (Non-TTD)',
                'permohonan_asesor_2_ttd'     => 'Surat Permohonan Asesor 2 TTD',
                'permohonan_penyilia'         => 'Surat Permohonan Penyilia',
            ],
            'administrasi' => [
                'laporan_penyilia'             => 'Surat Laporan Penyilia',
                'berita_acara_pelaksanaan'     => 'Surat Berita Acara Pelaksanaan',
                'penetapan_tuk'                => 'Surat Penetapan TUK',
                'sk_penyelenggara'             => 'Surat SK Penyelenggara',
                'lampiran_sk'                  => 'Surat Lampiran SK',
                'dh_pra_asesmen'               => 'Surat DH Pra-Asesmen',
                'dh_1_asesmen'                 => 'Surat DH 1 Asesmen',
                'dh_2_asesmen'                 => 'Surat DH 2 Asesmen',
                'tanda_terima_dokumen'         => 'Surat Tanda Terima Dokumen',
                'pernyataan_asesor_1'          => 'Surat Pernyataan Asesor 1',
                'pernyataan_asesor_2'          => 'Surat Pernyataan Asesor 2',
                'pengembalian_dokumen_asesmen' => 'Surat Pengembalian Dokumen Asesmen',
                'rencana_verifikasi_tuk'       => 'Surat Rencana Verifikasi TUK',
            ],
            'administrasi_pleno' => [
                'sk_pleno'            => 'Surat SK Pleno',
                'berita_acara_pleno'  => 'Surat Berita Acara Pleno',
                'hasil_sidang_pleno'  => 'Surat Hasil Sidang Pleno',
                'sk_penetapan_hasil'  => 'Surat SK Penetapan Hasil',
                'hasil_final_pleno'   => 'Surat Hasil Final Pleno',
            ]
        ];

        $responseResult = [];

        // 3. PROSES COCOKOLOGI (Looping per Kategori)
        foreach ($masterSurat as $kategori => $daftarSurat) {
            $listSuratKategori = [];
            $totalCetak = 0;

            // Looping isi surat di dalam kategori itu
            foreach ($daftarSurat as $kode => $namaFormat) {
                // Cek apakah kode surat ini ada di database log cetak
                $sudahDicetak = isset($dokumenDicetak[$kode]);

                if ($sudahDicetak) {
                    $totalCetak++;
                }

                // Masukin data detil suratnya
                $listSuratKategori[] = [
                    'kode_surat'   => $kode,
                    'nama_surat'   => $namaFormat,
                    'status_surat' => $sudahDicetak ? 'Sudah Dicetak' : 'Belum Dicetak',
                    'waktu_cetak'  => $sudahDicetak ? $dokumenDicetak[$kode]->waktu_cetak : null
                ];
            }

            // Masukin data kategori dan gabungin sama list suratnya
            $responseResult[] = [
                'kategori'      => $kategori,
                'is_lengkap'    => $totalCetak === count($daftarSurat), 
                'total_surat'   => count($daftarSurat),
                'total_dicetak' => $totalCetak,
                'list_surat'    => $listSuratKategori 
            ];
        }

        return response()->json([
            'status' => 'success',
            'data'   => $responseResult
        ], 200);
    }
}
