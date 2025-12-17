<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Admin Dashboard'; ?> | BEM KM PNP</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* ==================== 1. GLOBAL STYLES & LAYOUT VARIABLES ==================== */
        :root {
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 60px;
            --main-color: #00bf5c; /* Hijau BEM KM PNP */
            --bg-color: #f8f9fa; 
            --sidebar-bg: #fff; 
            --sidebar-text: #34495e; 
            --active-bg: #e6f7ee; 
            --navbar-height: 80px; 
        }

        body {
            background-color: var(--bg-color);
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }

        /* ==================== 2. HEADER/NAVBAR ==================== */
        .navbar-custom {
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            z-index: 1000;
            min-height: var(--navbar-height);
            display: flex;
            align-items: center;
            padding: 10px 15px; 
        }
        
        .header-brand {
            display: flex;
            align-items: center;
            margin-left: 15px; 
        }
        
        .header-brand img {
            width: 40px; 
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


        /* ==================== 3. SIDEBAR STYLES ==================== */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background-color: var(--sidebar-bg);
            position: fixed;
            top: var(--navbar-height); 
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

        /* Styling ikon saat Collapsed */
        .sidebar.collapsed .menu-item > a {
            justify-content: center;
            padding: 10px 0; 
        }

        /* Sembunyikan Teks Menu dan Panah saat Collapsed */
        .sidebar.collapsed .menu-item > a span:not(.menu-icon), 
        .sidebar.collapsed .menu-item .menu-arrow {
            display: none !important;
        }
        
        /* Sembunyikan Submenu saat Collapsed */
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
            background-color: #fafafaff; /* Latar yang sedikit berbeda dari sidebar */
            padding-left: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
            max-height: 0; 
        }

        /* Link Submenu */
        .submenu-container a {
            padding: 10px 15px 10px 47px !important; 
            font-size: 0.9rem;
            color: #6c757d;
            display: block; /* Penting: Jadikan block agar padding penuh */
            text-decoration: none;
            transition: background-color 0.2s, color 0.2s;
        }

        /* Efek Hover Submenu (Jadikan latar belakang sedikit gelap/terang) */
        .submenu-container a:hover {
            background-color: #eee; /* Latar belakang saat mouse di atas */
            color: var(--sidebar-text);
        }

        .submenu-container a.active {
            background-color: var(--active-bg); /* Menggunakan warna latar aktif menu utama (Hijau muda) */
            color: var(--main-color); /* Teks menjadi hijau utama */
            font-weight: 600;
            border-left: 3px solid var(--main-color);
            padding-left: 44px !important;
        }
        .submenu-container.show {
            max-height: 200px; /* Nilai max-height yang cukup besar */
        }
        
        /* ==================== 4. MAIN CONTENT (PENTING UNTUK PERGESERAN) ==================== */
        .main-content {
            /* Mendorong konten sejauh lebar sidebar penuh */
            margin-left: var(--sidebar-width); 
            
            /* Jarak dari atas (di bawah Navbar) */
            padding-top: calc(var(--navbar-height) + 20px); 
            
            /* Padding horizontal konten */
            padding-left: 20px;
            padding-right: 20px;
            padding-bottom: 20px;
            
            /* Transisi untuk pergeseran mulus */
            transition: margin-left 0.3s;
        }

        /* Saat Sidebar Collapsed, Main Content bergeser ke kiri */
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
                        <img src="/bem.png" alt="Super Admin">
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
        <?php echo view('template/sidebar'); ?>
    </div>
    
    <div class="main-content" id="mainContent">