@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    .btn-light.btn-sm {
        font-size: 0.875rem;
        padding: 0.25rem 0.5rem;
        color: #5867DD;
        border-color: #E2E6EA;
    }
    .dashboard-card {
        border-radius: 12px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.2s ease-in-out;
    }
    .dashboard-card:hover {
        transform: translateY(-5px);
    }
    .dashboard-stat {
        font-size: 1.5rem;
        font-weight: 700;
        color: #333;
    }
    .chart-container {
        height: 300px;
        position: relative;
        margin: auto;
    }
    .dashboard-card {
    border-radius: 12px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        font-weight: 600;
        font-size: 1.2rem;
    }
    .card-body-count{
        height: 200px;
    }
    .line3{
        height: 500px;
    }

    .list-group-item p {
        margin: 0;
        font-size: 0.85rem;
    }

    .list-inline-item {
        margin: 0 10px 10px 10px;
        display: flex;
        justify-content: space-between;
        align-items: right;
        font-size: 0.875rem;
    }

    .list-group-item strong {
        font-size: 1rem;
        color: #333;
    }
    .text-right p {
        margin: 0;
    }
    .badge {
        font-size: 0.75rem;
        padding: 0.3rem 0.6rem;
    }

    .media-body small {
        color: #666;
    }
    .row {
        /* width: 110%; */
    }

</style>

<div class="row">
    <!-- KPI Cards -->
    <div class="col-md-3">
        <div class="card dashboard-card bg-light text-dark mb-4">
            <div class="card-body card-body-count">
                <h5>Customers</h5>
                <div class="dashboard-stat" id="customerCount">36,254</div>
                <p class="text-success">+5.27%</p>
                <small>Since last month</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card dashboard-card bg-light text-dark mb-4">
            <div class="card-body card-body-count">
                <h5>Orders</h5>
                <div class="dashboard-stat" id="orderCount">5,543</div>
                <p class="text-danger">-1.08% </p>
                <small>Since last month</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card dashboard-card bg-light text-dark mb-4">
            <div class="card-body card-body-count">
                <h5>Revenue</h5>
                <div class="dashboard-stat" id="revenueCount">$6,254</div>
                <p class="text-success">+30.56% </p>
                <small>Since last month</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card dashboard-card bg-light text-dark mb-4">
            <div class="card-body card-body-count">
                <h5>Growth</h5>
                <div class="dashboard-stat" id="growthCount">+41.87%</div>
                <p class="text-success">+7.42% </p>
                <small>Since last month</small>
            </div>
        </div>
    </div>
</div>

<!-- Projections vs Actuals Chart -->
<div class="row">
    <div class="col-md-12">
        <div class="card dashboard-card mb-4">
            <div class="card-body">
                <h5>Projections vs Actuals</h5>
                <div class="chart-container">
                    <canvas id="projectionsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
