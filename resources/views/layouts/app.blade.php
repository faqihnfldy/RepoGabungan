<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedFast</title>
    <!-- CSS dan JS untuk Bootstrap dan Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    @stack('styles') <!-- Untuk styling tambahan jika ada -->
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <i class="fas fa-hospital-user me-2"></i>
                MedFast
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i> Register
                            </a>
                        </li>
                    @else
                        @if(Auth::user()->role === 'doctor')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('doctor.schedule') }}">
                                    <i class="fas fa-calendar-alt me-1"></i> Jadwal Praktik
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('appointments.index') }}">
                                    <i class="fas fa-calendar-check me-1"></i> Janji Temu
                                </a>
                            </li>
                        @endif
                        @if(Auth::user()->role === 'user')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('appointments.history') }}">
                                    <i class="fas fa-history me-1"></i> Riwayat Janji Temu
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
                            </a>
                        </li>
                        <!-- Tombol Logout -->
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link" style="cursor: pointer;">
                                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                                </button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content') <!-- Tempat untuk konten halaman lainnya -->
    </div>

    <!-- Script untuk Bootstrap dan Font Awesome -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts') <!-- Untuk script tambahan jika ada -->
</body>
</html>
