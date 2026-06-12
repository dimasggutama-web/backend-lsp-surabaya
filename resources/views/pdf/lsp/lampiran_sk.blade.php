<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lampiran SK</title>
    <style>
        /* Margin dikembalikan ke standar A4 biar ga melar ke samping */
        @page { size: A4 portrait; margin: 40px 60px; }
        
        body { font-family: 'Arial MT', Arial, sans-serif; font-size: 11px; line-height: 1.5; margin-top:8px; margin-bottom:6px; margin-left:1.7cm; margin-right:1.7cm;}
        
        .table-data { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 11px; }
        /* Padding dibuat padat tapi proporsional */
        .table-data td, .table-data th { border: 1px solid black; padding: 3px 5px; }
        
        .bold { font-weight: bold; }
        .text-center { text-align: center; }
        
        /* Garis ganda dirapikan jaraknya */
        .double-line { border-top: 3px double black; margin-top: 8px; margin-bottom: 10px; }
    </style>
</head>
<body>
    @php
        // Mengambil data Penyelia dari relasi Jadwal Asesmen
        $penyilia = $detail->jadwalAsesmen->penyilia ?? null;
        
        $namaPenyelia = $penyilia ? ($penyilia->namaPenyilia ?? $penyilia->nama ?? '-') : '-';
    @endphp

    <table align="center" style="margin-bottom: 15px; font-size: 11px;">
        <tr>
            <td width="60">Lampiran</td>
            <td width="10">:</td>
            <td>Keputusan Ketua LSP BLK SURABAYA</td>
        </tr>
        <tr>
            <td>Nomor</td>
            <td>:</td>
            <td>{{ $nomorSurat ?? '000.0C/LSP BLK-SBY/II/2026' }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td>{{ $tanggalCetak ?? '03 Februari 2026' }}</td>
        </tr>
    </table>

    <div class="text-center bold" style="font-size: 12px;">
        TIM PELAKSANAAN UJI KOMPETENSI UNTUK SKEMA {{ strtoupper($detail->skema->namaSkema ?? 'MENJAHIT DENGAN MESIN LOCKSTICH') }}<br>
        DI TUK {{ strtoupper($detail->bidang->namaBidang ?? 'Garmen') }} {{ strtoupper($detail->tuk->namaInstitusi ?? 'GARMEN UPT BLK SINGOSARI') }} TAHUN {{ \Carbon\Carbon::parse($detail->tanggal_mulai)->format('Y') }}
    </div>
    
    <div class="double-line"></div>

    <table class="table-data">
        <tr class="bold text-center">
            <td width="5%">No</td>
            <td width="50%">Nama</td>
            <td width="45%">Jabatan Dalam Organisasi</td>
        </tr>
        
        <tr class="bold">
            <td class="text-center">I.</td>
            <td colspan="2">Penanggung Jawab</td>
        </tr>
        <tr>
            <td class="text-center">1.</td>
            <td>{{ $ketuaLsp->namaPenyilia ?? '-' }}</td>
            <td class="text-center">Ketua</td>
        </tr>

        <tr class="bold">
            <td class="text-center">II.</td>
            <td colspan="2">Penyelia</td>
        </tr>
        <tr>
            <td class="text-center">1.</td>
            <td> {{ $detail->jadwalAsesmen->penyilia->namaPenyilia ?? $detail->jadwalAsesmen->penyilia->namaPenyilia ?? '-' }}</td>
            <td class="text-center">{{ $detail->jadwalAsesmen->penyilia->jabatan ?? '-' }}</td>
        </tr>

        <tr class="bold">
            <td class="text-center">III.</td>
            <td colspan="2">Pengadministrasi Uji</td>
        </tr>
        <tr>
            <td class="text-center">1.</td>
            <td>{{ $stafData->namaPenyilia ?? '-' }}</td>
            <td class="text-center">{{ $stafData->jabatan ?? '-' }}</td>
        </tr>

        <tr class="bold">
            <td class="text-center">IV.</td>
            <td colspan="2">Asesor Kompetensi</td>
        </tr>
        @foreach($detail->jadwalAsesmen->penugasanAsesor ?? [] as $index => $tugas)
        <tr>
            <td class="text-center">{{ $index + 1 }}.</td>
            <td>{{ $tugas->asesor->user->namaLengkap ?? '-' }}</td>
            <td class="text-center">Asesor</td>
        </tr>
        @endforeach

        <tr class="bold">
            <td class="text-center">V.</td>
            <td colspan="2">Peserta Uji</td>
        </tr>
        @foreach($detail->pesertaPengajuanUjk ?? [] as $index => $peserta)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $peserta->namaPeserta }}</td>
            <td class="text-center">Asesi</td>
        </tr>
        @endforeach
    </table>

    <table width="100%" style="margin-top: 15px;">
        <tr>
            <td width="55%"></td>
            <td width="45%" align="left" style="padding-left: 20px;">
                <table width="100%" style="font-size: 11px;">
                    <tr>
                        <td width="35%">Dikeluarkan di</td>
                        <td width="5%">:</td>
                        <td width="60%">Surabaya</td>
                    </tr>
                    <tr>
                        <td>Pada tanggal</td>
                        <td>:</td>
                        <td>{{ $tanggalCetak ?? '03 Februari 2026' }}</td>
                    </tr>
                </table>
                <br>
                <div align="center">
                    <strong style="font-size: 11px;">KETUA LSP BLK SURABAYA</strong><br><br><br><br>
                    <strong style="font-size: 11px;">BIBIET ANDRIYANTO JR, S.PD.T</strong>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>