</div>
<div class="row">
    <!-- Revenue Comparison Chart -->
    <div class="col-md-12">
        <div class="card dashboard-card mb-4">
            <div class="card-body">
                <h5>Revenue</h5>
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row ">
    <div class="col-md-8">
        <div class="card dashboard-card mb-4">
            <div class="card-body line3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title">Top Selling Products</h5>
                    <button class="btn btn-light btn-sm">Export <i class="fas fa-download"></i></button>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>ASOS Ridley High Waist</strong><br>
                            <small>07 April 2018</small>
                        </div>
                        <div class="text-right">
                            <p class="mb-0">$79.49<br><small>Price</small></p>
                        </div>
                        <div class="text-right">
                            <p class="mb-0">82<br><small>Quantity</small></p>
                        </div>
                        <div class="text-right">
                            <p class="mb-0">$6,518.18<br><small>Amount</small></p>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Marco Lightweight Shirt</strong><br>
                            <small>25 March 2018</small>
                        </div>
                        <div class="text-right">
                            <p class="mb-0">$128.50<br><small>Price</small></p>
                        </div>
                        <div class="text-right">
                            <p class="mb-0">37<br><small>Quantity</small></p>
                        </div>
                        <div class="text-right">
                            <p class="mb-0">$4,754.50<br><small>Amount</small></p>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Half Sleeve Shirt</strong><br>
                            <small>17 March 2018</small>
                        </div>
                        <div class="text-right">
                            <p class="mb-0">$39.99<br><small>Price</small></p>
                        </div>
                        <div class="text-right">
                            <p class="mb-0">64<br><small>Quantity</small></p>
                        </div>
                        <div class="text-right">
                            <p class="mb-0">$2,559.36<br><small>Amount</small></p>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Lightweight Jacket</strong><br>
                            <small>12 March 2018</small>
                        </div>
                        <div class="text-right">
                            <p class="mb-0">$20.00<br><small>Price</small></p>
                        </div>
                        <div class="text-right">
                            <p class="mb-0">184<br><small>Quantity</small></p>
                        </div>
                        <div class="text-right">
                            <p class="mb-0">$3,680.00<br><small>Amount</small></p>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Marco Shoes</strong><br>
                            <small>05 March 2018</small>
                        </div>
                        <div class="text-right">
                            <p class="mb-0">$28.49<br><small>Price</small></p>
                        </div>
                        <div class="text-right">
                            <p class="mb-0">69<br><small>Quantity</small></p>
                        </div>
                        <div class="text-right">
                            <p class="mb-0">$1,965.81<br><small>Amount</small></p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>


    <!-- Total Sales Chart -->
    <div class="col-md-4">
        <div class="card dashboard-card mb-4">
            <div class="card-body line3">
                <h5 class="card-title">Total Sales</h5>
                <div class="chart-container" style="height: 250px; width: 100%;">
                    <canvas id="salesChart"></canvas>
                </div>
                <ul class="list-inline text-center mt-3">
                    <li class="list-inline-item">
                        <span class="badge badge-primary">Direct</span> $300.56
                    </li>
                    <li class="list-inline-item">
                        <span class="badge badge-danger">Affiliate</span> $135.18
                    </li>
                    <li class="list-inline-item">
                        <span class="badge badge-success">Sponsored</span> $48.96
                    </li>
                    <li class="list-inline-item">
                        <span class="badge badge-warning">E-mail</span> $154.02
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<!-- CountUp.js for Animations -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.0.7/countUp.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Donut Chart for Total Sales
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Direct', 'Affiliate', 'Sponsored', 'E-mail'],
                datasets: [{
                    data: [300.56, 135.18, 48.96, 154.02],
                    backgroundColor: ['#5867DD', '#FF5B5C', '#4CAF50', '#FFC107'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Hide default legend
                    }
                }
            }
        });
    });
    // Animated Count-Up Effect
    document.addEventListener('DOMContentLoaded', function () {
        const customerCount = new CountUp('customerCount', 36254);
        const orderCount = new CountUp('orderCount', 5543);
        const revenueCount = new CountUp('revenueCount', 6254);
        const growthCount = new CountUp('growthCount', 4.87);

        customerCount.start();
        orderCount.start();
        revenueCount.start();
        growthCount.start();
    });
    // Projections vs Actuals Chart
    var ctxProjections = document.getElementById('projectionsChart').getContext('2d');
    var projectionsChart = new Chart(ctxProjections, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Actual',
                data: [120, 130, 100, 140, 150, 160, 170, 180, 190, 200, 210, 220],
                backgroundColor: 'rgba(88, 103, 221, 0.8)',
            }, {
                label: 'Projected',
                data: [100, 110, 120, 130, 140, 150, 160, 170, 180, 190, 200, 210],
                backgroundColor: 'rgba(88, 103, 221, 0.4)',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Revenue Comparison Chart
    var ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Current Week',
                data: [3000, 4000, 3200, 5000, 4800, 5600, 6000],
                borderColor: 'rgba(0, 123, 255, 1)',
                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                fill: true
            }, {
                label: 'Previous Week',
                data: [2600, 3900, 3000, 4200, 4600, 5300, 5900],
                borderColor: 'rgba(40, 167, 69, 1)',
                backgroundColor: 'rgba(40, 167, 69, 0.2)',
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
