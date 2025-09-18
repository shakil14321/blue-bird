@extends('layouts.app')

@section('content')

<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <title>BlueBird Events BD</title>
    </head>


<body>

    <header>
            <title>News Ticker</title>
            <style>
                body {
                    margin: 0;
                    font-family: Arial, sans-serif;
                }

                .news-ticker {
                    width: 100%;
                    background: #3a22a5fb;
                    color: #ffffff;
                    overflow: hidden;
                    white-space: nowrap;
                    box-sizing: border-box;
                    padding: 10px 0;
                    position: relative;
                }

                .news-ticker p {
                    display: inline-block;
                    padding-left: 100%;
                    animation: scroll 20s linear infinite;
                    margin: 0;
                }

                @keyframes scroll {
                    0% {
                        transform: translateX(0%);
                    }

                    100% {
                        transform: translateX(-100%);
                    }
                }
            </style>
            </head>
            <div class="news-ticker">
                <p> Bluebird Event Management System is now live! Organize, manage, and track all your events
                    seamlessly with our easy-to-use platform. Stay updated with the latest happenings and never miss a beat.
                </p>
            </div>
        </header>

    <div class="container-fluid mt-4">

    <!-- Row 1: Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Carts</h5>
                    <p class="card-text">{{ $totalCarts }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Transactions</h5>
                    <p class="card-text">{{ $transactions }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Revenue</h5>
                    <p class="card-text">${{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Popular Items + Recent Transactions -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Most Popular Items</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr><th>#</th><th>Item</th><th>Sold</th></tr>
                        </thead>
                        <tbody>
                            @foreach($popularItems as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->sold }}</td>
                                </tr>
                            @endforeach
                            @if($popularItems->isEmpty())
                                <tr><td colspan="3" class="text-center">No data available</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Recent Transactions</div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse($recentTransactions as $t)
                            <li class="list-group-item">
                                {{ $t->user->name ?? 'Unknown User' }} requested a quotation
                            </li>
                        @empty
                            <li class="list-group-item">No recent transactions</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Weekly Report Chart -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Weekly Active Users</div>
                <div class="card-body">
                    <canvas id="weeklyChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Revenue By Category</div>
                <div class="card-body">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const weeklyChart = new Chart(document.getElementById('weeklyChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($weeklyActiveUsers->keys()) !!},
            datasets: [{
                label: 'Active Users',
                data: {!! json_encode($weeklyActiveUsers->values()) !!},
                borderColor: 'orange',
                backgroundColor: 'rgba(255, 165, 0, 0.2)',
                tension: 0.3
            }]
        }
    });

    const revenueChart = new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($revenueByCategory->keys()) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($revenueByCategory->values()) !!},
                backgroundColor: 'green'
            }]
        }
    });
</script>
</body>

@endsection