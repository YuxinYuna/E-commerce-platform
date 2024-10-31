<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <!-- Card for Customers -->
    <div class="col-md-4">
        <div class="card dashboard-card bg-light text-dark mb-4">
            <div class="card-body">
                <h5>Customers</h5>
                <h2>36,254</h2>
                <p class="text-success">+5.27% Since last month</p>
            </div>
        </div>
    </div>

    <!-- Card for Orders -->
    <div class="col-md-4">
        <div class="card dashboard-card bg-light text-dark mb-4">
            <div class="card-body">
                <h5>Orders</h5>
                <h2>5,543</h2>
                <p class="text-danger">-1.08% Since last month</p>
            </div>
        </div>
    </div>

    <!-- Card for Revenue -->
    <div class="col-md-4">
        <div class="card dashboard-card bg-light text-dark mb-4">
            <div class="card-body">
                <h5>Revenue</h5>
                <h2>$6,254</h2>
                <p class="text-success">+30.56% Growth</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Chart Placeholder for "Projections vs Actuals" -->
    <div class="col-md-12">
        <div class="card dashboard-card bg-light text-dark mb-4">
            <div class="card-body">
                <h5>Projections vs Actuals</h5>
                <canvas id="projectionsChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sample Chart.js setup for "Projections vs Actuals"
    var ctx = document.getElementById('projectionsChart').getContext('2d');
    var projectionsChart = new Chart(ctx, {
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
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection