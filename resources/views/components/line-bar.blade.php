<div class="col-md-8">
    <div class="card">
        <div style="width: 100%;">
            <canvas id="salesTrendChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('salesTrendChart').getContext('2d');
            var salesTrendChart = new Chart(ctx, {
                type: 'line', // or 'bar'
                data: {
                    labels: {!! json_encode($monthlySales->pluck('month')) !!},
                    datasets: [{
                        label: 'Monthly Sales',
                        data: {!! json_encode($monthlySales->pluck('total_sales')) !!},
                        fill: false,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Sales Amount'
                            }
                        }
                    }
                }
            });
        });
    </script>
</div>
