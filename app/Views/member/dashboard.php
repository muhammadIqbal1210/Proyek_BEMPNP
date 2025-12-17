<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | BEM KM PNP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* ==================== 1. GLOBAL STYLES & LAYOUT ==================== */
        :root {
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 60px;
            --main-color: #00bf5c; /* Hijau cerah dari Logo NAIMA */
            --bg-color: #f8f9fa; /* Latar belakang body */
            --sidebar-bg: #fff; /* Sidebar Putih */
            --sidebar-text: #34495e; 
            --active-bg: #e6f7ee; /* Latar belakang item aktif */
            --navbar-height: 80px; /* Tinggi Navbar */
        }

        body {
            background-color: var(--bg-color);
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        /* ==================== 2. HEADER/NAVBAR ==================== */
        .navbar-custom {
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            z-index: 1000;
            min-height: var(--navbar-height); /* Menggunakan variabel CSS */
            display: flex;
            align-items: center;
            padding: 10px 15px; /* Padding horisontal dan vertikal */
        }
        
        /* Styling Logo BEM PNP */
        .header-brand {
            display: flex;
            align-items: center;
            margin-left: 15px; /* Jarak dari tombol toggle */
        }
        
        .header-brand img {
            width: 40px; /* Kontrol ukuran gambar logo */
            height: 40px;
            object-fit: contain;
            margin-right: 10px;
        }

        .header-brand .logo-text {
            line-height: 1.2;
            color: var(--sidebar-text);
        }

        .header-brand .logo-text .main-title {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .header-brand .logo-text .subtitle {
            font-size: 0.75rem;
            color: #6c757d;
        }

        .user-profile img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 8px;
        }
        
        .cursor-pointer { cursor: pointer; }


        /* ==================== 3. SIDEBAR ==================== */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background-color: var(--sidebar-bg);
            position: fixed;
            top: 85px; /* Disesuaikan dengan tinggi navbar */
            left: 0;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
            transition: width 0.3s;
            overflow-x: hidden;
            z-index: 999;
        }

        /* Sidebar Collapsed State */
        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar.collapsed .sidebar-header,
        .sidebar.collapsed .menu-title {
            display: none !important;
        }

        .sidebar.collapsed .menu-item > a {
            justify-content: center;
            padding: 10px 0; /* Padding vertikal saja */
        }

        /* Sembunyikan Teks Menu dan Panah saat Collapsed */
        .sidebar.collapsed .menu-item > a span:not(.menu-icon), 
        .sidebar.collapsed .menu-item .menu-arrow {
            display: none !important;
        }
        
        /* Sembunyikan Submenu saat Collapsed (Penting) */
        .sidebar.collapsed .submenu-container {
            display: none;
        }
        
        /* Menu Item Styling */
        .sidebar-header {
            color: var(--sidebar-text);
            padding: 0 15px 15px;
            font-size: 0.9rem;
            text-transform: uppercase;
            font-weight: 600;
        }

        .menu-item > a {
            color: var(--sidebar-text);
            text-decoration: none;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
            white-space: nowrap;
            transition: all 0.2s;
        }

        .menu-item a:hover:not(.active) {
            background-color: #f4f4f4;
        }

        .menu-icon {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        .menu-arrow {
            margin-left: auto;
            transition: transform 0.3s;
        }

        /* Active State */
        .menu-item .active,
        .menu-item a.dropdown-toggle-link.active {
            background-color: var(--active-bg);
            color: var(--main-color);
            font-weight: 600;
            border-left: 3px solid var(--main-color);
            padding-left: 12px;
        }
        
        .sidebar.collapsed .menu-item .active {
            border-left: none;
            padding-left: 0;
            justify-content: center;
        }

        /* Submenu Styling */
        .submenu-container {
            background-color: #fafafa;
            padding-left: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
            max-height: 0; 
        }

        .submenu-container.show {
            max-height: 200px;
        }

        .submenu-container a {
            padding: 8px 15px 8px 47px !important;
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        /* ==================== 4. MAIN CONTENT ==================== */
        .main-content {
            margin-left: var(--sidebar-width);
            /* Padding atas: Tinggi Navbar + Tambahan Padding (20px) */
            padding-top: calc(var(--navbar-height) + 20px); 
            padding-left: 20px;
            padding-right: 20px;
            padding-bottom: 20px;
            transition: margin-left 0.3s;
        }

        .main-content.collapsed {
            margin-left: var(--sidebar-collapsed-width);
        }

    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand navbar-custom">
        <div class="container-fluid">
            
            <div class="d-flex align-items-center">
                <button class="btn btn-sm" id="sidebarToggle" title="Toggle Sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="header-brand">
                    <img src="/bem.png" alt="Logo BEM PNP">
                    <div class="logo-text">
                        <span class="main-title d-block">BEM KM</span>
                        <span class="subtitle d-block">Politeknik Negeri Padang</span>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center ms-auto">
                
                <a class="nav-link me-3 cursor-pointer" title="Dark/Light Mode">
                    <i class="fas fa-moon"></i>
                </a>
                
                <div class="dropdown me-3">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-globe"></i> EN
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">ID</a></li>
                        <li><a class="dropdown-item" href="#">EN</a></li>
                    </ul>
                </div>
                
                <div class="dropdown">
                    <a class="nav-link d-flex align-items-center user-profile cursor-pointer" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://via.placeholder.com/150/00bf5c/FFFFFF?text=SA" alt="Super Admin">
                        <span class="d-none d-md-inline me-1">Super Admin</span>
                        <i class="fas fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-circle me-2"></i> Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/logout"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>

    <div class="sidebar" id="sidebarNav">
        <div class="sidebar-header">
            MAIN
        </div>

        <div class="main-menu">
            <div class="menu-item">
                <a href="/admin/dashboard">
                    <span class="menu-icon"><i class="fas fa-home"></i></span>
                    <span>Home</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="#">
                    <span class="menu-icon"><i class="fas fa-user"></i></span>
                    <span>User</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="#">
                    <span class="menu-icon"><i class="fas fa-user-shield"></i></span>
                    <span>Roles & Permissions</span>
                </a>
            </div>
            <div class="menu-item">
                <a onclick="toggleSubMenu('pengumumanSubMenu', this);" class="dropdown-toggle-link">
                    <span class="menu-icon"><i class="fa-solid fa-bullhorn"></i></span>
                    <span>Pengumuman</span>
                    <span class="menu-arrow"><i class="fas fa-angle-down"></i></span>
                </a>
                <div id="pengumumanSubMenu" class="submenu-container">
                    <a href="/admin/pengumuman/index">Daftar Pengumuman</a>
                </div>
            </div>
            
            <div class="menu-item">
                <a onclick="toggleSubMenu('beasiswaSubMenu', this);" class="dropdown-toggle-link">
                    <span class="menu-icon"><i class="fas fa-graduation-cap"></i></span>
                    <span>Beasiswa</span>
                    <span class="menu-arrow"><i class="fas fa-angle-down"></i></span>
                </a>
                <div id="beasiswaSubMenu" class="submenu-container">
                    <a href="/admin/beasiswa/index">Daftar Beasiswa</a>
                    <a href="/admin/beasiswa/create">Pengajuan Beasiswa</a> 
                </div>
            </div>
            
            <div class="menu-item">
                <a onclick="toggleSubMenu('lombaSubMenu', this);" class="dropdown-toggle-link">
                    <span class="menu-icon"><i class="fas fa-trophy"></i></span>
                    <span>Lomba</span>
                    <span class="menu-arrow"><i class="fas fa-angle-down"></i></span>
                </a>
                <div id="lombaSubMenu" class="submenu-container">
                    <a href="/admin/lomba/index">Daftar Lomba</a>
                    <a href="/admin/lomba/create">Pengajuan Lomba</a>
                </div>
            </div>
            <div class="menu-item">
                <a onclick="toggleSubMenu('eventSubMenu', this);" class="dropdown-toggle-link">
                    <span class="menu-icon"><i class="fas fa-trophy"></i></span>
                    <span>Event</span>
                    <span class="menu-arrow"><i class="fas fa-angle-down"></i></span>
                </a>
                <div id="eventSubMenu" class="submenu-container">
                    <a href="/admin/event/index">Daftar Event</a>
                    <a href="/admin/event/create">Pengajuan Event</a>
                </div>
            </div>
            <div class="menu-item">
                <a onclick="toggleSubMenu('beritaSubMenu', this);" class="dropdown-toggle-link">
                    <span class="menu-icon"><i class="fas fa-newspaper"></i></span>
                    <span>Berita</span>
                    <span class="menu-arrow"><i class="fas fa-angle-down"></i></span>
                </a>
                <div id="beritaSubMenu" class="submenu-container">
                    <a href="/admin/berita/index">Daftar Berita</a>
                    <a href="/admin/berita/create">Pengajuan Berita</a>
                </div>
            </div>
            <div class="menu-item">
                <a onclick="toggleSubMenu('laporanSubMenu', this);" class="dropdown-toggle-link">
                    <span class="menu-icon"><i class="fa-regular fa-file-lines"></i></span>
                    <span>Laporan
                    </span>
                    <span class="menu-arrow"><i class="fas fa-angle-down"></i></span>
                </a>
                <div id="laporanSubMenu" class="submenu-container">
                    <a href="/admin/laporan/index">Daftar Laporan</a>
                </div>
            </div>
            
            <div class="menu-item" style="position: absolute; bottom: 20px; width: 100%;">
                <a href="/logout">
                    <span class="menu-icon"><i class="fas fa-sign-out-alt"></i></span>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </div>

    <div class="main-content" id="mainContent">
        <div class="container-fluid">
            <ol class="breadcrumb" style="background: none; padding: 0;">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
            
            <div class="content-card">
                <h2>Dashboard Overview</h2>
                <p>Kelola data dan lihat statistik utama aplikasi Anda.</p>
            </div>
            
            <footer class="mt-5 text-center text-muted">
                <p>&copy; 2023 BEM KM PNP Deployment by Harmoni Karya.</p>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebarNav');
        const mainContent = document.getElementById('mainContent');
        const toggleButton = document.getElementById('sidebarToggle');
        
        // Fungsi Toggle Sub Menu (Expand/Hide)
        function toggleSubMenu(menuId, element) {
            // Ketika sidebar ter-collapse, submenu tidak akan berfungsi
            if (sidebar.classList.contains('collapsed')) {
                return; 
            }
            
            const menu = document.getElementById(menuId);
            const arrow = element.querySelector('.menu-arrow i');
            
            menu.classList.toggle('show');
            element.classList.toggle('active');

            if (menu.classList.contains('show')) {
                arrow.style.transform = 'rotate(180deg)';
            } else {
                arrow.style.transform = 'rotate(0deg)';
            }
        }
        
        // Fungsi Toggle Sidebar (Collapse/Expand)
        toggleButton.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');
            
            // Saat di-collapse, pastikan semua panah sub-menu kembali ke posisi default
            if (sidebar.classList.contains('collapsed')) {
                document.querySelectorAll('.menu-arrow i').forEach(arr => arr.style.transform = 'rotate(0deg)');
            }
        });
        
        // Untuk menjaga keadaan sidebar saat pertama load
        document.addEventListener('DOMContentLoaded', () => {
             // Opsional: Atur item menu aktif secara manual jika tidak ada sistem routing
             document.querySelectorAll('.menu-item a').forEach(item => {
                if (item.classList.contains('active')) {
                    // Hanya untuk demo, hapus di production
                }
            });
        });
    </script>
</body>
</html>