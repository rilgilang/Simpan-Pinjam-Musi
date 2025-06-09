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
                <include src="./partials/chart/chart-02.html" />
                <!-- ====== Chart Two End -->
            </div>

            <div class="col-span-12">
                <!-- ====== Chart Three Start -->
                <include src="./partials/chart/chart-03.html" />
                <!-- ====== Chart Three End -->
            </div>

            <div class="col-span-12 xl:col-span-5">
                <!-- ====== Map One Start -->
                <include src="./partials/map-01.html" />
                <!-- ====== Map One End -->
            </div>

            <div class="col-span-12 xl:col-span-7">
                <!-- ====== Table One Start -->
                <include src="./partials/table/table-01.html" />
                <!-- ====== Table One End -->
            </div>
        </div>
    </div>
</x-app-layout>
