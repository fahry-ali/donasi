<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - Donasi Panti Bumi Damai')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #10b981;
            --primary-dark: #059669;
        }
        
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        body {
            background: #f1f5f9;
        }
        
        .navbar-user {
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: #1f2937 !important;
        }
        
        .navbar-brand span {
            color: var(--primary);
        }
        
        .nav-link {
            color: #6b7280 !important;
            font-weight: 500;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary) !important;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .stat-card .icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            font-weight: 600;
            padding: 1rem 1.5rem;
        }
        
        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        
        .badge {
            padding: 0.4rem 0.75rem;
            font-weight: 500;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            .stat-card {
                padding: 1rem;
            }
            .stat-card .icon {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
            .stat-card .fs-4 {
                font-size: 1.25rem !important;
            }
            .card-header {
                padding: 0.75rem 1rem;
            }
            .card-body {
                padding: 1rem;
            }
            h4 {
                font-size: 1.25rem;
            }
            .table-responsive {
                font-size: 0.875rem;
            }
        }
        
        @media (max-width: 576px) {
            main.py-4 {
                padding-top: 1rem !important;
                padding-bottom: 1rem !important;
            }
            .btn {
                font-size: 0.875rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-user sticky-top">
        <div class="container">
            <a href="{{ route('home') }}" class="navbar-brand">
                <i class="bi bi-heart-pulse-fill text-primary me-1"></i><span>Bumi</span> Damai
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-grid-1x2 me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.usulan.index') }}" class="nav-link {{ request()->routeIs('user.usulan.*') ? 'active' : '' }}">
                            <i class="bi bi-chat-left-text me-1"></i>Usulan Saya
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('programs.index') }}" class="nav-link">
                            <i class="bi bi-heart me-1"></i>Donasi
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->nama }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a href="{{ route('profile.edit') }}" class="dropdown-item"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-left me-2"></i>Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
