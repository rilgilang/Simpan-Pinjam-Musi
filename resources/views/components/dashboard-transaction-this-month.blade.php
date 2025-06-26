<div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="mb-4 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
            Komposisi Dana Bulan Ini
        </h3>
    </div>

    <div id="pieChart" class="h-[315px] w-full"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const simpanan = {{ $simpanan }};
        const pinjaman = {{ $pinjaman }};

        const options = {
            series: [simpanan, pinjaman],
            labels: ["Simpanan", "Pinjaman"],
            chart: {
                type: "pie",
                height: 300,
                fontFamily: "Outfit, sans-serif",
            },
            colors: ["#465FFF", "#F97316"],
            dataLabels: {
                enabled: true,
                formatter: function(val, opts) {
                    const value = opts.w.config.series[opts.seriesIndex];
                    return formatCurrency(value);
                },
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold',
                    colors: ['#1D2939']
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return formatCurrency(val);
                    }
                }
            },
            legend: {
                position: 'bottom',
                fontSize: '14px',
                fontWeight: 500,
                labels: {
                    colors: ['#1D2939']
                },
                markers: {
                    width: 12,
                    height: 12,
                    radius: 12,
                }
            },
            stroke: {
                show: false
            }
        };

        function formatCurrency(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(value);
        }

        const chart = new ApexCharts(document.querySelector("#pieChart"), options);
        chart.render();
    });
</script>
