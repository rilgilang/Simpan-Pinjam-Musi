<x-app-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6">
        <div class="grid grid-cols-12 gap-4 md:gap-4">
            @if ((auth()->check() && auth()->user()->hasRole('ketua')) || (auth()->check() && auth()->user()->hasRole('admin')))
                <div class="col-span-6 space-y-6 xl:col-span-7">
                    <!-- Metric Group One -->
                    <x-dashboard-metrics />
                    <!-- Metric Group One -->
                </div>
            @else
                <div class="col-span-6 space-y-6 xl:col-span-12">
                    <!-- Metric Group One -->
                    <x-dashboard-metrics />
                    <!-- Metric Group One -->
                </div>
            @endif


            @if ((auth()->check() && auth()->user()->hasRole('ketua')) || (auth()->check() && auth()->user()->hasRole('admin')))
                <div class="col-span-12 xl:col-span-5">
                    <!-- ====== Chart Two Start -->
                    <x-dashboard-transaction-this-month />
                    <!-- ====== Chart Two End -->
                </div>
            @endif

            @if ((auth()->check() && auth()->user()->hasRole('ketua')) || (auth()->check() && auth()->user()->hasRole('admin')))
                <div class="col-span-6">
                    <!-- ====== Chart Three Start -->
                    <x-dashboard-yearly-loan />
                    <!-- ====== Chart Three En -->
                </div>
                <div class="col-span-6">
                    <!-- ====== Chart Three Start -->
                    <x-dashboard-yearly-saving />
                    <!-- ====== Chart Three En -->
                </div>
            @endif

            @if (auth()->check() && auth()->user()->hasRole('anggota'))
                <div class="col-span-12">
                    <!-- ====== Chart Three Start -->
                    <x-current-loan />
                    <!-- ====== Chart Three En -->
                </div>

                <div class="col-span-12">
                    <!-- ====== Chart Three Start -->
                    <x-current-installment />
                    <!-- ====== Chart Three En -->
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
