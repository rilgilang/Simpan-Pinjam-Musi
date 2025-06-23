<div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="mb-6 flex justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Activities
            </h3>
        </div>
        <div x-data="{ openDropDown: false }" class="relative h-fit">
            <button @click="openDropDown = !openDropDown"
                :class="openDropDown ? 'text-gray-700 dark:text-white' :
                    'text-gray-400 hover:text-gray-700 dark:hover:text-white'"
                class="text-gray-400 hover:text-gray-700 dark:hover:text-white">
                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M10.2441 6C10.2441 5.0335 11.0276 4.25 11.9941 4.25H12.0041C12.9706 4.25 13.7541 5.0335 13.7541 6C13.7541 6.9665 12.9706 7.75 12.0041 7.75H11.9941C11.0276 7.75 10.2441 6.9665 10.2441 6ZM10.2441 18C10.2441 17.0335 11.0276 16.25 11.9941 16.25H12.0041C12.9706 16.25 13.7541 17.0335 13.7541 18C13.7541 18.9665 12.9706 19.75 12.0041 19.75H11.9941C11.0276 19.75 10.2441 18.9665 10.2441 18ZM11.9941 10.25C11.0276 10.25 10.2441 11.0335 10.2441 12C10.2441 12.9665 11.0276 13.75 11.9941 13.75H12.0041C12.9706 13.75 13.7541 12.9665 13.7541 12C13.7541 11.0335 12.9706 10.25 12.0041 10.25H11.9941Z"
                        fill=""></path>
                </svg>
            </button>
            <div x-show="openDropDown" @click.outside="openDropDown = false"
                class="absolute right-0 top-full z-40 w-40 space-y-1 rounded-2xl border border-gray-200 bg-white p-2 shadow-theme-lg dark:border-gray-800 dark:bg-gray-dark"
                style="display: none;">
                <button
                    class="flex w-full rounded-lg px-3 py-2 text-left text-theme-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                    View More
                </button>
                <button
                    class="flex w-full rounded-lg px-3 py-2 text-left text-theme-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                    Delete
                </button>
            </div>
        </div>
    </div>
    <div class="relative">
        <!-- Timeline line -->
        <div class="absolute bottom-10 left-5 top-6 w-px bg-gray-200 dark:bg-gray-800"></div>

        @foreach ($angsuranList as $angsuran)
            <div class="relative mb-6 flex">
                <div class="z-10 flex-shrink-0">
                    @if ($angsuran->status == 'dibayar')
                        <div
                            class="flex size-10 items-center justify-center rounded-full bg-green-100 ring-4 ring-white dark:ring-gray-800">
                            <svg class="h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    @else
                        <div
                            class="flex size-10 items-center justify-center rounded-full bg-red-100 ring-4 ring-white dark:ring-gray-800">
                            <svg class="h-5 w-5 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="ml-4">
                    <div class="flex items-baseline">
                        <h3 class="text-theme-sm font-semibold text-gray-800 dark:text-white/90">
                            Angsuran ke {{ $angsuran->pembayaran_ke }}
                        </h3>
                        <span class="ml-2 text-theme-sm text-gray-500 dark:text-gray-400">created invoice</span>
                    </div>
                    <p class="text-theme-sm font-normal text-gray-500 dark:text-gray-400">
                        {{ $angsuran->status }}
                    </p>
                    {{-- <p class="mt-1 text-theme-xs text-gray-400">5 months ago</p> --}}
                </div>
            </div>
        @endforeach
    </div>
</div>
