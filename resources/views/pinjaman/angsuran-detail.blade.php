<x-app-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6">
        <!-- Breadcrumb Start -->
        <div x-data="{ pageName: `User Detail` }">
            <include src="./partials/breadcrumb.html" />
        </div>
        <!-- Breadcrumb End -->

        <div class="mx-auto max-w-screen-2xl p-4 md:p-6">
            <!-- Breadcrumb Start -->
            <div x-data="{ pageName: `Profile Anggota` }">
                <include src="./partials/breadcrumb.html" />
            </div>
            <!-- Breadcrumb End -->

            <div
                class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
                <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-7">
                    Detail Pinjaman
                </h3>

                <div class="mb-6 rounded-2xl border border-gray-200 p-5 dark:border-gray-800 lg:p-6">
                    <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
                        <div class="flex w-full flex-col items-center gap-6 xl:flex-row">
                            <div
                                class="h-12 w-12 overflow-hidden rounded-full border border-gray-200 dark:border-gray-800">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($pinjaman->user_name) }}"
                                    alt="user" />
                            </div>
                            <div class="order-3 xl:order-2">
                                <h4
                                    class="mb-2 text-center text-lg font-semibold text-gray-800 dark:text-white/90 xl:text-left">
                                    {{ $pinjaman->name }}
                                </h4>
                                <div
                                    class="flex flex-col items-center gap-1 text-center xl:flex-row xl:gap-3 xl:text-left">
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Terdaftar sejak
                                        {{ \Carbon\Carbon::parse($pinjaman->user_joined_at)->translatedFormat('d M Y') }}
                                    </p>

                                </div>
                            </div>
                        </div>

                        {{-- <button @click="isProfileInfoModal = true"
                            class="flex w-full items-center justify-center gap-2 rounded-full border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 lg:inline-flex lg:w-auto">
                            <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M15.0911 2.78206C14.2125 1.90338 12.7878 1.90338 11.9092 2.78206L4.57524 10.116C4.26682 10.4244 4.0547 10.8158 3.96468 11.2426L3.31231 14.3352C3.25997 14.5833 3.33653 14.841 3.51583 15.0203C3.69512 15.1996 3.95286 15.2761 4.20096 15.2238L7.29355 14.5714C7.72031 14.4814 8.11172 14.2693 8.42013 13.9609L15.7541 6.62695C16.6327 5.74827 16.6327 4.32365 15.7541 3.44497L15.0911 2.78206ZM12.9698 3.84272C13.2627 3.54982 13.7376 3.54982 14.0305 3.84272L14.6934 4.50563C14.9863 4.79852 14.9863 5.2734 14.6934 5.56629L14.044 6.21573L12.3204 4.49215L12.9698 3.84272ZM11.2597 5.55281L5.6359 11.1766C5.53309 11.2794 5.46238 11.4099 5.43238 11.5522L5.01758 13.5185L6.98394 13.1037C7.1262 13.0737 7.25666 13.003 7.35947 12.9002L12.9833 7.27639L11.2597 5.55281Z"
                                    fill="" />
                            </svg>
                            Edit
                        </button> --}}
                    </div>
                </div>

                <div class="mb-6 rounded-2xl border border-gray-200 p-5 dark:border-gray-800 lg:p-6">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-6">
                                Informasi Pinjaman
                            </h4>

                            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-7 2xl:gap-x-32">

                                <div>
                                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                        Jumlah
                                    </p>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ $pinjaman->jumlah_pinjaman }}
                                    </p>
                                </div>

                                <div>
                                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                        Bunga Perbulan
                                    </p>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ $pinjaman->bunga_pinjaman_per_bulan }}%
                                    </p>
                                </div>

                                <div>
                                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                        Angsuran Perbulan
                                    </p>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ $pinjaman->angsuran_per_bulan }}
                                    </p>
                                </div>

                                <div>
                                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                        Tanggal Peminjaman
                                    </p>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ \Carbon\Carbon::parse($pinjaman->created_at)->translatedFormat('d M Y') }}
                                    </p>
                                </div>

                                <div>
                                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                        Status
                                    </p>
                                    @if ($pinjaman->status == 'belum lunas')
                                        <p
                                            class="inline-flex items-center gap-2 rounded-full bg-yellow-100 px-3 py-1 text-sm font-medium text-yellow-600 dark:bg-yellow-900/20 dark:text-yellow-500">
                                            Belum Lunas
                                            <span class="h-2 w-2 rounded-full bg-yellow-500"></span>
                                        </p>
                                    @else
                                        <p
                                            class="inline-flex items-center gap-2 rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-600 dark:bg-green-900/20 dark:text-green-500">
                                            Lunas
                                            <span class="h-2 w-2 rounded-full bg-green-500"></span>
                                        </p>
                                    @endif
                                </div>

                                <div>
                                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                        Tanggal Pengajuan
                                    </p>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ \Carbon\Carbon::parse($pinjaman->tanggal_pengajuan)->translatedFormat('d M Y') }}
                                    </p>
                                </div>

                                <div>
                                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                        Total yang belum dibayar
                                    </p>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ $pinjaman->total_bulan_belum_bayar }} bulan
                                        (Rp{{ number_format($pinjaman->total_belum_dibayar, 0, ',', '.') }})
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rounded-2xl border border-gray-200 p-5 dark:border-gray-800 lg:p-6">
                    <h4 class="mb-6 text-lg font-semibold dark:text-white">Daftar Angsuran</h4>

                    <ul class="space-y-4">
                        @foreach ($angsuran as $item)
                            <li
                                class="flex items-center justify-between rounded-xl border border-gray-200 p-4 transition hover:bg-gray-100 dark:border-gray-800 dark:bg-gray-800 dark:hover:bg-gray-900">
                                <div>
                                    <p class="text-sm text-gray-400">Pembayaran ke-{{ $item->pembayaran_ke }}</p>
                                    <p class="font-semibold dark:text-white">
                                        Rp{{ number_format($item->jumlah, 0, ',', '.') }}</p>
                                </div>

                                {{-- Select form to change status --}}
                                <div>
                                    @if ((auth()->check() && auth()->user()->hasRole('ketua')) || (auth()->check() && auth()->user()->hasRole('anggota')))
                                        @if ($item->status === 'dibayar')
                                            <span
                                                class="inline-flex items-center gap-1 rounded-full bg-emerald-600/10 px-3 py-1 text-sm font-medium text-emerald-500">
                                                Sudah Dibayar
                                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 rounded-full bg-yellow-600/10 px-3 py-1 text-sm font-medium text-yellow-400">
                                                Belum Dibayar
                                                <span class="h-2 w-2 rounded-full bg-yellow-400"></span>
                                            </span>
                                        @endif
                                    @else
                                        @php
                                            $status = strtolower($item->status);
                                        @endphp

                                        <form action="{{ route('update-angsuran', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()"
                                                class="{{ in_array($status, ['sudah dibayar', 'dibayar'])
                                                    ? 'bg-emerald-600/10 text-emerald-500'
                                                    : 'bg-yellow-600/10 text-yellow-400' }} inline-flex items-center gap-1 rounded-full bg-opacity-10 px-3 py-1 text-sm font-medium focus:outline-none">

                                                <option value="belum dibayar"
                                                    {{ $status === 'belum dibayar' ? 'selected' : '' }}>
                                                    Belum Dibayar
                                                </option>
                                                <option value="dibayar"
                                                    {{ in_array($status, ['sudah dibayar', 'dibayar']) ? 'selected' : '' }}>
                                                    Sudah Dibayar
                                                </option>
                                            </select>
                                        </form>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>

                </div>


            </div>
        </div>
    </div>
</x-app-layout>
