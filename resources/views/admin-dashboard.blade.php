<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4 text-center">Admin Dashboard</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="d-flex justify-content-center gap-4">
            <a href="{{ route('loginlogs.index') }}" class="btn btn-primary btn-lg">Lihat Login Logs</a>
            <a href="/user" class="btn btn-secondary btn-lg">Lihat Data User</a>
        </div>
    </div>
</body>
</html>
