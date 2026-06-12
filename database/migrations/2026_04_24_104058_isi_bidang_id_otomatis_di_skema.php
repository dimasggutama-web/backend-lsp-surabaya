    <?php

    use Illuminate\Support\Facades\DB; 
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up(): void
        {
            $semuaBidang = DB::table('bidang')->get();
            $kamusBidang = [];
            foreach ($semuaBidang as $bidang) {
                $kodePadded = str_pad($bidang->kodeBidang, 3, '0', STR_PAD_LEFT);
                $kamusBidang[$kodePadded] = $bidang->id;
            }
            $skemaList = DB::table('data_skema_sertifikasi_lsp_blk_sby')->get();
            foreach ($skemaList as $skema) {
                $potonganTeks = explode('-', $skema->kodeSkema);
                if (count($potonganTeks) >= 2) {
                    $kodeBidang = $potonganTeks[1];
                    if (isset($kamusBidang[$kodeBidang])) {
                        DB::table('data_skema_sertifikasi_lsp_blk_sby')
                            ->where('id', $skema->id)
                            ->update(['bidang_id' => $kamusBidang[$kodeBidang]]);
                    }
                }
            }
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            DB::table('data_skema_sertifikasi_lsp_blk_sby')
                ->update(['bidang_id' => null]);
        }
    };
