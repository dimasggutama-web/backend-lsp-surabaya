<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\DataSkemaSertifikasi;
use App\Models\JejaringLspBlk;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\SumberAnggaran;
use App\Models\Penyilia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function getListBidang(Request $request)
    {
        try {
            $query = Bidang::query();
            $filterStatus = $request->query('status');

            if ($filterStatus === 'semua') {
                //(Aktif & Non-aktif)
            } elseif (strtolower($filterStatus) === 'non-aktif') {
                //Non-aktif
                $query->where('status', 'Non-aktif'); 
            } else {
                // DEFAULT Aktif
                $query->where('status', 'Aktif');
            }

            $bidang = $query->get();

            if ($bidang->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Belum ada data bidang yang sesuai filter.',
                    'data' => []
                ], 200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Data bidang berhasil diambil.',
                'data' => $bidang
            ], 200);
        }  catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data bidang.',
                'error_detail' => $e->getMessage() 
            ], 500);
        }
    }
    public function statusBidang($id)
    {
        return $this->statusLogic(Bidang::class, $id, 'Bidang');
    }
    public function addBidang(Request $request)
    {
        $rules = [
            'kodeBidang' => 'required|string|unique:bidang,kodeBidang',
            'namaBidang' => 'required|string'
        ];

        return $this->addMasterDataLogic($request, Bidang::class, $rules, 'Bidang');
    }
    public function editBidang(Request $request, $id)
    {
        $rules = [
            'kodeBidang' => 'required|string|unique:bidang,kodeBidang,' . $id,
            'namaBidang' => 'required|string'
        ];

        return $this->editMasterDataLogic($request, $id, Bidang::class, $rules, 'Bidang');
    }

    public function getListSkema(Request $request)
    {
        try {
            $query = DataSkemaSertifikasi::query()->with('bidang');
            $filterStatus = $request->query('status');
            
            if ($filterStatus === 'semua') {
                //(Aktif & Non-aktif)
            } elseif (strtolower($filterStatus) === 'non-aktif') {
                //Non-aktif
                $query->where('status', 'Non-aktif'); 
            } else {
                // DEFAULT Aktif
                $query->where('status', 'Aktif');
            }

            $skema = $query->get();

            if ($skema->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Belum ada data skema yang sesuai filter.',
                    'data' => []
                ], 200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Data skema berhasil diambil.',
                'data' => $skema
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data skema.',
                'error_detail' => $e->getMessage() 
            ], 500);
        }
    }
    public function statusSkema($id)
    {
        return $this->statusLogic(DataSkemaSertifikasi::class, $id, 'Skema');
    }
    public function addSkema(Request $request)
    {
        $rules = [
            'kodeSkema' => 'required|string',
            'namaSkema' => 'required|string',
            'profesi'   => 'required|string',
            'bidang_id' => 'required|exists:bidang,id',
            'jenisSkema' => 'required|string'
        ];
        
        return $this->addMasterDataLogic($request, DataSkemaSertifikasi::class, $rules, 'Skema Sertifikasi');
    }
    public function editSkema(Request $request, $id)
    {
        $rules = [
            'kodeSkema' => 'required|string',
            'namaSkema' => 'required|string',   
            'profesi'   => 'required|string',
            'bidang_id' => 'required|exists:bidang,id',
            'jenisSkema' => 'required|string'
        ];
        return $this->editMasterDataLogic($request, $id, DataSkemaSertifikasi::class, $rules, 'Skema Sertifikasi');
    }

    public function getListJejaring(Request $request)
    {
        try {
            $query = JejaringLspBlk::query();
            $filterStatus = $request->query('status');

            if ($filterStatus === 'semua') {
                //(Aktif & Non-aktif)
            } elseif (strtolower($filterStatus) === 'non-aktif') {
                //Non-aktif
                $query->where('status', 'Non-aktif'); 
            } else {
                // DEFAULT Aktif
                $query->where('status', 'Aktif');
            }
            
            $jejaring = $query->get();

            if ($jejaring->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Belum ada data jejaring/TUK yang sesuai filter.',
                    'data' => []
                ], 200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Data jejaring/TUK berhasil diambil.',
                'data' => $jejaring
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data jejaring/TUK.',
                'error_detail' => $e->getMessage() 
            ], 500);
        }    
    }
    public function statusJejaring($id)
    {
        return $this->statusLogic(JejaringLspBlk::class, $id, 'Jejaring LSP/TUK'); 
    }
    public function addJejaring(Request $request)
    {
        $rules = [
            'kodeInstitusi' => 'nullable|string|unique:jejaring_lsp_blk_sby,kodeInstitusi',
            'namaInstitusi' => 'required|string',
            'alamat'        => 'required|string',
            'kota'          => 'required|string'
        ];

        return $this->addMasterDataLogic($request, JejaringLspBlk::class, $rules, 'Jejaring LSP/TUK');
    }
    public function editJejaring(Request $request, $id)
    {
        $rules = [
            'kodeInstitusi' => 'nullable|string|unique:jejaring_lsp_blk_sby,kodeInstitusi,' . $id,
            'namaInstitusi' => 'required|string',
            'alamat'        => 'required|string',
            'kota'          => 'required|string'
        ];

        return $this->editMasterDataLogic($request, $id, JejaringLspBlk::class, $rules, 'Jejaring LSP/TUK');
    }

    public function getListKementerian(Request $request)
    {
        try {
            $query = \App\Models\NamaKementerian::query();
            $filterStatus = $request->query('status');

            if ($filterStatus === 'semua') {
                //(Aktif & Non-aktif)
            } elseif (strtolower($filterStatus) === 'non-aktif') {
                //Non-aktif
                $query->where('status', 'Non-aktif'); 
            } else {
                // DEFAULT Aktif
                $query->where('status', 'Aktif');
            }

            $kementerian = $query->get();

            if ($kementerian->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Belum ada data kementerian yang sesuai filter.',
                    'data' => []
                ], 200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Data kementerian berhasil diambil.',
                'data' => $kementerian
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data kementerian.',
                'error_detail' => $e->getMessage() 
            ], 500);
        }    
    }
    public function statusKementerian($id)
    {
        return $this->statusLogic(\App\Models\NamaKementerian::class, $id, 'Nama kementerian');
    }
    public function addKementerian (Request $request)
    {
        $rules = [
            'kodeKementerian' => 'nullable|string|unique:nama_kementerian,kodeKementerian',
            'namaKementerian' => 'required|string|unique:nama_kementerian,namaKementerian',
        ];

        return $this->addMasterDataLogic($request, \App\Models\NamaKementerian::class, $rules, 'Kementerian');
    }
    public function editKementerian(Request $request, $id)
    {
        $rules = [
            'kodeKementerian' => 'nullable|string|unique:nama_kementerian,kodeKementerian,' . $id,
            'namaKementerian' => 'required|string|unique:nama_kementerian,namaKementerian,' . $id
        ];

        return $this->editMasterDataLogic($request, $id, \App\Models\NamaKementerian::class, $rules, 'Kementerian');
    }

    public function getListPekerjaan(Request $request)
    {
        try {
            $query =Pekerjaan::query();
            $filterStatus = $request->query('status');

            if ($filterStatus === 'semua') {
                //(Aktif & Non-aktif)
            } elseif (strtolower($filterStatus) === 'non-aktif') {
                //Non-aktif
                $query->where('status', 'Non-aktif'); 
            } else {
                // DEFAULT Aktif
                $query->where('status', 'Aktif');
            }

            $pekerjaan = $query->get();

            if ($pekerjaan->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Belum ada data pekerjaan yang sesuai filter.',
                    'data' => []
                ], 200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Data pekerjaan berhasil diambil.',
                'data' => $pekerjaan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data pekerjaan.',
                'error_detail' => $e->getMessage() 
            ], 500);
        }
    }
    public function statusPekerjaan($id)
    {
        return $this->statusLogic(Pekerjaan::class, $id, 'Pekerjaan');
    }
    public function addPekerjaan(Request $request)
    {
        $rules = [
            'kodePekerjaan' => 'nullable|string|unique:nama_pekerjaan,kodePekerjaan',
            'namaPekerjaan' => 'required|string|unique:nama_pekerjaan,namaPekerjaan'
        ];

        return $this->addMasterDataLogic($request, Pekerjaan::class, $rules, 'Pekerjaan');
    }
    public function editPekerjaan(Request $request, $id)
    {
        $rules = [
            'kodePekerjaan' => 'nullable|string|unique:nama_pekerjaan,kodePekerjaan,' . $id,
            'namaPekerjaan' => 'required|string|unique:nama_pekerjaan,namaPekerjaan,' . $id
        ];

        return $this->editMasterDataLogic($request, $id, Pekerjaan::class, $rules, 'Pekerjaan');
    }

    public function getListPendidikan(Request $request)
    {
        try {
            $query = Pendidikan::query();
            $filterStatus = $request->query('status');

            if ($filterStatus === 'semua') {
                //(Aktif & Non-aktif)
            } elseif (strtolower($filterStatus) === 'non-aktif') {
                //Non-aktif
                $query->where('status', 'Non-aktif'); 
            } else {
                // DEFAULT Aktif
                $query->where('status', 'Aktif');
            }

            $pendidikan = $query->get();

            if ($pendidikan->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Belum ada data pendidikan yang sesuai filter.',
                    'data' => []
                ], 200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Data pendidikan berhasil diambil.',
                'data' => $pendidikan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data pendidikan.',
                'error_detail' => $e->getMessage() 
            ], 500);
        }    
    }  
    public function statusPendidikan($id)
    {
        return $this->statusLogic(Pendidikan::class, $id, 'Pendidikan');
    }
    public function addPendidikan(Request $request)
    {
        $rules = [
            'kodePendidikan'    => 'nullable|string|unique:pendidikan,kodePendidikan',
            'jenjangPendidikan' => 'required|string|unique:pendidikan,jenjangPendidikan'
        ];

        return $this->addMasterDataLogic($request, Pendidikan::class, $rules, 'Pendidikan');
    }
    public function editPendidikan(Request $request, $id)
    {
        $rules = [
            'kodePendidikan'    => 'nullable|string|unique:pendidikan,kodePendidikan,' . $id,
            'jenjangPendidikan' => 'required|string|unique:pendidikan,jenjangPendidikan,' . $id
        ];

        return $this->editMasterDataLogic($request, $id, Pendidikan::class, $rules, 'Pendidikan');
    }

    public function getListSumberAnggaran(Request $request)
    {
        try {
            $query = SumberAnggaran::query();
            $filterStatus = $request->query('status');

            if ($filterStatus === 'semua') {
                //(Aktif & Non-aktif)
            } elseif (strtolower($filterStatus) === 'non-aktif') {
                //Non-aktif
                $query->where('status', 'Non-aktif'); 
            } else {
                // DEFAULT Aktif
                $query->where('status', 'Aktif');
            }

            $sumberAnggaran = $query->get();

            if ($sumberAnggaran->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Belum ada data sumber anggaran yang sesuai filter.',
                    'data' => []
                ], 200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Data sumber anggaran berhasil diambil.',
                'data' => $sumberAnggaran
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data sumber anggaran.',
                'error_detail' => $e->getMessage() 
            ], 500);
        }
    }  
    public function statusSumberAnggaran($id)
    {
        return $this->statusLogic(SumberAnggaran::class, $id, 'Sumber Anggaran');
    }
    public function addSumberAnggaran(Request $request)
    {
        $rules = [
            'kodeAnggaran' => 'nullable|string|unique:sumber_anggaran,kodeAnggaran',
            'namaAnggaran' => 'required|string|unique:sumber_anggaran,namaAnggaran'
        ];

        return $this->addMasterDataLogic($request, SumberAnggaran::class, $rules, 'Sumber Anggaran');
    }
    public function editSumberAnggaran(Request $request, $id)
    {
        $rules = [
            'kodeAnggaran' => 'nullable|string|unique:sumber_anggaran,kodeAnggaran,' . $id,
            'namaAnggaran' => 'required|string|unique:sumber_anggaran,namaAnggaran,' . $id
        ];

        return $this->editMasterDataLogic($request, $id, SumberAnggaran::class, $rules, 'Sumber Anggaran');
    }

    public function getListPenyilia(Request $request)
    {
        try {
            $query = Penyilia::query();
            $filterStatus = $request->query('status');

            if ($filterStatus === 'semua') {
                //(Aktif & Non-aktif)
            } elseif (strtolower($filterStatus) === 'non-aktif') {
                //Non-aktif
                $query->where('status', 'Non-aktif'); 
            } else {
                // DEFAULT Aktif
                $query->where('status', 'Aktif');
            }

            $penyilia = $query->get();

            if ($penyilia->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Belum ada data penyilia yang sesuai filter.',
                    'data' => []
                ], 200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Data penyilia berhasil diambil.',
                'data' => $penyilia
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data penyilia.',
                'error_detail' => $e->getMessage() 
            ], 500);
        }
    }
    public function statusPenyilia($id)
    {
        return $this->statusLogic(Penyilia::class, $id, 'Penyilia');
    }
    public function addPenyilia(Request $request)
    {
        $rules = [
            'namaPenyilia' => 'required|string|unique:penyilia_lsp,namaPenyilia',
            'jabatan'      => 'required|string',
            'noRegistrasi' => 'required|string|unique:penyilia_lsp,noRegistrasi', 
            'institusi'    => 'required|string',
            'alamat'       => 'required|string',
            'kota'         => 'required|string'
        ];

        return $this->addMasterDataLogic($request, Penyilia::class, $rules, 'Penyilia LSP');
    }
    public function editPenyilia(Request $request, $id)
    {
        $rules = [
            'namaPenyilia' => 'required|string|unique:penyilia_lsp,namaPenyilia,' . $id,
            'jabatan'      => 'required|string',
            'noRegistrasi' => 'required|string|unique:penyilia_lsp,noRegistrasi,' . $id,
            'institusi'    => 'required|string',
            'alamat'       => 'required|string',
            'kota'         => 'required|string'
        ];

        return $this->editMasterDataLogic($request, $id, Penyilia::class, $rules, 'Penyilia LSP');
    }

    private function statusLogic($modelClass, $id, $namaEntitas)
    {
        try {
            $data = $modelClass::find($id);
            if (!$data) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Data {$namaEntitas} tidak ditemukan."
                ], 404);
            }
            $statusBaru = ($data->status === 'Aktif') ? 'Non-aktif' : 'Aktif';
            $data->update([
                'status' => $statusBaru
            ]);
            return response()->json([
                'status' => 'success',
                'message' => "Status {$namaEntitas} berhasil diubah menjadi {$statusBaru}.",
                'data' => [
                    'id' => $data->id,
                    'status_sekarang' => $statusBaru
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Terjadi kesalahan sistem saat mengubah status {$namaEntitas}.",
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }

    public function addMasterDataLogic(Request $request, $modelClass, $validationRules, $namaEntitas) {
        $validator = Validator::make($request->all(), $validationRules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => "Gagal menambahkan data {$namaEntitas}. Periksa kembali data anda.",
                'errors' => $validator->errors()
            ], 422);
        }
        try {
            $dataBaru = $modelClass::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => "Data {$namaEntitas} berhasil ditambahkan",
                'data' => $dataBaru
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Terjadi kesalahan sistem saat menyimpan data {$namaEntitas}.",
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }

    public function editMasterDataLogic(Request $request, $id, $modelClass, $validationRules, $namaEntitas)
    {
        $validator = Validator::make($request->all(), $validationRules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => "Gagal memperbarui data master {$namaEntitas}.",
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $modelClass::find($id);

            if (!$data) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Data {$namaEntitas} dengan ID {$id} tidak ditemukan."
                ], 404);
            }

            $data->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => "Data {$namaEntitas} berhasil diperbarui.",
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Terjadi kesalahan sistem saat memperbaru data master {$namaEntitas}.",
                'error_datail' => $e->getMessage()
            ], 500);
        }
    }

    public function getStatistikLanding()
    {
        try {
            // 1. Ambil 3 Skema Paling Banyak Diuji
            $topSkema = \Illuminate\Support\Facades\DB::table('pengajuan_ujk_details')
                ->join('pengajuan_ujk', 'pengajuan_ujk_details.pengajuan_ujk_id', '=', 'pengajuan_ujk.id')
                ->join('data_skema_sertifikasi_lsp_blk_sby', 'pengajuan_ujk_details.skema_id', '=', 'data_skema_sertifikasi_lsp_blk_sby.id')
                ->whereIn('pengajuan_ujk.status', ['Menunggu', 'Disetujui'])
                ->select(
                    'data_skema_sertifikasi_lsp_blk_sby.namaSkema as nama',
                    \Illuminate\Support\Facades\DB::raw('SUM(pengajuan_ujk_details.jumlah_peserta) as asesi')
                )
                ->groupBy('data_skema_sertifikasi_lsp_blk_sby.id', 'data_skema_sertifikasi_lsp_blk_sby.namaSkema')
                ->orderByDesc('asesi')
                ->limit(3)
                ->get();
            // 2. Ambil Grafik Bulanan Asesi Sepanjang Tahun Ini
            $monthlyData = \Illuminate\Support\Facades\DB::table('pengajuan_ujk_details')
                ->join('pengajuan_ujk', 'pengajuan_ujk_details.pengajuan_ujk_id', '=', 'pengajuan_ujk.id')
                ->whereIn('pengajuan_ujk.status', ['Menunggu', 'Disetujui'])
                ->whereYear('pengajuan_ujk_details.tanggal_mulai', date('Y'))
                ->select(
                    \Illuminate\Support\Facades\DB::raw('MONTH(pengajuan_ujk_details.tanggal_mulai) as month'),
                    \Illuminate\Support\Facades\DB::raw('SUM(pengajuan_ujk_details.jumlah_peserta) as total')
                )
                ->groupBy(\Illuminate\Support\Facades\DB::raw('MONTH(pengajuan_ujk_details.tanggal_mulai)'))
                ->get();
            // Format data grafik bulanan menjadi lengkap 12 bulan (Jan - Des)
            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
            $chartData = [];
            for ($i = 1; $i <= 12; $i++) {
                $found = $monthlyData->firstWhere('month', $i);
                $chartData[] = [
                    'bulan' => $months[$i - 1],
                    'total' => $found ? (int)$found->total : 0
                ];
            }
            return response()->json([
                'status' => 'success',
                'data' => [
                    'top_skema' => $topSkema,
                    'grafik_bulanan' => $chartData
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data statistik landing.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }
}