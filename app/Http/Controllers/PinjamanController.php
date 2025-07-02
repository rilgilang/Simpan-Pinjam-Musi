<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Angsuran;
use App\Models\IndexSaham;
use App\Models\PengajuanPinjaman;
use App\Models\Pinjaman;
use App\Models\Simpanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PinjamanController extends Controller
{
    public function pinjamanList(): View
    {
        $userId = Auth::id(); // Get the current user's ID
        $user = Auth::user(); // Get the authenticated user

        if ($user->hasRole("ketua") || $user->hasRole("admin")) {
            $pinjaman = Pinjaman::join('anggota', 'anggota.id', '=', 'pinjaman.id_anggota')
                ->join('users', 'anggota.id_user', '=', 'users.id')
                ->leftJoin('angsuran', 'angsuran.id_pinjaman', '=', 'pinjaman.id')
                ->select(
                    "pinjaman.id",
                    "users.name",
                    "pinjaman.id_anggota",
                    "pinjaman.bunga_pinjaman_per_bulan",
                    "pinjaman.jumlah_pinjaman",
                    "pinjaman.created_at",
                    "pinjaman.angsuran_per_bulan",
                    "pinjaman.status",
                    "pinjaman.total_pinjaman",
                    DB::raw("COALESCE(SUM(CASE WHEN angsuran.status = 'belum dibayar' THEN angsuran.jumlah ELSE 0 END), 0) as total_belum_dibayar")
                )
                ->groupBy(
                    "pinjaman.id",
                    "users.name",
                    "pinjaman.id_anggota",
                    "pinjaman.bunga_pinjaman_per_bulan",
                    "pinjaman.jumlah_pinjaman",
                    "pinjaman.created_at",
                    "pinjaman.angsuran_per_bulan",
                    "pinjaman.status",
                    "pinjaman.total_pinjaman"
                )
                ->get();

            return view("pinjaman/pinjaman-list", ["result" => $pinjaman]);
        } else {
            $pinjaman = Pinjaman::join(
                "anggota",
                "anggota.id",
                "=",
                "pinjaman.id_anggota"
            )
                ->join("users", "anggota.id_user", "=", "users.id")
                ->select(
                    "pinjaman.id",
                    "users.name",
                    "pinjaman.id_anggota",
                    "pinjaman.bunga_pinjaman_per_bulan",
                    "pinjaman.jumlah_pinjaman",
                    "pinjaman.created_at",
                    "pinjaman.angsuran_per_bulan",
                    "pinjaman.status",
                    "pinjaman.total_pinjaman",
                    DB::raw("COALESCE(SUM(CASE WHEN angsuran.status = 'belum dibayar' THEN angsuran.jumlah ELSE 0 END), 0) as total_belum_dibayar")
                )->where('users.id', '=' , $userId)
                ->get();

            return view("pinjaman/pinjaman-list", ["result" => $pinjaman]);
        }
    }

    private function evaluateLoanApproval(
        $simpanan,
        $userCreatedAt,
        $pendapatan,
        $riwayatPinjaman,
        $pinjaman
    ) {
        $weight = [
            "c1" => 0,
            "c2" => 0,
            "c3" => 0,
            "c4" => 0,
            "c5" => 0,
        ];

        // Simpanan
        if ($simpanan > 10000000) {
            $weight["c1"] = 3 / 3;
        } elseif ($simpanan >= 5000000 && $simpanan <= 10000000) {
            $weight["c1"] = 2 / 3;
        } else {
            $weight["c1"] = 1 / 3;
        }

        // Joined
        $diffInYears = now()->diffInYears($userCreatedAt);

        if (abs($diffInYears) > 5) {
            $weight["c2"] = 3 / 3;
        } elseif (abs($diffInYears) >= 1 && abs($diffInYears) <= 5) {
            $weight["c2"] = 2 / 3;
        } else {
            $weight["c2"] = 1 / 3;
        }

        // Pendapatan
        if ($pendapatan > 5000000) {
            $weight["c3"] = 3 / 3;
        } elseif ($pendapatan >= 2000000 && $pendapatan <= 5000000) {
            $weight["c3"] = 2 / 3;
        } else {
            $weight["c3"] = 1 / 3;
        }

        // Riwayat Pinjaman
        if ($riwayatPinjaman == "lancar") {
            $weight["c4"] = 3 / 3;
        } elseif ($riwayatPinjaman == "macet") {
            $weight["c4"] = 2 / 3;
        } else {
            $weight["c4"] = 1 / 3;
        }

        // Total Pinjaman
        if ($pinjaman > 10000000) {
            $weight["c5"] = 1 / 3;
        } elseif ($pinjaman >= 5000000 && $pinjaman <= 10000000) {
            $weight["c5"] = 1 / 2;
        } else {
            $weight["c5"] = 1 / 1;
        }

        $result =
            0.25 * $weight["c1"] +
            0.15 * $weight["c2"] +
            0.25 * $weight["c3"] +
            0.15 * $weight["c4"] +
            0.2 * $weight["c5"];

        if ($result > 0.7) {
            // dd($result);
            return true;
        }

        return false;
    }

    public function pengajuanPinjamanList(): View
    {
        $user = Auth::user(); // Get the authenticated user
        $pinjaman = [];

        if ($user->hasRole("ketua") || $user->hasRole("admin")) {
            $pinjaman = PengajuanPinjaman::join(
                "anggota",
                "anggota.id",
                "=",
                "pengajuan_pinjaman.id_anggota"
            )
                ->join(
                    "simpanan",
                    "simpanan.id_anggota",
                    "=",
                    "pengajuan_pinjaman.id_anggota"
                )
                ->join("users", "anggota.id_user", "=", "users.id")
                ->select(
                    DB::raw("SUM(simpanan.jumlah) as total_simpanan"),
                    "pengajuan_pinjaman.id",
                    "users.id as user_id",
                    // "users.created_at as user_created_at",
                    "users.name",
                    "anggota.pendapatan",
                    "anggota.riwayat_pinjaman",
                    "pengajuan_pinjaman.id_anggota",
                    "pengajuan_pinjaman.bunga_pinjaman_per_bulan",
                    "pengajuan_pinjaman.jumlah_pinjaman",
                    // "pengajuan_pinjaman.created_at as pengajuan_created_at",
                    "pengajuan_pinjaman.angsuran_per_bulan",
                    "pengajuan_pinjaman.total_pinjaman",
                    "pengajuan_pinjaman.status_persetujuan_admin",
                    "pengajuan_pinjaman.status_persetujuan_ketua",
                    "pengajuan_pinjaman.alasan_penolakan_admin",
                    "pengajuan_pinjaman.alasan_penolakan_ketua",
                    "pengajuan_pinjaman.created_at"
                )
                ->groupBy(
                    "pengajuan_pinjaman.id",
                    "users.id",
                    // "users.created_at",
                    "users.name",
                    "anggota.pendapatan",
                    "anggota.riwayat_pinjaman",
                    "pengajuan_pinjaman.id_anggota",
                    "pengajuan_pinjaman.bunga_pinjaman_per_bulan",
                    "pengajuan_pinjaman.jumlah_pinjaman",
                    "pengajuan_pinjaman.created_at",
                    "pengajuan_pinjaman.angsuran_per_bulan",
                    "pengajuan_pinjaman.total_pinjaman",
                    "pengajuan_pinjaman.status_persetujuan_admin",
                    "pengajuan_pinjaman.status_persetujuan_ketua",
                    "pengajuan_pinjaman.alasan_penolakan_admin",
                    "pengajuan_pinjaman.alasan_penolakan_ketua"
                )
                ->get();

            $result = [];

            foreach ($pinjaman as $l) {
                $eligable = $this->evaluateLoanApproval(
                    $l->total_simpanan,
                    $l->user_created_at,
                    $l->pendapatan,
                    $l->riwayat_pinjaman,
                    $l->jumlah_pinjaman
                );

                $result[] = (object) [
                    "id" => $l->id,
                    "name" => $l->name,
                    "id_anggota" => $l->id_anggota,
                    "bunga_pinjaman_per_bulan" => $l->bunga_pinjaman_per_bulan,
                    "jumlah_pinjaman" => $l->jumlah_pinjaman,
                    "created_at" => $l->created_at,
                    "angsuran_per_bulan" => $l->angsuran_per_bulan,
                    "total_pinjaman" => $l->total_pinjaman,
                    "status_persetujuan_admin" => $l->status_persetujuan_admin,
                    "status_persetujuan_ketua" => $l->status_persetujuan_ketua,
                    "alasan_penolakan_admin" => $l->alasan_penolakan_admin,
                    "alasan_penolakan_ketua" => $l->alasan_penolakan_ketua,
                    "pinjaman_created_at" => $l->pinjaman_created_at,
                    "eligible" => $eligable,
                ];
            }

            return view("pinjaman/pengajuan-pinjaman-list", [
                "result" => $result,
            ]);
        } else {
            $userId = Auth::id(); // Get the current user's ID

            $pinjaman = PengajuanPinjaman::join(
                "anggota",
                "anggota.id",
                "=",
                "pengajuan_pinjaman.id_anggota"
            )
                ->join("users", "anggota.id_user", "=", "users.id")
                ->select(
                    "pengajuan_pinjaman.id",
                    "users.name",
                    "pengajuan_pinjaman.id_anggota",
                    "pengajuan_pinjaman.bunga_pinjaman_per_bulan",
                    "pengajuan_pinjaman.jumlah_pinjaman",
                    "pengajuan_pinjaman.created_at",
                    "pengajuan_pinjaman.angsuran_per_bulan",
                    "pengajuan_pinjaman.total_pinjaman",
                    "pengajuan_pinjaman.status_persetujuan_admin",
                    "pengajuan_pinjaman.status_persetujuan_ketua",
                    "pengajuan_pinjaman.alasan_penolakan_admin",
                    "pengajuan_pinjaman.alasan_penolakan_ketua"
                )
                ->where("users.id", "=", $userId)
                ->get();

            return view("pinjaman/pengajuan-pinjaman-list", [
                "result" => $pinjaman,
            ]);
        }
    }

    public function pengajuanPinjaman(Request $req)
    {
        $req->validate(
            [
                "jumlah_pinjaman" => "required|numeric",
                "angsuran" => "required|numeric",
                "total_pengajuan" => "required|numeric",
            ],
            [
                "jumlah_pinjaman.required" =>
                    "jumlah pinjaman anggota wajib diisi.",
                "angsuran.required" => "angsuran wajib diisi.",
                "total_pengajuan.required" => "total pengajuan wajib diisi.",
            ]
        );

        $userId = Auth::id(); // Get the current user's ID

        $anggota = Anggota::where("id_user", $userId)->first();

        $pengajuan = Pinjaman::where("id_anggota", "=", $anggota["id"])
            ->where("status", "=", "belum lunas")
            ->get();

        if (count($pengajuan) >= 1) {
            Alert::error(
                "Pengajuan ditolak",
                "Anda belum melunasi pinjaman anda sebelumnya"
            );
            return redirect("/pengajuan-pinjaman-list");
        }

        PengajuanPinjaman::create([
            "id_anggota" => $anggota["id"],
            "jumlah_pinjaman" => $req["jumlah_pinjaman"],
            "bunga_pinjaman_per_bulan" => 1,
            "angsuran_per_bulan" => $req["angsuran"],
            "total_pinjaman" => $req["total_pengajuan"],
            "status_persetujuan_admin" => "menunggu",
            "status_persetujuan_ketua" => "menunggu",
            "alasan_penolakan_admin" => "",
            "alasan_penolakan_ketua" => "",
        ]);

        $pinjaman = Pinjaman::all()->where("id_anggota", $anggota["id"]);

        return redirect("/pengajuan-pinjaman-list");
    }

    public function approvePengajuanPinjaman($id): View
    {
        $user = Auth::user(); // Get the authenticated user

        $pengajuan = PengajuanPinjaman::where("id", $id)
            ->select("*")
            ->first();

        try {
            DB::beginTransaction();

            if ($user->hasRole("admin")) {
                PengajuanPinjaman::where("id", $id)->update([
                    "status_persetujuan_admin" => "disetujui",
                ]);
                if ($pengajuan->status_persetujuan_ketua == "disetujui") {
                    $this->createPinjaman(10, $pengajuan);
                }
            }

            if ($user->hasRole("ketua")) {
                PengajuanPinjaman::where("id", $id)->update([
                    "status_persetujuan_ketua" => "disetujui",
                ]);
                if ($pengajuan->status_persetujuan_admin == "disetujui") {
                    $this->createPinjaman(10, $pengajuan);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            throw $e;
        }

        $pinjaman = PengajuanPinjaman::join(
            "anggota",
            "anggota.id",
            "=",
            "pengajuan_pinjaman.id_anggota"
        )
            ->join("users", "anggota.id_user", "=", "users.id")
            ->select(
                "pengajuan_pinjaman.id",
                "users.name",
                "pengajuan_pinjaman.id_anggota",
                "pengajuan_pinjaman.bunga_pinjaman_per_bulan",
                "pengajuan_pinjaman.jumlah_pinjaman",
                "pengajuan_pinjaman.created_at",
                "pengajuan_pinjaman.angsuran_per_bulan",
                "pengajuan_pinjaman.total_pinjaman",
                "pengajuan_pinjaman.status_persetujuan_admin",
                "pengajuan_pinjaman.status_persetujuan_ketua"
            )
            ->get();

        return view("pinjaman/pengajuan-pinjaman-list", [
            "result" => $pinjaman,
        ]);
    }

    public function rejectPengajuanPinjaman(Request $request)
    {
        $request->validate([
            "id" => "required|exists:pengajuan_pinjaman,id",
            "alasan" => "required|string|max:1000",
        ]);

        $id = $request->id;
        $alasan = $request->alasan;
        $user = Auth::user();

        try {
            DB::beginTransaction();

            $updateData = [];

            if ($user->hasRole("admin")) {
                $updateData["status_persetujuan_admin"] = "ditolak";
                $updateData["alasan_penolakan_admin"] = $alasan;
            }

            if ($user->hasRole("ketua")) {
                $updateData["status_persetujuan_ketua"] = "ditolak";
                $updateData["alasan_penolakan_ketua"] = $alasan;
            }

            PengajuanPinjaman::where("id", $id)->update($updateData);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        // Get updated list
        $pinjaman = PengajuanPinjaman::join(
            "anggota",
            "anggota.id",
            "=",
            "pengajuan_pinjaman.id_anggota"
        )
            ->join("users", "anggota.id_user", "=", "users.id")
            ->select(
                "pengajuan_pinjaman.id",
                "users.name",
                "pengajuan_pinjaman.id_anggota",
                "pengajuan_pinjaman.bunga_pinjaman_per_bulan",
                "pengajuan_pinjaman.jumlah_pinjaman",
                "pengajuan_pinjaman.created_at",
                "pengajuan_pinjaman.angsuran_per_bulan",
                "pengajuan_pinjaman.total_pinjaman",
                "pengajuan_pinjaman.status_persetujuan_admin",
                "pengajuan_pinjaman.status_persetujuan_ketua"
            )
            ->get();

        return redirect("/pengajuan-pinjaman-list");
    }

    private function createPinjaman($tenor, $pengajuan)
    {
        $pinjaman = Pinjaman::create([
            "id_anggota" => $pengajuan["id_anggota"],
            "id_pengajuan" => $pengajuan["id"],
            "jumlah_pinjaman" => $pengajuan["jumlah_pinjaman"],
            "bunga_pinjaman_per_bulan" =>
                $pengajuan["bunga_pinjaman_per_bulan"],
            "angsuran_per_bulan" => $pengajuan["angsuran_per_bulan"],
            "status" => "belum lunas",
            "total_pinjaman" => $pengajuan["total_pinjaman"],
        ]);

        $angsuran_arr = [];

        for ($i = 0; $i < $tenor; $i++) {
            $angsuran = [
                "id_pinjaman" => $pinjaman["id"],
                "jumlah" => $pengajuan["angsuran_per_bulan"],
                "pembayaran_ke" => $i + 1,
                "status" => "belum dibayar",
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
            ];

            array_push($angsuran_arr, $angsuran);
        }

        Angsuran::insert($angsuran_arr);
    }

    public function pinjamanDetail($id): View
    {
        $pinjaman = Pinjaman::leftJoin("anggota", "anggota.id", "=", "pinjaman.id_anggota")
            ->leftJoin("pengajuan_pinjaman", "pinjaman.id_pengajuan", "=", "pengajuan_pinjaman.id")
            ->leftJoin("angsuran", "angsuran.id_pinjaman", "=", "pinjaman.id")
            ->leftJoin("users", "anggota.id_user", "=", "users.id")
            ->select(
                "users.name",
                "users.email",
                "users.created_at as user_joined_at",
                "anggota.nik",
                "anggota.alamat",
                "anggota.nomor_hp",
                "pinjaman.id",
                "pinjaman.jumlah_pinjaman",
                "pinjaman.bunga_pinjaman_per_bulan",
                "pinjaman.status",
                "pinjaman.angsuran_per_bulan",
                "pinjaman.total_pinjaman",
                "pinjaman.created_at",
                "pengajuan_pinjaman.created_at as tanggal_pengajuan",
                DB::raw("COALESCE(SUM(CASE WHEN angsuran.status = 'belum dibayar' THEN angsuran.jumlah ELSE 0 END), 0) as total_belum_dibayar"),
                DB::raw("COALESCE(COUNT(CASE WHEN angsuran.status = 'belum dibayar' THEN 1 END), 0) as total_bulan_belum_bayar")
            )
            ->where("pinjaman.id", $id)
            ->groupBy(
                "users.name",
                "users.email",
                "users.created_at",
                "anggota.nik",
                "anggota.alamat",
                "anggota.nomor_hp",
                "pinjaman.id",
                "pinjaman.jumlah_pinjaman",
                "pinjaman.bunga_pinjaman_per_bulan",
                "pinjaman.status",
                "pinjaman.angsuran_per_bulan",
                "pinjaman.total_pinjaman",
                "pinjaman.created_at",
                "pengajuan_pinjaman.created_at"
            )
            ->first();

        $angsuran = Angsuran::all()->where("id_pinjaman", $id);
        return view("pinjaman/angsuran-detail", [
            "pinjaman" => $pinjaman,
            "angsuran" => $angsuran,
        ]);
    }

    public function updateAngsuran(Request $request, $id)
    {
        $angsuran = Angsuran::find($id);

        try {
            DB::beginTransaction();

            Angsuran::where("id", $id)->update([
                "status" => $request->input("status"),
            ]);

            $allAngsuran = Angsuran::all()
                ->where("id_pinjaman", "=", $angsuran->id_pinjaman)
                ->where("status", "=", "dibayar");

            if (count($allAngsuran) == 10) {
                Pinjaman::where("id", $angsuran->id_pinjaman)->update([
                    "status" => "lunas",
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            throw $e;
        }

        return redirect("/pinjaman/" . $angsuran->id_pinjaman);
    }

    public function shuList(): View
    {
        $anggotaList = Anggota::join(
            "users",
            "users.id",
            "=",
            "anggota.id_user"
        )
            ->select("anggota.id", "users.name")
            ->get();

        $currentIndexSaham = IndexSaham::whereYear(
            "index_saham.created_at",
            now()->year
        )->first();
        $indexSaham = IndexSaham::whereYear(
            "index_saham.created_at",
            now()->year
        )->get();

        $result = [];
        foreach ($anggotaList as $anggota) {
            // Hitung nilai saham per anggota
            $nilaiSaham =
                Simpanan::where("id_anggota", $anggota->id)
                    ->whereYear("simpanan.created_at", now()->year)
                    ->sum("jumlah") / 1000;

            $shuDiterima = $currentIndexSaham->index_saham * $nilaiSaham;

            $result[] = [
                "nama_anggota" => $anggota->name ?? "N/A",
                "nilai_saham" => $nilaiSaham,
                "shu_diterima" => $shuDiterima,
                "index_saham" => $currentIndexSaham->index_saham,
            ];
        }

        return view("shu", ["result" => $result, "index_saham" => $indexSaham]);
    }

    public function exportPinjamanToPdf()
    {
        // Join pinjaman with anggota and users
        $pinjaman = Pinjaman::join(
            "anggota",
            "anggota.id",
            "=",
            "pinjaman.id_anggota"
        )
            ->join("users", "users.id", "=", "anggota.id_user")
            ->select(
                "pinjaman.id",
                "users.name",
                "pinjaman.jumlah_pinjaman",
                "pinjaman.angsuran_per_bulan",
                "pinjaman.bunga_pinjaman_per_bulan as bunga_per_bulan",
                "pinjaman.total_pinjaman as total_peminjaman",
                "pinjaman.status",
                "pinjaman.created_at"
            )
            ->get();

        $pdf = PDF::loadView("exports.pinjaman-list-export", [
            "pinjaman" => $pinjaman,
        ])->setPaper("a4", "portrait");

        return $pdf->download(
            "daftar-pinjaman-" . Carbon::now()->format("Ymd_His") . ".pdf"
        );
    }
}
