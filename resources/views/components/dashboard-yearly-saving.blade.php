<div
    class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-5 pt-5 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 sm:pt-6">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
            Graph Simpanan Bulan Ini
        </h3>
    </div>

    <div class="custom-scrollbar max-w-full overflow-x-auto">
        <div class="-ml-5 min-w-[650px] pl-2 xl:min-w-full">
            <div id="yearlySaving" class="-ml-5 h-full min-w-[650px] pl-2 xl:min-w-full"></div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const yearlySavingOptions = {
            series: [{
                name: "Sales",
                data: [168, 385, 201, 298, 187, 195, 291, 110, 215, 390, 280, 112],
            }],
            colors: ["#465fff"],
            chart: {
                fontFamily: "Outfit, sans-serif",
                type: "bar",
                height: 180,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "39%",
                    borderRadius: 5,
                    borderRadiusApplication: "end"
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
            legend: {
                show: true,
                position: "top",
                horizontalAlign: "left",
                fontFamily: "Outfit",
                markers: {
                    radius: 99
                }
            },
            yaxis: {
                title: false
            },
            grid: {
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                x: {
                    show: false
                },
                y: {
                    formatter: function(val) {
                        return val;
                    }
                }
            }
        };

        const chart = new ApexCharts(document.querySelector("#yearlySaving"), yearlySavingOptions);
        chart.render();
    });
</script>
