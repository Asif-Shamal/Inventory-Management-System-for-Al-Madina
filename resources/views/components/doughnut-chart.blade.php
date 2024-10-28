<div class="col-md-4">
    <div class="card">
        <div style="width: 100%; height: 55vh;"> <!-- Adjust the height here -->
            <canvas id="categorySalesChart" style="width: 100%; height: 100%;"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('categorySalesChart').getContext('2d');
            var categorySalesChart = new Chart(ctx, {
                type: 'doughnut', // or 'pie'
                data: {
                    labels: {!! json_encode($categorySales->pluck('category_name')) !!},
                    datasets: [{
                        label: 'Sales by Category',
                        data: {!! json_encode($categorySales->pluck('total_sales')) !!},
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += context.raw;
                                    return label;
                                }
                            }
                        }
                    },
                    aspectRatio: 1, // Maintains a square aspect ratio
                }
            });
        });
    </script>
</div>
