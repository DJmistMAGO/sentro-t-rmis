@extends('layouts.app')

@section('content')
    <x-success></x-success>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header mx-4 p-3 text-center">
                    <div class="icon icon-shape icon-lg bg-gradient-warning shadow text-center border-radius-lg">
                        <i class="fas fa-shopping-cart opacity-10" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="card-body pt-0 p-3 text-center">
                    <h6 class="text-center mb-0">Product</h6>
                    <span class="text-xs">Total New Added</span>
                    <hr class="horizontal dark my-3">
                    <h5 class="mb-0">{{ $productCount }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 mt-md-0 mt-4">
            <div class="card">
                <div class="card-header mx-4 p-3 text-center">
                    <div class="icon icon-shape icon-lg bg-gradient-warning shadow text-center border-radius-lg">
                        <i class="fas fa-cubes opacity-10" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="card-body pt-0 p-3 text-center">
                    <h6 class="text-center mb-0">Stock Product</h6>
                    <span class="text-xs">This Month</span>
                    <hr class="horizontal dark my-3">
                    <h5 class="mb-0">{{ $products->count() }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header mx-4 p-3 text-center">
                    <div class="icon icon-shape icon-lg bg-gradient-warning shadow text-center border-radius-lg">
                        <i class="fas fa-truck opacity-10" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="card-body pt-0 p-3 text-center">
                    <h6 class="text-center mb-0">Return Product</h6>
                    <span class="text-xs">This Month</span>
                    <hr class="horizontal dark my-3">
                    <h5 class="mb-0">{{ $return }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 mt-md-0 mt-4">
            <div class="card">
                <div class="card-header mx-4 p-3 text-center">
                    <div class="icon icon-shape icon-lg bg-gradient-warning shadow text-center border-radius-lg">
                        <i class="fas fa-thumbs-down opacity-10" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="card-body pt-0 p-3 text-center">
                    <h6 class="text-center mb-0">Damaged Product</h6>
                    <span class="text-xs">This Month</span>
                    <hr class="horizontal dark my-3">
                    <h5 class="mb-0">{{ $damage }}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card z-index-2">
                <div class="card-header pb-0">
                    <h6>Sales Overview this Year {{ date('Y') }}</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('dashboard')
    <script>
        window.onload = function() {
            var ctx2 = document.getElementById("chart-line").getContext("2d");

            var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

            gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
            gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
            gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

            var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

            gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
            gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
            gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

            var monthCounts = <?php echo json_encode($monthCounts); ?>;

            // set monthCounts for each month, for example onthCounts[01] is for January
            var counts = [];
            counts[0] = monthCounts['01'];
            counts[1] = monthCounts['02'];
            counts[2] = monthCounts['03'];
            counts[3] = monthCounts['04'];
            counts[4] = monthCounts['05'];
            counts[5] = monthCounts['06'];
            counts[6] = monthCounts['07'];
            counts[7] = monthCounts['08'];
            counts[8] = monthCounts['09'];
            counts[9] = monthCounts['10'];
            counts[10] = monthCounts['11'];
            counts[11] = monthCounts['12'];

            var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

            new Chart(ctx2, {
                type: "line",
                data: {
                    labels: months, // Use the months array here
                    datasets: [{
                        label: "Total Purchase",
                        tension: 0,
                        borderWidth: 0,
                        pointRadius: 0,
                        borderColor: "#cb0c9f",
                        borderWidth: 3,
                        backgroundColor: gradientStroke1,
                        fill: true,
                        data: counts, // Use the counts array here
                        maxBarThickness: 6
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                display: true,
                                padding: 10,
                                color: '#b2b9bf',
                                font: {
                                    size: 11,
                                    family: "Open Sans",
                                    style: 'normal',
                                    lineHeight: 1
                                },
                            }
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                display: true,
                                color: '#b2b9bf',
                                padding: 20,
                                font: {
                                    size: 11,
                                    family: "Open Sans",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                    },
                },
            });
        }
    </script>
@endpush
