<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Donasi Panti Bumi Damai')</title>
    
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
            --dark: #1f2937;
            --sidebar-width: 260px;
        }
        
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        body {
            background: #f1f5f9;
            overflow-x: hidden;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #1f2937 0%, #111827 100%);
            z-index: 1050;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            flex-shrink: 0;
        }
        
        .sidebar-brand h4 {
            color: white;
            font-weight: 700;
            margin: 0;
        }
        
        .sidebar-brand span {
            color: var(--primary);
        }
        
        .sidebar-nav {
            padding: 1rem 0;
            overflow-y: auto;
            flex: 1;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Custom scrollbar for sidebar */
        .sidebar-nav::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar-nav::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.05);
        }
        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 3px;
        }
        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .nav-item-header {
            padding: 0.75rem 1.5rem;
            color: #6b7280;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .sidebar-nav .nav-link {
            padding: 0.75rem 1.5rem;
            color: #9ca3af;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s;
            border-left: 3px solid transparent;
            text-decoration: none;
        }
        
        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            background: rgba(255,255,255,0.05);
            color: white;
            border-left-color: var(--primary);
        }
        
        .sidebar-nav .nav-link i {
            font-size: 1.1rem;
        }
        
        /* Sidebar Overlay for Mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
        }
        
        .sidebar-overlay.show {
            display: block;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        
        /* Top Header */
        .top-header {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .top-header .breadcrumb {
            margin: 0;
        }
        
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #374151;
            padding: 0.25rem;
            margin-right: 1rem;
            cursor: pointer;
        }
        
        .page-content {
            padding: 2rem;
        }
        
        /* Cards */
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
        
        .stat-card .value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
        }
        
        .stat-card .label {
            color: #6b7280;
            font-size: 0.875rem;
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
        
        .table th {
            font-weight: 600;
            color: #374151;
            border-bottom-width: 1px;
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
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .menu-toggle {
                display: inline-block;
            }
            .top-header {
                padding: 0.75rem 1rem;
            }
            .page-content {
                padding: 1rem;
            }
            .top-header h5 {
                font-size: 1rem;
            }
            .top-header .breadcrumb {
                font-size: 0.75rem;
            }
            .d-none-mobile {
                display: none !important;
            }
        }
        
        @media (max-width: 576px) {
            .stat-card {
                padding: 1rem;
            }
            .stat-card .value {
                font-size: 1.25rem;
            }
            .stat-card .icon {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
            .table-responsive {
                font-size: 0.875rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h4><i class="bi bi-heart-pulse-fill me-2" style="color: var(--primary);"></i><span>Bumi</span> Damai</h4>
        </div>
        <div class="sidebar-nav">
            <div class="nav-item-header">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            
            <div class="nav-item-header">Manajemen</div>
            <a href="{{ route('admin.programs.index') }}" class="nav-link {{ request()->routeIs('admin.programs.*') ? 'active' : '' }}">
                <i class="bi bi-collection-fill"></i> Program Donasi
            </a>
            <a href="{{ route('admin.donasi.index') }}" class="nav-link {{ request()->routeIs('admin.donasi.*') ? 'active' : '' }}">
                <i class="bi bi-cash-coin"></i> Donasi Masuk
            </a>
            <a href="{{ route('admin.usulan.index') }}" class="nav-link {{ request()->routeIs('admin.usulan.*') ? 'active' : '' }}">
                <i class="bi bi-chat-left-text-fill"></i> Usulan Program
            </a>
            
            <div class="nav-item-header">Konten</div>
            <a href="{{ route('admin.konten.index') }}" class="nav-link {{ request()->routeIs('admin.konten.*') ? 'active' : '' }}">
                <i class="bi bi-newspaper"></i> Kegiatan
            </a>
            <a href="{{ route('admin.kategori.index') }}" class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                <i class="bi bi-tags-fill"></i> Kategori
            </a>
            
            <div class="nav-item-header">Pengaturan</div>
            <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="bi bi-gear-fill"></i> Pengaturan
            </a>
            
            <div class="nav-item-header">Akun</div>
            <a href="{{ route('home') }}" class="nav-link">
                <i class="bi bi-globe"></i> Lihat Website
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                    <i class="bi bi-box-arrow-left"></i> Keluar
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <header class="top-header">
            <div class="d-flex align-items-center">
                <button class="menu-toggle" id="menuToggle">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <h5 class="mb-1">@yield('page-title', 'Dashboard')</h5>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3 d-none-mobile">
                <span class="text-muted">{{ auth()->user()->nama }}</span>
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                    {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                </div>
            </div>
        </header>

        <div class="page-content">
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile Sidebar Toggle
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        function toggleSidebar() {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }
        
        if (menuToggle) {
            menuToggle.addEventListener('click', toggleSidebar);
        }
        
        if (overlay) {
            overlay.addEventListener('click', toggleSidebar);
        }
        
        // Close sidebar on nav link click (mobile)
        document.querySelectorAll('.sidebar-nav .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 992) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
