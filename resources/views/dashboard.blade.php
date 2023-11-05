@extends('layouts.app')

@section('content')
    <x-success></x-success>
    <div class="row">
        <div class="col-md-3 mt-md-0 mt-4">
            <a href="{{ route('product.index') }}">
                <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-warning shadow text-center border-radius-lg">
                            <i class="fas fa-shopping-cart opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="text-center mb-0">Products</h6>
                        <span class="text-xs">Total New Added</span>
                        <hr class="horizontal dark my-3">
                        <h5 class="mb-0">{{ $productCount }}</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 mt-md-0 mt-4">
            <a href="{{ route('returned-product.index') }}">
                <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-warning shadow text-center border-radius-lg">
                            <i class="fas fa-truck opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="text-center mb-0">Returned Products</h6>
                        <span class="text-xs">This Month</span>
                        <hr class="horizontal dark my-3">
                        <h5 class="mb-0">{{ $return }}</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 mt-md-0 mt-4">
            <a href="{{ route('damaged-product.index') }}">
                <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-warning shadow text-center border-radius-lg">
                            <i class="fas fa-thumbs-down opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="text-center mb-0">Damaged Products</h6>
                        <span class="text-xs">This Month</span>
                        <hr class="horizontal dark my-3">
                        <h5 class="mb-0">{{ $damage }}</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 mt-md-0 mt-4">
            <a href="{{ route('stock-product.index') }}">
                <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-warning shadow text-center border-radius-lg">
                            <i class="fas fa-cubes opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="text-center mb-0">Out Of Stock Products</h6>
                        <span class="text-xs">This Month</span>
                        <hr class="horizontal dark my-3">
                        <h5 class="mb-0">{{ $out_stock_product }}</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card z-index-2">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Net Income</h6>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-end">
                                        <div class="d-flex align-items-center">
                                            <div class="dropdown me-2">
                                                <button class="btn btn-sm bg-gradient-success dropdown-toggle"
                                                    type="button" id="dateRangeDropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    Date Range
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dateRangeDropdown">
                                                    <form class="px-4 py-3">
                                                        <div class="form-group">
                                                            <label for="fromDate">From Date</label>
                                                            <input type="date" class="form-control" id="fromDate"
                                                                required placeholder="From Date">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="toDate">To Date</label>
                                                            <input type="date" class="form-control" id="toDate"
                                                                required placeholder="To Date">
                                                        </div>
                                                        <button type="button" class="btn btn-primary"
                                                            id="applyDateRange">Apply</button>
                                                    </form>
                                                </ul>
                                            </div>
                                            <button type="button" class="btn btn-sm bg-gradient-primary me-2"
                                                data-filter="thisWeek">This Week</button>
                                            <button type="button" class="btn btn-sm bg-gradient-secondary"
                                                data-filter="thisYear" data-default="true">This Year</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="chart">
                                <canvas id="salesChart" class="chart-canvas" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('dashboard')
    <script>
        window.onload = function() {
            var ctx = document.getElementById("salesChart").getContext("2d");
            var chart;
            var defaultFilter = "thisYear";

            // Initialize the chart with default data
            var gradient = ctx.createLinearGradient(0, 230, 0, 50);
            gradient.addColorStop(1, 'rgba(203,12,159,0.2)');
            gradient.addColorStop(0.2, 'rgba(72,72,176,0.0)');
            gradient.addColorStop(0, 'rgba(203,12,159,0)'); // End color

            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Sales Data',
                        data: [],
                        tension: 0,
                        borderWidth: 0,
                        pointRadius: 0,
                        borderColor: "#cb0c9f",
                        borderWidth: 3,
                        backgroundColor: gradient,
                        fill: true,
                        maxBarThickness: 6
                    }]
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
                }
            });

            function loadData(dateFilter) {
                $.get('/chart-data', {
                    dateFilter: dateFilter,
                }, function(data) {
                    chart.data.labels = data.labels;
                    chart.data.datasets[0].data = data.salesData;
                    chart.update();
                });
            }

            var defaultButton = $('button[data-filter="' + defaultFilter + '"]');
            defaultButton.addClass('active');

            loadData(defaultFilter);

            $('#applyDateRange').click(function() {
                var fromDate = $('#fromDate').val();
                var toDate = $('#toDate').val();
                var selectedFilter = 'custom';

                console.log(fromDate, toDate);

                if (fromDate && toDate) {
                    loadData(selectedFilter);
                    $('button').removeClass('active');
                }
            });

            $('button').click(function() {
                var selectedFilter = $(this).data('filter');
                loadData(selectedFilter);

                $('button').removeClass('active');
                $(this).addClass('active');
            });
        }
    </script>
@endpush
