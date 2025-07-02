<x-app-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6">
        <!-- Breadcrumb Start -->
        <div x-data="{ pageName: `Basic Tables` }">
            <include src="./partials/breadcrumb.html" />
        </div>
        <!-- Breadcrumb End -->

        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <div class="grid grid-cols-12">

                        <h3 class="col-span-10 text-base font-medium text-gray-800 dark:text-white/90">
                            Daftar Pinjaman
                        </h3>

                        <a href="/pinjaman/export"
                            class="col-span-2 inline-flex items-center gap-2 rounded-lg bg-white px-4 py-3 text-center text-sm font-medium text-gray-700 shadow-theme-xs ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">
                            Ekspor Ke PDF
                        </a>
                    </div>

                </div>
                <div class="border-t border-gray-100 p-5 dark:border-gray-800 sm:p-6">
                    <div
                        class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="max-w-full overflow-x-auto">
                            <table class="min-w-full">
                                <!-- table header start -->
                                <thead>
                                    <tr class="border-b border-gray-100 dark:border-gray-800">
                                        <th class="px-5 py-3 sm:px-6">
                                            <div class="flex items-center">
                                                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                                                    Nama Anggota
                                                </p>
                                            </div>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <div class="flex items-center">
                                                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                                                    Jumlah Pinjaman
                                                </p>
                                            </div>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <div class="flex items-center">
                                                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                                                    Angsuran Perbulan
                                                </p>
                                            </div>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <div class="flex items-center">
                                                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                                                    Bunga Perbulan
                                                </p>
                                            </div>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <div class="flex items-center">
                                                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                                                    Total Peminjaman
                                                </p>
                                            </div>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <div class="flex items-center">
                                                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                                                    Sisa Pembayaran
                                                </p>
                                            </div>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <div class="flex items-center">
                                                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                                                    Tanggal Pengajuan
                                                </p>
                                            </div>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <div class="flex items-center">
                                                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                                                    Status
                                                </p>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>

                                <!-- table header end -->
                                <!-- table body start -->
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    @foreach ($result as $pinjaman)
                                        <tr onclick="window.location.href='{{ route('detail-pinjaman', $pinjaman->id) }}'"
                                            class="hover:cursor-pointer sm:px-6">
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <div class="flex items-center gap-3">
                                                        {{-- <div class="h-10 w-10 overflow-hidden rounded-full">
                                                            <img src="./images/user/user-17.jpg" alt="brand" />
                                                        </div> --}}

                                                        <div>
                                                            <span
                                                                class="block text-theme-sm font-medium text-gray-800 dark:text-white/90">
                                                                {{ $pinjaman->name }}
                                                            </span>
                                                            {{-- <span
                                                            class="block text-theme-xs text-gray-500 dark:text-gray-400">
                                                            Web Designer
                                                        </span> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                                        Rp{{ number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                                        Rp{{ number_format($pinjaman->angsuran_per_bulan, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                                        {{ $pinjaman->bunga_pinjaman_per_bulan }}%
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <div class="flex items-center">
                                                        <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                                            Rp{{ number_format($pinjaman->total_pinjaman, 0, ',', '.') }}
                                                        </p>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <div class="flex items-center">
                                                        <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                                            Rp{{ number_format($pinjaman->total_belum_dibayar, 0, ',', '.') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <div class="flex items-center">
                                                        <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                                            {{ $pinjaman->created_at }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <div class="flex items-center">
                                                        <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                                            {{ $pinjaman->status }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openModal(data) {
            if (data) {
                document.getElementsByName("name")[0].value = "asdasd";
                document.getElementsByName("email")[0].value = data.email;
                document.getElementsByName("phone_number")[0].value = data.phone_number;
                document.getElementsByName("alamat")[0].value = data.alamat;
            }
            document.getElementById("eventModal").style.display = "flex";
        }

        const closeModal = () => {
            document.getElementById("eventModal").style.display = "none";
        };
    </script>

</x-app-layout>
