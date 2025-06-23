<div
    class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-5 pt-5 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 sm:pt-6">
    <div class="mb-4 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
            Pinjaman Aktif Saat Ini
        </h3>
    </div>

    @if ($currentLoan)
        <div class="space-y-3 text-sm text-gray-700 dark:text-gray-300">
            <div class="flex justify-between">
                <span>Jumlah Pinjaman</span>
                <span class="font-semibold text-white/90">Rp
                    {{ number_format($currentLoan->total_pinjaman, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Bunga per Bulan</span>
                <span class="font-semibold text-white/90">{{ $currentLoan->bunga_pinjaman_per_bulan }}%</span>
            </div>
            <div class="flex justify-between">
                <span>Angsuran per Bulan</span>
                <span class="font-semibold text-white/90">Rp
                    {{ number_format($currentLoan->angsuran_per_bulan, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Total Pinjaman</span>
                <span class="font-semibold text-white/90">Rp
                    {{ number_format($currentLoan->total_pinjaman, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Status</span>
                <span class="font-semibold text-white/90">{{ ucfirst($currentLoan->status) }}</span>
            </div>
            <div class="flex justify-between">
                <span>Tanggal Pinjaman</span>
                <span
                    class="font-semibold text-white/90">{{ \Carbon\Carbon::parse($currentLoan->created_at)->format('d M Y') }}</span>
            </div>
            <div class="my-2"></div>
        </div>
    @else
        <div class="text-sm text-gray-500 dark:text-gray-400">
            Tidak ada pinjaman aktif saat ini.
        </div>
    @endif
</div>
