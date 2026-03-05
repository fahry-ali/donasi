<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Donasi Panti Bumi Damai')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #10b981;
            --primary-dark: #059669;
            --primary-light: #d1fae5;
            --secondary: #1e40af;
            --accent: #f59e0b;
            --dark: #1f2937;
            --light: #f8fafc;
            --gradient-primary: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --gradient-hero: linear-gradient(135deg, #064e3b 0%, #1e40af 100%);
        }
        
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        body {
            background-color: var(--light);
            color: var(--dark);
        }
        
        /* Navbar Styles */
        .navbar-main {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary) !important;
        }
        
        .navbar-brand i {
            color: var(--accent);
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--dark) !important;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            color: var(--primary) !important;
        }
        
        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            border-radius: 50px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.35);
            background: var(--gradient-primary);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary);
            color: var(--primary);
            border-radius: 50px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }
        
        /* Card Styles */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }
        
        .card-img-top {
            border-radius: 16px 16px 0 0;
            height: 200px;
            object-fit: cover;
        }
        
        /* Progress Bar */
        .progress {
            height: 10px;
            border-radius: 10px;
            background: var(--primary-light);
        }
        
        .progress-bar {
            background: var(--gradient-primary);
            border-radius: 10px;
        }
        
        /* Footer */
        .footer {
            background: var(--dark);
            color: #94a3b8;
            padding: 4rem 0 2rem;
        }
        
        .footer h5 {
            color: white;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .footer a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer a:hover {
            color: var(--primary);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 2rem;
            margin-top: 3rem;
        }
        
        /* Section Styles */
        .section-title {
            font-weight: 800;
            font-size: 2.5rem;
            color: var(--dark);
            margin-bottom: 1rem;
        }
        
        .section-subtitle {
            color: #64748b;
            font-size: 1.1rem;
            margin-bottom: 3rem;
        }
        
        /* Badge Styles */
        .badge-status {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.875rem;
        }
        
        .badge-success {
            background: var(--primary-light);
            color: var(--primary-dark);
        }
        
        .badge-warning {
            background: #fef3c7;
            color: #d97706;
        }
        
        .badge-danger {
            background: #fee2e2;
            color: #dc2626;
        }
        
        /* Form Styles */
        .form-control, .form-select {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
        }
        
        /* Toast & Alert */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
        }
        
        .alert-success {
            background: var(--primary-light);
            color: var(--primary-dark);
        }
        
        .alert-danger {
            background: #fee2e2;
            color: #dc2626;
        }
        
        /* Utilities */
        .text-primary {
            color: var(--primary) !important;
        }
        
        .bg-primary-light {
            background: var(--primary-light);
        }
        
        .rounded-xl {
            border-radius: 16px !important;
        }
        
        /* Tablet Responsive */
        @media (max-width: 991px) {
            .navbar-main {
                padding: 0.75rem 0;
            }
            
            .navbar-collapse {
                background: white;
                padding: 1rem;
                margin-top: 0.5rem;
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            }
            
            .navbar-collapse .d-flex {
                flex-direction: column;
                width: 100%;
                gap: 0.5rem !important;
            }
            
            .navbar-collapse .btn {
                width: 100%;
            }
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .section-title {
                font-size: 1.75rem;
            }
            
            .section-subtitle {
                font-size: 1rem;
                margin-bottom: 2rem;
            }
            
            /* Hero Section */
            .hero-section {
                padding: 3rem 0 !important;
            }
            
            .hero-section .display-4 {
                font-size: 1.75rem !important;
            }
            
            .hero-section .lead {
                font-size: 1rem !important;
            }
            
            .hero-section .d-flex {
                flex-direction: column;
            }
            
            .hero-section .btn-lg {
                width: 100%;
                padding: 0.75rem 1rem;
            }
            
            /* Cards */
            .card {
                margin-bottom: 1rem;
            }
            
            .card-body {
                padding: 1rem;
            }
            
            .card-img-top {
                height: 160px;
            }
            
            /* Statistics */
            .display-4 {
                font-size: 1.5rem !important;
            }
            
            /* Buttons */
            .btn-lg {
                padding: 0.6rem 1.2rem;
                font-size: 1rem;
            }
            
            /* Footer */
            .footer {
                padding: 2rem 0 1rem;
            }
            
            .footer h5 {
                font-size: 1.1rem;
                margin-bottom: 1rem;
            }
            
            .footer-bottom {
                margin-top: 1.5rem;
                padding-top: 1rem;
            }
            
            /* Forms */
            .form-control, .form-select {
                padding: 0.65rem 0.75rem;
            }
            
            /* Tables */
            .table-responsive {
                font-size: 0.875rem;
            }
            
            /* Container */
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            /* Alerts */
            .alert {
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }
        }
        
        /* Small Mobile */
        @media (max-width: 576px) {
            .hero-section .display-4 {
                font-size: 1.5rem !important;
            }
            
            .section-title {
                font-size: 1.5rem;
            }
            
            .card-img-top {
                height: 140px;
            }
            
            .progress {
                height: 8px;
            }
            
            .btn {
                font-size: 0.9rem;
            }
            
            .badge {
                font-size: 0.75rem;
            }
            
            /* Quick amount buttons */
            .d-flex.flex-wrap.gap-2 .btn {
                flex: 1 1 45%;
                font-size: 0.8rem;
                padding: 0.4rem 0.6rem;
            }
            
            /* CTA Section */
            .display-6 {
                font-size: 1.25rem !important;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    @php $__siteSettings = \App\Models\Setting::getSiteSettings(); @endphp
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-main sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                @if($__siteSettings['site_logo'])
                    <img src="{{ asset($__siteSettings['site_logo']) }}" alt="{{ $__siteSettings['site_name'] }}" style="height: 32px;" class="me-2">
                @else
                    <i class="bi bi-heart-pulse-fill me-2"></i>
                @endif
                {{ $__siteSettings['site_name'] }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active text-primary' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('programs.*') ? 'active text-primary' : '' }}" href="{{ route('programs.index') }}">Program Donasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kegiatan.*') ? 'active text-primary' : '' }}" href="{{ route('kegiatan.index') }}">Kegiatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('donasi.track') ? 'active text-primary' : '' }}" href="{{ route('donasi.track') }}">Lacak Donasi</a>
                    </li>
                </ul>
                <div class="d-flex gap-2">
                    @auth
                        @if(auth()->user()->isDonatur())
                            <a href="{{ route('donatur.dashboard') }}" class="btn btn-outline-primary">
                                <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->nama }}
                            </a>
                            <form method="POST" action="{{ route('donatur.logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="bi bi-box-arrow-right"></i>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                                <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->nama }}
                            </a>
                        @endif
                    @else
                        <a href="{{ route('donatur.login') }}" class="btn btn-outline-primary">Masuk</a>
                        <a href="{{ route('register.choice') }}" class="btn btn-primary">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5>
                        @if($__siteSettings['site_logo'])
                            <img src="{{ asset($__siteSettings['site_logo']) }}" alt="{{ $__siteSettings['site_name'] }}" style="height: 28px;" class="me-2">
                        @else
                            <i class="bi bi-heart-pulse-fill me-2 text-primary"></i>
                        @endif
                        Panti Asuhan {{ $__siteSettings['site_name'] }}
                    </h5>
                    <p>Yayasan yang bergerak dalam bidang sosial kemanusiaan untuk membantu anak-anak yatim piatu dan dhuafa mendapatkan kehidupan yang lebih baik.</p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="fs-5"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="fs-5"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="fs-5"><i class="bi bi-youtube"></i></a>
                        <a href="#" class="fs-5"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5>Menu</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="mb-2"><a href="{{ route('programs.index') }}">Program Donasi</a></li>
                        <li class="mb-2"><a href="{{ route('kegiatan.index') }}">Kegiatan</a></li>
                        <li class="mb-2"><a href="{{ route('donasi.track') }}">Lacak Donasi</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 mb-4">
                    <h5>Kontak</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-geo-alt me-2"></i>Jl. Contoh No. 123, Kota</li>
                        <li class="mb-2"><i class="bi bi-telephone me-2"></i>(021) 1234-5678</li>
                        <li class="mb-2"><i class="bi bi-envelope me-2"></i>info@bumidamai.org</li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 mb-4">
                    <h5>Rekening Donasi</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><strong>Bank BCA</strong><br>123-456-7890<br>a.n. Yayasan Bumi Damai</li>
                        <li class="mb-2"><strong>Bank Mandiri</strong><br>098-765-4321<br>a.n. Yayasan Bumi Damai</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Panti Asuhan {{ $__siteSettings['site_name'] }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
    
    @stack('scripts')
</body>
</html>
