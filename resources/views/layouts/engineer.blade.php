<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Engineer Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* General Layout */
        body {
            background-color: #f4f7fd;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(90deg, #4f46e5, #3b82f6);
        }

        .navbar-brand {
            font-weight: bold;
            letter-spacing: 1px;
            color: #fff !important;
        }

        .nav-link {
            color: #f0f0f0 !important;
            transition: color 0.2s;
        }

        .nav-link:hover {
            color: #ffdd57 !important;
        }

        /* Buttons */
        .btn-primary {
            background-color: #3b82f6;
            border-color: #3b82f6;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
        }

        .btn-success {
            background-color: #10b981;
            border-color: #10b981;
            transition: 0.3s;
        }
        .btn-success:hover {
            background-color: #059669;
            border-color: #059669;
        }

        .btn-warning {
            background-color: #f59e0b;
            border-color: #f59e0b;
            transition: 0.3s;
            color: #fff;
        }
        .btn-warning:hover {
            background-color: #d97706;
            border-color: #d97706;
            color: #fff;
        }

        .btn-danger {
            background-color: #ef4444;
            border-color: #ef4444;
            transition: 0.3s;
            color: #fff;
        }
        .btn-danger:hover {
            background-color: #dc2626;
            border-color: #dc2626;
            color: #fff;
        }

        /* Card */
        .card {
            border-radius: 15px;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        /* Badges */
        .badge-status {
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.4em 0.7em;
            border-radius: 12px;
            text-transform: capitalize;
        }
        .badge-open { background-color: #3b82f6; color: #fff; }
        .badge-in_progress { background-color: #f59e0b; color: #fff; }
        .badge-closed { background-color: #ef4444; color: #fff; }

        .badge-low { background-color: #10b981; color: #fff; }
        .badge-medium { background-color: #facc15; color: #fff; }
        .badge-high { background-color: #ef4444; color: #fff; }

        /* Toast */
        #toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
        }
    </style>
      @livewireStyles
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('engineer.dashboard') }}">Engineer Panel</a>
            <div class="ms-auto d-flex align-items-center">
                <span class="text-white me-3">Hi, {{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-4">
        @yield('content')
    </div>

    <!-- Toast Notifications -->
    <div id="toast-container">
        @if(session('success'))
            <div class="toast align-items-center text-bg-success border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif
    </div>
    @livewireScripts
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-hide toast after 3 seconds
        window.addEventListener('DOMContentLoaded', () => {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(t => {
                setTimeout(() => {
                    t.classList.remove('show');
                }, 3000);
            });
        });
    </script>
</body>
</html>
