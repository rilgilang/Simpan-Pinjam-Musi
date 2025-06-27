<?php

namespace App\Console\Commands;

use App\Models\Anggota;
use App\Models\Angsuran;
use App\Models\Pinjaman;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RunCheckingAnggotaPerformance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-checking-anggota-performance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $pinjaman = Pinjaman::where('status', 'belum lunas')->get();

        foreach ($pinjaman as $p) {
            $angsuran = Angsuran::where('id_pinjaman', $p->id)
                ->where('status', 'belum dibayar')
                ->orderBy('updated_at', 'desc')
                ->first();

            $updatedAt = Carbon::parse($angsuran['updated_at']);
            $now = Carbon::now();

            echo $updatedAt;
            $diffInMonths = $updatedAt->diffInMonths($now);

            if ($diffInMonths > 20) {
               Anggota::where("id", $p->id_anggota)->update([
                    "riwayat_pinjaman" => "macet",
                ]);
                continue;
            } 
            
            if ($diffInMonths > 10) {
               Anggota::where("id", $p->id_anggota)->update([
                    "riwayat_pinjaman" => "nunggak",
                ]);
            } 
            
        }
    }
}
