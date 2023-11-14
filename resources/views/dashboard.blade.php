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
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card z-index-2">
                        <div class="card-header pb-0 d-flex">
                                <div class="col-md-3">
                                    <h6>Range Net Income</h6>
                                </div>
                                <div class="col-md-9 d-flex justify-content-end">
                                        <form action="{{ route('dashboard') }}" method="" class="d-flex">
                                            @csrf
                                        <div class="form-group">
                                            <input type="date" name="from" class="mb-0 form-control" id="">
                                        </div>
                                        <div class="form-group">
                                            <input type="date" name="to" class="mb-0 mx-2 form-control" id="">
                                        </div>
                                        <div class="ms-4 form-group">
                                            <button type="submit" class="btn mb-0 btn-info">Filter</button>
                                        </div>
                                    </form>
                                    </div>
                        </div>
                        <div class="card-body pt-0 p-3">
                            <div class="chart">
                                <canvas id="salesChart1" class="chart-canvas" height="200"></canvas>
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
    document.addEventListener("DOMContentLoaded", function() {
        // Sample data
        var labels = {!! json_encode($dataDatePrep) !!};
        var data = {!! json_encode($dataTotal) !!};

        // Chart configuration
        var ctx = document.getElementById('salesChart1').getContext('2d');
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'RANGE NET INCOME',
                    data: data,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        type: 'category',
                        labels: labels,
                    },
                    y: {
                        beginAtZero: true,
                    }
                },
            }
        });
    });
</script>

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

    function loadData(dateFilter,  fromDate, toDate) {
    $.get('/chart-data', {
        dateFilter: dateFilter,
        fromDate: fromDate,
        toDate: toDate
    }, function(data) {
        chart.data.labels = data.labels;
        chart.data.datasets[0].data = data.salesData;
        chart.update();
    }, 'json');  // Specify the response data type as JSON
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
            loadData(selectedFilter, fromDate, toDate);
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
