<div
    class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-5 pt-5 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 sm:pt-6">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
            Graph Simpanan Bulan Ini
        </h3>
    </div>

    <div class="custom-scrollbar max-w-full overflow-x-auto">
        <div class="-ml-5 min-w-[650px] pl-2 xl:min-w-full">
            <div id="yearlySaving" class="h-[300px] w-full"></div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const simpanan = @json($result);

        const yearlyLoanOptions = {
            series: [{
                name: "Simpanan Anggota",
                data: simpanan
            }],
            chart: {
                type: 'bar',
                height: 300,
                toolbar: {
                    show: false
                },
                fontFamily: "Outfit, sans-serif",
            },
            colors: ["#465fff"],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "39%",
                    borderRadius: 5,
                    borderRadiusApplication: "end"
                }
            },
            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov",
                    "Dec"
                ],
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 4,
                colors: ["transparent"]
            },
            yaxis: {
                title: false
            },
            legend: {
                show: true,
                position: "top",
                horizontalAlign: "left",
                fontFamily: "Outfit",
                markers: {
                    radius: 99
                }
            },
            grid: {
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return new Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR",
                            minimumFractionDigits: 0
                        }).format(val);
                    }
                }
            }
        };

        const chart = new ApexCharts(document.querySelector("#yearlySaving"), yearlyLoanOptions);
        chart.render();
    });
</script>
