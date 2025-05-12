<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: #fff;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .btn-lg {
            border-radius: 50px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .chart-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <h2 class="mb-4 text-center fw-bold">Admin Dashboard</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white text-center">
                    <div class="card-body">
                        <i class="fas fa-users fa-3x mb-3"></i>
                        <h4 class="card-title">Jumlah Pengguna</h4>
                        <p class="card-text fs-4">{{ $userCount }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white text-center">
                    <div class="card-body">
                        <i class="fas fa-sign-in-alt fa-3x mb-3"></i>
                        <h4 class="card-title">Login Hari Ini</h4>
                        <p class="card-text fs-4">{{ $todayLogins }} Pengguna Aktif</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-white text-center">
                    <div class="card-body">
                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                        <h4 class="card-title">Kesalahan Login</h4>
                        <p class="card-text fs-4">{{ $failedLogins }} Coba Gagal</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="chart-container mb-4">
            <h4 class="text-center fw-bold">Grafik Aktivitas Pengguna</h4>
            <canvas id="activityChart" width="400" height="200"></canvas>
        </div>

        <div class="d-flex justify-content-center gap-4">
            <a href="{{ route('loginlogs.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-list"></i> Lihat Login Logs
            </a>
            <a href="/user" class="btn btn-secondary btn-lg">
                <i class="fas fa-user"></i> Lihat Data User
            </a>
            <a href="/settings" class="btn btn-info btn-lg">
                <i class="fas fa-cogs"></i> Pengaturan
            </a>
        </div>
    </div>

    <script>
        var ctx = document.getElementById('activityChart').getContext('2d');
        var activityChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($loginActivity['dates']),
                datasets: [{
                    label: 'Aktivitas Login',
                    data: @json($loginActivity['logins']),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            color: '#fff'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#fff'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#fff'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
