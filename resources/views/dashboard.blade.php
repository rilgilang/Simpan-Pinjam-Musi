<x-app-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6">
        <div class="grid grid-cols-12 gap-4 md:gap-6">
            <div class="col-span-12 space-y-6 xl:col-span-7">
                <!-- Metric Group One -->
                <x-dashboard-metrics />
                <!-- Metric Group One -->

                <!-- ====== Chart One Start -->
                <include src="./partials/chart/chart-01.html" />
            </div>
            <div class="col-span-12 xl:col-span-5">
                <!-- ====== Chart Two Start -->
                <x-dashboard-total-transaction-today />
                <!-- ====== Chart Two End -->
            </div>

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
        </div>
    </div>
</x-app-layout>
