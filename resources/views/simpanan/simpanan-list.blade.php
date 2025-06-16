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
                    <h5 class="modal-title mb-2 text-theme-xl font-semibold text-gray-800 dark:text-white/90 lg:text-2xl"
                        id="eventModalLabel">
                        Tambah Simpanan
                    </h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Tambah Simpanan yang di setor oleh anggota
                    </p>
                </div>

                <form method="POST" action="{{ route('save-simpanan') }}">
                    @csrf
                    <div class="modal-body mt-8">
                        <div>
                            <div x-data="searchableSelect()" class="relative">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Nama Anggota
                                </label>

                                <input x-model="search" @focus="open = true" @click.away="open = false"
                                    @keydown.escape="open = false" placeholder="Cari anggota..."
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />

                                <ul x-show="open"
                                    class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md border border-gray-300 bg-white shadow-lg dark:bg-gray-800">
                                    <template x-for="item in filteredOptions" :key="item.id">
                                        <li @click="selectOption(item)"
                                            class="cursor-pointer px-4 py-2 text-sm hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                            x-text="item.name">
                                        </li>
                                    </template>
                                </ul>

                                <input type="hidden" name="id_anggota" :value="selected?.id">
                                @error('id_anggota')
                                    <small class="text-theme-xs text-error-500">{{ $message }}</small>
                                @enderror
                            </div>

                            <script>
                                function searchableSelect() {
                                    return {
                                        search: '',
                                        open: false,
                                        selected: null,
                                        options: @json($anggota_list), // Pass from controller: array of { id, name }
                                        get filteredOptions() {
                                            return this.options.filter(item =>
                                                item.name.toLowerCase().includes(this.search.toLowerCase())
                                            );
                                        },
                                        selectOption(item) {
                                            this.selected = item;
                                            this.search = item.name;
                                            this.open = false;
                                        },
                                    }
                                }
                            </script>

                            <div class="mt-6">
                                <div>
                                    <div>
                                        <label
                                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                            Simpanan Wajib
                                        </label>
                                        <input id="event-title" type="text" name="simpanan_wajib"
                                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                                        @error('simpanan_wajib')
                                            <small class="text-theme-xs text-error-500">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="mt-6">
                                <div>
                                    <div>
                                        <label
                                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                            Simpanan Pokok
                                        </label>
                                        <input id="event-title" type="text" name="simpanan_pokok"
                                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                                        @error('simpanan_pokok')
                                            <small class="text-theme-xs text-error-500">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <div>
                                    <div>
                                        <label
                                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                            Simpanan Sukarela
                                        </label>
                                        <input id="event-title" type="text" name="simpanan_sukarela"
                                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                                        @error('simpanan_sukarela')
                                            <small class="text-theme-xs text-error-500">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
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
                            Daftar Simpanan
                        </h3>

                        @if (auth()->check() && auth()->user()->hasRole('admin'))
                            <button onclick="openModal()"
                                class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-3 text-center text-sm font-medium text-gray-700 shadow-theme-xs ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">
                                Tambah Simpanan
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
                                                    Simpanan Wajib
                                                </p>
                                            </div>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <div class="flex items-center">
                                                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                                                    Simpanan Pokok
                                                </p>
                                            </div>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <div class="flex items-center">
                                                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                                                    Simpanan Sukarela
                                                </p>
                                            </div>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <div class="flex items-center">
                                                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                                                    Jumlah
                                                </p>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <!-- table header end -->
                                <!-- table body start -->
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    @foreach ($simpanan_list as $simpanan)
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
                                                                {{ $simpanan->name }}
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
                                                        {{ $simpanan->simpanan_wajib }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                                        {{ $simpanan->simpanan_pokok }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                                        {{ $simpanan->simpanan_sukarela }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <div class="flex items-center">
                                                        <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                                            {{ $simpanan->jumlah }}
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
                document.getElementsByName("name")[0].value = data.name;
                document.getElementsByName("simpanan_wajib")[0].value = data.simpanan_wajib;
                document.getElementsByName("simpanan_pokok")[0].value = data.simpanan_pokok;
                document.getElementsByName("simpanan_sukarela")[0].value = data.simpanan_sukarela;
            }
            document.getElementById("eventModal").style.display = "flex";
        }

        const closeModal = () => {
            document.getElementById("eventModal").style.display = "none";
        };
    </script>

</x-app-layout>
