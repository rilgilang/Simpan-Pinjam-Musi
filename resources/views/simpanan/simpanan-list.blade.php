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

                        @if (auth()->check() && auth()->user()->role('admin'))
                            <button onclick="openModal()"
                                class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-3 text-center text-sm font-medium text-gray-700 shadow-theme-xs ring-1 ring-inset ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">
                                Tambah Simpanan
                            </button>
                        @endif
                    </div>

                </div>
                <div class="border-t border-gray-100 p-5 dark:border-gray-800 sm:p-6">
                    <!-- DataTable Two -->
                    <div x-data="dataTableTwo()"
                        class="overflow-hidden rounded-xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="mb-4 flex flex-col gap-2 px-4 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-center gap-3">
                                <span class="text-gray-500 dark:text-gray-400"> Show </span>
                                <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                                    <select
                                        class="dark:bg-dark-900 focus:outline-hidden focus:ring-3 h-9 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none py-2 pl-3 pr-8 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
                                        :class="isOptionSelected & amp; & amp;
                                        'text-gray-500 dark:text-gray-400'"
                                        @click="isOptionSelected = true" @change="perPage = $event.target.value">
                                        <option value="10"
                                            class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                                            10
                                        </option>
                                        <option value="8"
                                            class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                                            8
                                        </option>
                                        <option value="5"
                                            class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                                            5
                                        </option>
                                    </select>
                                    <span
                                        class="absolute right-2 top-1/2 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                        <svg class="stroke-current" width="16" height="16" viewBox="0 0 16 16"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3.8335 5.9165L8.00016 10.0832L12.1668 5.9165" stroke=""
                                                stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg>
                                    </span>
                                </div>
                                <span class="text-gray-500 dark:text-gray-400"> entries </span>
                            </div>

                            <div class="relative">
                                <button
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                    <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M3.04199 9.37363C3.04199 5.87693 5.87735 3.04199 9.37533 3.04199C12.8733 3.04199 15.7087 5.87693 15.7087 9.37363C15.7087 12.8703 12.8733 15.7053 9.37533 15.7053C5.87735 15.7053 3.04199 12.8703 3.04199 9.37363ZM9.37533 1.54199C5.04926 1.54199 1.54199 5.04817 1.54199 9.37363C1.54199 13.6991 5.04926 17.2053 9.37533 17.2053C11.2676 17.2053 13.0032 16.5344 14.3572 15.4176L17.1773 18.238C17.4702 18.5309 17.945 18.5309 18.2379 18.238C18.5308 17.9451 18.5309 17.4703 18.238 17.1773L15.4182 14.3573C16.5367 13.0033 17.2087 11.2669 17.2087 9.37363C17.2087 5.04817 13.7014 1.54199 9.37533 1.54199Z"
                                            fill=""></path>
                                    </svg>
                                </button>

                                <input type="text" x-model="search" placeholder="Search..."
                                    class="dark:bg-dark-900 focus:outline-hidden focus:ring-3 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-11 pr-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 xl:w-[300px]">
                            </div>
                        </div>

                        <div class="max-w-full overflow-x-auto">
                            <div class="min-w-[1102px]">
                                <!-- table header start -->
                                <div class="grid grid-cols-12 border-t border-gray-200 dark:border-gray-800">
                                    <div
                                        class="col-span-2 flex items-center border-r border-gray-200 px-4 py-3 dark:border-gray-800">
                                        <div class="flex w-full cursor-pointer items-center justify-between">
                                            <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400">
                                                Nama Anggota
                                            </p>

                                            <span class="flex flex-col gap-0.5">
                                                <svg class="fill-gray-300 dark:fill-gray-700" width="8"
                                                    height="5" viewBox="0 0 8 5" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.40962 0.585167C4.21057 0.300808 3.78943 0.300807 3.59038 0.585166L1.05071 4.21327C0.81874 4.54466 1.05582 5 1.46033 5H6.53967C6.94418 5 7.18126 4.54466 6.94929 4.21327L4.40962 0.585167Z"
                                                        fill=""></path>
                                                </svg>

                                                <svg class="fill-gray-300 dark:fill-gray-700" width="8"
                                                    height="5" viewBox="0 0 8 5" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.40962 4.41483C4.21057 4.69919 3.78943 4.69919 3.59038 4.41483L1.05071 0.786732C0.81874 0.455343 1.05582 0 1.46033 0H6.53967C6.94418 0 7.18126 0.455342 6.94929 0.786731L4.40962 4.41483Z"
                                                        fill=""></path>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                    <div
                                        class="col-span-2 flex items-center border-r border-gray-200 px-4 py-3 dark:border-gray-800">
                                        <div class="flex w-full cursor-pointer items-center justify-between">
                                            <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400">
                                                Simpanan Wajib
                                            </p>

                                            <span class="flex flex-col gap-0.5">
                                                <svg class="fill-gray-300 dark:fill-gray-700" width="8"
                                                    height="5" viewBox="0 0 8 5" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.40962 0.585167C4.21057 0.300808 3.78943 0.300807 3.59038 0.585166L1.05071 4.21327C0.81874 4.54466 1.05582 5 1.46033 5H6.53967C6.94418 5 7.18126 4.54466 6.94929 4.21327L4.40962 0.585167Z"
                                                        fill=""></path>
                                                </svg>

                                                <svg class="fill-gray-300 dark:fill-gray-700" width="8"
                                                    height="5" viewBox="0 0 8 5" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.40962 4.41483C4.21057 4.69919 3.78943 4.69919 3.59038 4.41483L1.05071 0.786732C0.81874 0.455343 1.05582 0 1.46033 0H6.53967C6.94418 0 7.18126 0.455342 6.94929 0.786731L4.40962 4.41483Z"
                                                        fill=""></path>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                    <div
                                        class="col-span-2 flex items-center border-r border-gray-200 px-4 py-3 dark:border-gray-800">
                                        <div class="flex w-full cursor-pointer items-center justify-between">
                                            <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400">
                                                Simpanan Pokok
                                            </p>

                                            <span class="flex flex-col gap-0.5">
                                                <svg class="fill-gray-300 dark:fill-gray-700" width="8"
                                                    height="5" viewBox="0 0 8 5" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.40962 0.585167C4.21057 0.300808 3.78943 0.300807 3.59038 0.585166L1.05071 4.21327C0.81874 4.54466 1.05582 5 1.46033 5H6.53967C6.94418 5 7.18126 4.54466 6.94929 4.21327L4.40962 0.585167Z"
                                                        fill=""></path>
                                                </svg>

                                                <svg class="fill-gray-300 dark:fill-gray-700" width="8"
                                                    height="5" viewBox="0 0 8 5" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.40962 4.41483C4.21057 4.69919 3.78943 4.69919 3.59038 4.41483L1.05071 0.786732C0.81874 0.455343 1.05582 0 1.46033 0H6.53967C6.94418 0 7.18126 0.455342 6.94929 0.786731L4.40962 4.41483Z"
                                                        fill=""></path>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>

                                    <div
                                        class="col-span-2 flex items-center border-r border-gray-200 px-4 py-3 dark:border-gray-800">
                                        <div class="flex w-full cursor-pointer items-center justify-between">
                                            <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400">
                                                Simpanan Sukarela
                                            </p>

                                            <span class="flex flex-col gap-0.5">
                                                <svg class="fill-gray-300 dark:fill-gray-700" width="8"
                                                    height="5" viewBox="0 0 8 5" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.40962 0.585167C4.21057 0.300808 3.78943 0.300807 3.59038 0.585166L1.05071 4.21327C0.81874 4.54466 1.05582 5 1.46033 5H6.53967C6.94418 5 7.18126 4.54466 6.94929 4.21327L4.40962 0.585167Z"
                                                        fill=""></path>
                                                </svg>

                                                <svg class="fill-gray-300 dark:fill-gray-700" width="8"
                                                    height="5" viewBox="0 0 8 5" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.40962 4.41483C4.21057 4.69919 3.78943 4.69919 3.59038 4.41483L1.05071 0.786732C0.81874 0.455343 1.05582 0 1.46033 0H6.53967C6.94418 0 7.18126 0.455342 6.94929 0.786731L4.40962 4.41483Z"
                                                        fill=""></path>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>

                                    <div
                                        class="col-span-2 flex items-center border-r border-gray-200 px-4 py-3 dark:border-gray-800">
                                        <div class="flex w-full cursor-pointer items-center justify-between">
                                            <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400">
                                                Jumlah
                                            </p>

                                            <span class="flex flex-col gap-0.5">
                                                <svg class="fill-gray-300 dark:fill-gray-700" width="8"
                                                    height="5" viewBox="0 0 8 5" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.40962 0.585167C4.21057 0.300808 3.78943 0.300807 3.59038 0.585166L1.05071 4.21327C0.81874 4.54466 1.05582 5 1.46033 5H6.53967C6.94418 5 7.18126 4.54466 6.94929 4.21327L4.40962 0.585167Z"
                                                        fill=""></path>
                                                </svg>

                                                <svg class="fill-gray-300 dark:fill-gray-700" width="8"
                                                    height="5" viewBox="0 0 8 5" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.40962 4.41483C4.21057 4.69919 3.78943 4.69919 3.59038 4.41483L1.05071 0.786732C0.81874 0.455343 1.05582 0 1.46033 0H6.53967C6.94418 0 7.18126 0.455342 6.94929 0.786731L4.40962 4.41483Z"
                                                        fill=""></path>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                    <div
                                        class="col-span-2 flex items-center border-r border-gray-200 px-4 py-3 dark:border-gray-800">
                                        <div class="flex w-full cursor-pointer items-center justify-between">
                                            <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400">
                                                Action
                                            </p>

                                            <span class="flex flex-col gap-0.5">
                                                <svg class="fill-gray-300 dark:fill-gray-700" width="8"
                                                    height="5" viewBox="0 0 8 5" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.40962 0.585167C4.21057 0.300808 3.78943 0.300807 3.59038 0.585166L1.05071 4.21327C0.81874 4.54466 1.05582 5 1.46033 5H6.53967C6.94418 5 7.18126 4.54466 6.94929 4.21327L4.40962 0.585167Z"
                                                        fill=""></path>
                                                </svg>

                                                <svg class="fill-gray-300 dark:fill-gray-700" width="8"
                                                    height="5" viewBox="0 0 8 5" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.40962 4.41483C4.21057 4.69919 3.78943 4.69919 3.59038 4.41483L1.05071 0.786732C0.81874 0.455343 1.05582 0 1.46033 0H6.53967C6.94418 0 7.18126 0.455342 6.94929 0.786731L4.40962 4.41483Z"
                                                        fill=""></path>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- table header end -->

                                <div x-data="dataTable()" x-init="init()" class="w-full">
                                    <!-- Table Body Start -->
                                    <template x-for="person in paginatedData" :key="person.id">
                                        <div class="grid grid-cols-12 border-t border-gray-100 dark:border-gray-800">
                                            <div
                                                class="col-span-2 flex items-center border-r border-gray-100 px-4 py-[17.5px] dark:border-gray-800">
                                                <p class="block text-theme-sm font-medium text-gray-800 dark:text-white/90"
                                                    x-text="person.name"></p>
                                            </div>
                                            <div
                                                class="col-span-2 flex items-center border-r border-gray-100 px-4 py-[17.5px] dark:border-gray-800">
                                                <p class="text-theme-sm text-gray-700 dark:text-gray-400"
                                                    x-text="person.simpanan_wajib"></p>
                                            </div>
                                            <div
                                                class="col-span-2 flex items-center border-r border-gray-100 px-4 py-[17.5px] dark:border-gray-800">
                                                <p class="text-theme-sm text-gray-700 dark:text-gray-400"
                                                    x-text="person.simpanan_pokok"></p>
                                            </div>
                                            <div
                                                class="col-span-2 flex items-center border-r border-gray-100 px-4 py-[17.5px] dark:border-gray-800">
                                                <p class="text-theme-sm text-gray-700 dark:text-gray-400"
                                                    x-text="person.simpanan_sukarela"></p>
                                            </div>

                                            <div
                                                class="col-span-2 flex items-center border-r border-gray-100 px-4 py-[17.5px] dark:border-gray-800">
                                                <p class="text-theme-sm text-gray-700 dark:text-gray-400"
                                                    x-text="person.jumlah"></p>
                                            </div>
                                            <div class="col-span-1 flex items-center px-4 py-[17.5px]">
                                                <div class="flex w-full items-center gap-2">
                                                    <button
                                                        class="text-gray-500 hover:text-error-500 dark:text-gray-400 dark:hover:text-error-500">
                                                        <!-- Trash Icon -->
                                                        <svg class="fill-current" width="21" height="21"
                                                            viewBox="0 0 21 21" fill="none">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="..." />
                                                        </svg>
                                                    </button>
                                                    <button
                                                        class="text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white/90">
                                                        <!-- Edit Icon -->
                                                        <svg class="fill-current" width="21" height="21"
                                                            viewBox="0 0 21 21" fill="none">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="..." />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-span-1 flex items-center px-4 py-[17.5px]">
                                                <div class="flex w-full items-center gap-2">
                                                    <button
                                                        class="text-gray-500 hover:text-error-500 dark:text-gray-400 dark:hover:text-error-500">
                                                        <svg class="fill-current" width="21" height="21"
                                                            viewBox="0 0 21 21" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M7.04142 4.29199C7.04142 3.04935 8.04878 2.04199 9.29142 2.04199H11.7081C12.9507 2.04199 13.9581 3.04935 13.9581 4.29199V4.54199H16.1252H17.166C17.5802 4.54199 17.916 4.87778 17.916 5.29199C17.916 5.70621 17.5802 6.04199 17.166 6.04199H16.8752V8.74687V13.7469V16.7087C16.8752 17.9513 15.8678 18.9587 14.6252 18.9587H6.37516C5.13252 18.9587 4.12516 17.9513 4.12516 16.7087V13.7469V8.74687V6.04199H3.8335C3.41928 6.04199 3.0835 5.70621 3.0835 5.29199C3.0835 4.87778 3.41928 4.54199 3.8335 4.54199H4.87516H7.04142V4.29199ZM15.3752 13.7469V8.74687V6.04199H13.9581H13.2081H7.79142H7.04142H5.62516V8.74687V13.7469V16.7087C5.62516 17.1229 5.96095 17.4587 6.37516 17.4587H14.6252C15.0394 17.4587 15.3752 17.1229 15.3752 16.7087V13.7469ZM8.54142 4.54199H12.4581V4.29199C12.4581 3.87778 12.1223 3.54199 11.7081 3.54199H9.29142C8.87721 3.54199 8.54142 3.87778 8.54142 4.29199V4.54199ZM8.8335 8.50033C9.24771 8.50033 9.5835 8.83611 9.5835 9.25033V14.2503C9.5835 14.6645 9.24771 15.0003 8.8335 15.0003C8.41928 15.0003 8.0835 14.6645 8.0835 14.2503V9.25033C8.0835 8.83611 8.41928 8.50033 8.8335 8.50033ZM12.9168 9.25033C12.9168 8.83611 12.581 8.50033 12.1668 8.50033C11.7526 8.50033 11.4168 8.83611 11.4168 9.25033V14.2503C11.4168 14.6645 11.7526 15.0003 12.1668 15.0003C12.581 15.0003 12.9168 14.6645 12.9168 14.2503V9.25033Z"
                                                                fill=""></path>
                                                        </svg>
                                                    </button>
                                                    <button
                                                        @click="openModal({ 
                                                            name: person.name, 
                                                            simpanan_wajib: person.simpanan_wajib, 
                                                            simpanan_pokok: person.simpanan_pokok, 
                                                            simpanan_sukarela: person.simpanan_sukarela 
                                                        })"
                                                        class="text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white/90">
                                                        <svg class="fill-current" width="21" height="21"
                                                            viewBox="0 0 21 21" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M17.0911 3.53206C16.2124 2.65338 14.7878 2.65338 13.9091 3.53206L5.6074 11.8337C5.29899 12.1421 5.08687 12.5335 4.99684 12.9603L4.26177 16.445C4.20943 16.6931 4.286 16.9508 4.46529 17.1301C4.64458 17.3094 4.90232 17.3859 5.15042 17.3336L8.63507 16.5985C9.06184 16.5085 9.45324 16.2964 9.76165 15.988L18.0633 7.68631C18.942 6.80763 18.942 5.38301 18.0633 4.50433L17.0911 3.53206ZM14.9697 4.59272C15.2626 4.29982 15.7375 4.29982 16.0304 4.59272L17.0027 5.56499C17.2956 5.85788 17.2956 6.33276 17.0027 6.62565L16.1043 7.52402L14.0714 5.49109L14.9697 4.59272ZM13.0107 6.55175L6.66806 12.8944C6.56526 12.9972 6.49455 13.1277 6.46454 13.2699L5.96704 15.6283L8.32547 15.1308C8.46772 15.1008 8.59819 15.0301 8.70099 14.9273L15.0436 8.58468L13.0107 6.55175Z"
                                                                fill=""></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Empty State -->
                                    <div x-show="paginatedData.length === 0" class="p-4 text-center text-gray-400">
                                        No data available.
                                    </div>
                                </div>

                                <!-- Alpine.js Table Logic -->
                                <script>
                                    function dataTable() {
                                        const simpananList = @json($simpanan);

                                        return {
                                            allData: [], // All raw data
                                            currentPage: 1,
                                            pageSize: 10,

                                            init() {
                                                // Fetch or define your data here
                                                this.allData = simpananList;
                                            },

                                            get paginatedData() {
                                                const start = (this.currentPage - 1) * this.pageSize;
                                                return this.allData.slice(start, start + this.pageSize);
                                            }
                                        }
                                    }
                                </script>

                            </div>
                        </div>

                        <!-- Pagination Controls -->
                        <div class="border-t border-gray-100 py-4 pl-[18px] pr-4 dark:border-gray-800">
                            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between">
                                <div class="flex items-center justify-center gap-0.5 pb-4 xl:justify-normal xl:pt-0">
                                    <button
                                        class="mr-2.5 flex items-center justify-center rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-gray-700 shadow-theme-xs hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]"
                                        :disabled="currentPage === 1" disabled="disabled">
                                        Previous
                                    </button>

                                    <button
                                        :class="currentPage === 1 ? 'bg-blue-500/[0.08] text-brand-500' :
                                            'text-gray-700 dark:text-gray-400'"
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-500/[0.08] text-sm font-medium text-brand-500 hover:bg-blue-500/[0.08] hover:text-brand-500 dark:hover:text-brand-500">
                                        1
                                    </button>

                                    <template x-if="currentPage > 3">
                                        <span
                                            class="flex h-10 w-10 items-center justify-center rounded-lg hover:bg-blue-500/[0.08] hover:text-brand-500 dark:hover:text-brand-500">...</span>
                                    </template>

                                    <template x-for="page in pagesAroundCurrent" :key="page">
                                        <button
                                            :class="currentPage === page ? 'bg-blue-500/[0.08] text-brand-500' :
                                                'text-gray-700 dark:text-gray-400'"
                                            class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium hover:bg-blue-500/[0.08] hover:text-brand-500 dark:hover:text-brand-500">
                                            <span x-text="page"></span>
                                        </button>
                                    </template><button
                                        :class="currentPage === page ? 'bg-blue-500/[0.08] text-brand-500' :
                                            'text-gray-700 dark:text-gray-400'"
                                        class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-500/[0.08] hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-500">
                                        <span x-text="page">2</span>
                                    </button>

                                    <template x-if="currentPage < totalPages - 2">
                                        <span
                                            class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-500/[0.08] hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-500">...</span>
                                    </template>

                                    <button
                                        class="ml-2.5 flex items-center justify-center rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-gray-700 shadow-theme-xs hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]"
                                        :disabled="currentPage === totalPages">
                                        Next
                                    </button>
                                </div>

                                <p
                                    class="border-t border-gray-100 pt-3 text-center text-sm font-medium text-gray-500 dark:border-gray-800 dark:text-gray-400 xl:border-t-0 xl:pt-0 xl:text-left">
                                    Showing <span x-text="startEntry">1</span> to
                                    <span x-text="endEntry">10</span> of
                                    <span x-text="totalEntries">30</span> entries
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- DataTable Two -->
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
