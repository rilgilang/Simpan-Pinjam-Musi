<x-app-layout>
    {{-- MODAL --}}
    <div class="modal fixed inset-0 z-99999 hidden items-center justify-center overflow-y-auto p-5" id="eventModal">
        <div class="modal-close-btn fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]"></div>
        <div
            class="modal-dialog modal-dialog-scrollable modal-lg no-scrollbar relative flex w-full max-w-[700px] flex-col overflow-y-auto rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-11">
            <!-- close btn -->
            <button onclick="closeModal()"
                class="modal-close-btn transition-color absolute right-5 top-5 z-999 flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:bg-gray-700 dark:bg-white/[0.05] dark:text-gray-400 dark:hover:bg-white/[0.07] dark:hover:text-gray-300 sm:h-11 sm:w-11">
                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M6.04289 16.5418C5.65237 16.9323 5.65237 17.5655 6.04289 17.956C6.43342 18.3465 7.06658 18.3465 7.45711 17.956L11.9987 13.4144L16.5408 17.9565C16.9313 18.347 17.5645 18.347 17.955 17.9565C18.3455 17.566 18.3455 16.9328 17.955 16.5423L13.4129 12.0002L17.955 7.45808C18.3455 7.06756 18.3455 6.43439 17.955 6.04387C17.5645 5.65335 16.9313 5.65335 16.5408 6.04387L11.9987 10.586L7.45711 6.04439C7.06658 5.65386 6.43342 5.65386 6.04289 6.04439C5.65237 6.43491 5.65237 7.06808 6.04289 7.4586L10.5845 12.0002L6.04289 16.5418Z"
                        fill="" />
                </svg>
            </button>

            <div class="modal-content custom-scrollbar flex flex-col overflow-y-auto px-2">
                <div class="modal-header">
                    <div id="rejectFormHeader" class="hidden">
                        <h5 class="modal-title mb-2 text-theme-xl font-semibold text-gray-800 dark:text-white/90 lg:text-2xl"
                            id="eventModalLabel">
                            Tolak Pengajuan Pinjaman
                        </h5>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Berikan Alasan kenapa pengajuan ini di tolak
                        </p>
                    </div>
                    <div id="pengajuanFormHeader"class="hidden">
                        <h5 class="modal-title mb-2 text-theme-xl font-semibold text-gray-800 dark:text-white/90 lg:text-2xl"
                            id="eventModalLabel">
                            Ajukan Pinjaman
                        </h5>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Pengajuan Pinjaman akan diverifikasi oleh admin dan ketua koperasi untuk menentukan
                            pengajuan
                            anda diterima atau tidak, lalu admin akan segera memproses jika pengajuan anda di terima
                        </p>
                    </div>
                </div>

                {{-- <!-- Reject Form --> --}}
                <div id="rejectForm" class="hidden h-[16rem]">
                    <form method="POST" action="{{ route('reject-pengajuan-pinjaman') }}">
                        @csrf

                        <input type="hidden" name="id" id="rejectFormId">
                        <!-- This will be updated dynamically -->
                        <div class="modal-body mt-8">
                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Alasan Penolakan
                            </label>
                            <select id="alasanSelect" name="alasan" placeholder="Pilih alasan"
                                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-red-300 focus:outline-none focus:ring focus:ring-red-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-red-800">
                                <option value="">Pilih alasan</option>
                                <option
                                    value="Mohon maaf, dokumen yang Anda lampirkan belum lengkap. Silakan lengkapi terlebih dahulu untuk dapat diproses lebih lanjut.">
                                    Mohon maaf, dokumen yang Anda lampirkan belum lengkap. Silakan lengkapi terlebih
                                    dahulu untuk dapat diproses lebih lanjut.</option>
                                <option
                                    value="Pengajuan pinjaman hanya dapat dilakukan setelah memenuhi masa keanggotaan minimum. Saat ini Anda belum memenuhi syarat tersebut.">
                                    Pengajuan pinjaman hanya dapat dilakukan setelah memenuhi masa keanggotaan minimum.
                                    Saat ini Anda belum memenuhi syarat tersebut.</option>
                                <option
                                    value="Kami menemukan adanya keterlambatan atau tunggakan dari pinjaman sebelumnya. Silakan selesaikan kewajiban tersebut terlebih dahulu.">
                                    Kami menemukan adanya keterlambatan atau tunggakan dari pinjaman sebelumnya. Silakan
                                    selesaikan kewajiban tersebut terlebih dahulu.</option>
                                <option
                                    value="Nominal pinjaman yang diajukan melebihi batas yang diperbolehkan berdasarkan ketentuan koperasi.">
                                    Nominal pinjaman yang diajukan melebihi batas yang diperbolehkan berdasarkan
                                    ketentuan koperasi.</option>
                                <option
                                    value="Setelah kami tinjau, kemampuan finansial Anda saat ini belum mencukupi untuk memenuhi kewajiban cicilan bulanan.">
                                    Setelah kami tinjau, kemampuan finansial Anda saat ini belum mencukupi untuk
                                    memenuhi kewajiban cicilan bulanan.</option>
                                <option
                                    value="Anda masih memiliki pinjaman aktif yang belum lunas. Pengajuan baru hanya dapat dilakukan setelah pinjaman sebelumnya diselesaikan.">
                                    Anda masih memiliki pinjaman aktif yang belum lunas. Pengajuan baru hanya dapat
                                    dilakukan setelah pinjaman sebelumnya diselesaikan.</option>
                                <option
                                    value="Jaminan yang Anda sertakan belum sesuai atau tidak memenuhi nilai yang disyaratkan.">
                                    Jaminan yang Anda sertakan belum sesuai atau tidak memenuhi nilai yang disyaratkan.
                                </option>
                                <option
                                    value="Tujuan penggunaan dana tidak sesuai dengan ketentuan atau belum dijelaskan secara rinci.">
                                    Tujuan penggunaan dana tidak sesuai dengan ketentuan atau belum dijelaskan secara
                                    rinci.</option>
                                <option
                                    value="Terdapat ketidaksesuaian atau keraguan atas keabsahan dokumen yang dilampirkan.">
                                    Terdapat ketidaksesuaian atau keraguan atas keabsahan dokumen yang dilampirkan.
                                </option>
                                <option
                                    value="Berdasarkan hasil evaluasi dan pertimbangan internal, kami belum dapat menyetujui pengajuan pinjaman Anda saat ini.">
                                    Berdasarkan hasil evaluasi dan pertimbangan internal, kami belum dapat menyetujui
                                    pengajuan pinjaman Anda saat ini.</option>
                            </select>
                        </div>
                        <div class="modal-footer mt-24 flex items-center gap-3 sm:justify-end">
                            <button type="button" onclick="closeModal()"
                                class="btn modal-close-btn bg-danger-subtle text-danger flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] sm:w-auto">
                                Close
                            </button>
                            <button type="submit"
                                class="btn btn-danger btn-add-event flex w-full justify-center rounded-lg bg-red-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-red-600 sm:w-auto">
                                Tolak
                            </button>
                        </div>
                    </form>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            new TomSelect('#alasanSelect', {
                                create: false,
                                sortField: {
                                    field: "text",
                                    direction: "asc"
                                }
                            });
                        });
                    </script>
                </div>

                {{-- Loan Application --}}
                <div id="pengajuanForm">
                    <form method="POST" action="{{ route('pengajuan-pinjaman') }}">
                        @csrf
                        <div class="modal-body mt-8 space-y-6">
                            <!-- Row: Loan Amount & Interest Rate -->
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <!-- Loan Amount -->
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Jumlah Pinjaman
                                    </label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-0 top-1/2 inline-flex h-11 -translate-y-1/2 items-center justify-center border-r border-gray-200 py-3 pl-3.5 pr-3 text-gray-500 dark:border-gray-800 dark:text-gray-400">
                                            Rp
                                        </span>
                                        <input type="text" name="jumlah_pinjaman" id="jumlah_pinjaman"
                                            placeholder="1000000"
                                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pl-[90px] text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                                        @error('jumlah_pinjaman')
                                            <small class="text-theme-xs text-error-500">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Interest Rate -->
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Bunga
                                    </label>
                                    <input type="text" name="bunga" placeholder="1%" disabled
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                                </div>
                            </div>

                            <!-- Monthly Installment -->
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Angsuran Perbulan
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-0 top-1/2 inline-flex h-11 -translate-y-1/2 items-center justify-center border-r border-gray-200 py-3 pl-3.5 pr-3 text-gray-500 dark:border-gray-800 dark:text-gray-400">
                                        Rp
                                    </span>
                                    <input type="text" name="angsuran" id="angsuran" placeholder="1000000" readonly
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pl-[90px] text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                                    @error('angsuran')
                                        <small class="text-theme-xs text-error-500">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- Total Loan -->
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Total Pengajuan
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-0 top-1/2 inline-flex h-11 -translate-y-1/2 items-center justify-center border-r border-gray-200 py-3 pl-3.5 pr-3 text-gray-500 dark:border-gray-800 dark:text-gray-400">
                                        Rp
                                    </span>
                                    <input type="text" name="total_pengajuan" id="total_pengajuan"
                                        placeholder="1000000" readonly
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pl-[90px] text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                                    @error('total_pengajuan')
                                        <small class="text-theme-xs text-error-500">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="modal-footer mt-6 flex items-center gap-3 sm:justify-end">
                            <button type="button" onclick="closeModal()"
                                class="btn modal-close-btn bg-danger-subtle text-danger flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] sm:w-auto"
                                data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit"
                                class="btn btn-primary btn-add-event flex w-full justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 sm:w-auto">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function loanCalculation() {
            const loanInput = document.getElementById("jumlah_pinjaman");
            const angsuranInput = document.getElementById("angsuran");
            const totalInput = document.getElementById("total_pengajuan");

            const pinjaman = parseFloat(loanInput.value.replace(/,/g, ""));
            const bunga = parseFloat(1) / 100;

            if (!isNaN(pinjaman) && !isNaN(bunga)) {
                // const total = pinjaman + (pinjaman * bunga);
                const perBulan = pinjaman * bunga
                const angsuran = pinjaman / 10 + perBulan;
                const total = angsuran * 10;

                angsuranInput.value = Math.round(angsuran);
                totalInput.value = Math.round(total);
            } else {
                angsuranInput.value = '';
                totalInput.value = '';
            }
        }

        // Optional: run calculation on page load too
        document.addEventListener("DOMContentLoaded", () => {
            document.getElementById("jumlah_pinjaman").addEventListener("input", loanCalculation);
        });
    </script>


    <div class="mx-auto max-w-screen-2xl p-4 md:p-6">
        <!-- Breadcrumb Start -->
        <div x-data="{ pageName: `Basic Tables` }">
            <include src="./partials/breadcrumb.html" />
        </div>
        <!-- Breadcrumb End -->

        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <div class="grid grid-cols-7">
                        <h3 class="col-span-6 text-base font-medium text-gray-800 dark:text-white/90">
                            Daftar Pengajuan Pinjaman
                        </h3>

                        @if (auth()->check() && auth()->user()->hasRole('anggota'))
                            <button onclick="openModal()"
                                class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-3 text-center text-sm font-medium text-gray-700 shadow-theme-xs ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">
                                Ajukan Pinjaman
                            </button>
                        @endif
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
                                                    Total Pinjaman
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
                                                    Status persetujuan Ketua
                                                </p>
                                            </div>
                                        </th>

                                        <th class="px-5 py-3 sm:px-6">
                                            <div class="flex items-center">
                                                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                                                    Status persetujuan Admin
                                                </p>
                                            </div>
                                        </th>

                                        @if ((auth()->check() && auth()->user()->hasRole('admin')) || (auth()->check() && auth()->user()->hasRole('ketua')))
                                            <th class="px-5 py-3 sm:px-6">
                                                <div class="flex items-center">
                                                    <p
                                                        class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                                                        Hasil Evaluasi
                                                    </p>
                                                </div>
                                            </th>
                                        @endif

                                        @if ((auth()->check() && auth()->user()->hasRole('admin')) || (auth()->check() && auth()->user()->hasRole('ketua')))
                                            <th class="px-5 py-3 sm:px-6">
                                                <div class="flex items-center">
                                                    <p
                                                        class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                                                        Action
                                                    </p>
                                                </div>
                                            </th>
                                        @endif
                                    </tr>
                                </thead>

                                <!-- table header end -->
                                <!-- table body start -->
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    @foreach ($result as $pinjaman)
                                        <tr>
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

                                                        @if ($pinjaman->status_persetujuan_ketua == 'ditolak')
                                                            <div x-data="{ popover: false }"
                                                                class="relative inline-block">
                                                                <p @click.prevent="popover = !popover"
                                                                    class="inline-flex cursor-pointer items-center gap-2 rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-600 dark:bg-red-900/20 dark:text-red-500">
                                                                    Ditolak
                                                                    <span
                                                                        class="h-2 w-2 rounded-full bg-red-500"></span>
                                                                </p>

                                                                <!-- Popover -->
                                                                <div x-show="popover" @click.outside="popover = false"
                                                                    x-transition
                                                                    class="absolute left-0 z-50 mt-2 w-64 rounded-lg border border-gray-300 bg-white p-4 text-sm text-gray-700 shadow-lg dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                                                                    {{ $pinjaman->alasan_penolakan_ketua }}
                                                                </div>
                                                            </div>
                                                        @elseif($pinjaman->status_persetujuan_ketua == 'menunggu')
                                                            <p
                                                                class="inline-flex items-center gap-2 rounded-full bg-yellow-100 px-3 py-1 text-sm text-sm font-medium text-yellow-600 dark:bg-yellow-900/20 dark:text-yellow-500">
                                                                Menunggu
                                                                <span
                                                                    class="h-2 w-2 rounded-full bg-yellow-500"></span>
                                                            </p>
                                                        @else
                                                            <p
                                                                class="inline-flex items-center gap-2 rounded-full bg-green-100 px-3 py-1 text-sm text-sm font-medium text-green-600 dark:bg-green-900/20 dark:text-green-500">
                                                                Disetujui
                                                                <span class="h-2 w-2 rounded-full bg-green-500"></span>
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <div class="flex items-center">

                                                        @if ($pinjaman->status_persetujuan_admin == 'ditolak')
                                                            <div x-data="{ popover: false }"
                                                                class="relative inline-block">
                                                                <p @click.prevent="popover = !popover"
                                                                    class="inline-flex cursor-pointer items-center gap-2 rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-600 dark:bg-red-900/20 dark:text-red-500">
                                                                    Ditolak
                                                                    <span
                                                                        class="h-2 w-2 rounded-full bg-red-500"></span>
                                                                </p>

                                                                <!-- Popover -->
                                                                <div x-show="popover" @click.outside="popover = false"
                                                                    x-transition
                                                                    class="absolute left-0 z-50 mt-2 w-64 rounded-lg border border-gray-300 bg-white p-4 text-sm text-gray-700 shadow-lg dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                                                                    {{ $pinjaman->alasan_penolakan_admin }}
                                                                </div>
                                                            </div>
                                                        @elseif($pinjaman->status_persetujuan_admin == 'menunggu')
                                                            <p
                                                                class="inline-flex items-center gap-2 rounded-full bg-yellow-100 px-3 py-1 text-sm text-sm font-medium text-yellow-600 dark:bg-yellow-900/20 dark:text-yellow-500">
                                                                Menunggu
                                                                <span
                                                                    class="h-2 w-2 rounded-full bg-yellow-500"></span>
                                                            </p>
                                                        @else
                                                            <p
                                                                class="inline-flex items-center gap-2 rounded-full bg-green-100 px-3 py-1 text-sm text-sm font-medium text-green-600 dark:bg-green-900/20 dark:text-green-500">
                                                                Disetujui
                                                                <span class="h-2 w-2 rounded-full bg-green-500"></span>
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            @if ((auth()->check() && auth()->user()->hasRole('admin')) || (auth()->check() && auth()->user()->hasRole('ketua')))
                                                <td class="px-5 py-4 sm:px-6">
                                                    <div class="flex items-center">
                                                        <div class="flex items-center">
                                                            @if ($pinjaman->eligible)
                                                                <p
                                                                    class="inline-flex items-center gap-2 rounded-full bg-green-100 px-3 py-1 text-sm text-sm font-medium text-green-600 dark:bg-green-900/20 dark:text-green-500">
                                                                    Acc
                                                                    <span
                                                                        class="h-2 w-2 rounded-full bg-green-500"></span>
                                                                </p>
                                                            @else
                                                                <p
                                                                    class="inline-flex items-center gap-2 rounded-full bg-red-100 px-3 py-1 text-sm text-sm font-medium text-red-600 dark:bg-red-900/20 dark:text-red-500">
                                                                    Ditolak
                                                                    <span
                                                                        class="h-2 w-2 rounded-full bg-red-500"></span>
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif

                                            @if ((auth()->check() && auth()->user()->hasRole('admin')) || (auth()->check() && auth()->user()->hasRole('ketua')))
                                                @if (
                                                    (auth()->check() && auth()->user()->hasRole('admin') && $pinjaman->status_persetujuan_admin == 'menunggu') ||
                                                        (auth()->check() && auth()->user()->hasRole('ketua') && $pinjaman->status_persetujuan_ketua == 'menunggu'))
                                                    <td class="px-5 py-4 sm:px-6">
                                                        <div class="flex items-center">
                                                            <div class="flex items-center">

                                                                <button
                                                                    onclick="openModal('reject', {{ $pinjaman->id }})"
                                                                    class="mx-2 inline-flex items-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">
                                                                    Tolak
                                                                </button>

                                                                <a href="/approve-pengajuan/{{ $pinjaman->id }}"
                                                                    class="mx-2 inline-flex items-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">
                                                                    Setujui
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                @else
                                                    <td
                                                        class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400 sm:px-6">
                                                        Telah di verifikasi
                                                    </td>
                                                @endif
                                            @endif
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
        function openModal(type, id = null) {
            document.getElementById("eventModal").style.display = "flex";

            const pengajuanForm = document.getElementById("pengajuanForm");
            const rejectForm = document.getElementById("rejectForm");
            const pengajuanHeader = document.getElementById("pengajuanForm"); // This is reused for header and form
            const rejectHeader = document.getElementById("rejectFormHeader");

            // Hide all sections first
            pengajuanForm.classList.add("hidden");
            rejectForm.classList.add("hidden");
            rejectHeader.classList.add("hidden");
            pengajuanHeader.classList.add("hidden");

            if (type === "reject") {
                rejectForm.classList.remove("hidden");
                rejectHeader.classList.remove("hidden");

                if (id) {
                    document.getElementById("rejectFormId").value = id;
                }
            } else {
                pengajuanForm.classList.remove("hidden");
                pengajuanFormHeader.classList.remove("hidden");
            }
        }



        const closeModal = () => {
            document.getElementById("eventModal").style.display = "none";
        };
    </script>

</x-app-layout>
