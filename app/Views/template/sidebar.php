<!-- Dependencies: Font Awesome & Google Fonts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<style>
    :root {
        --sidebar-bg: #ffffff;
        --sidebar-color: #64748b;
        --sidebar-active-bg: #f1f5f9;
        --sidebar-active-color: #198a59ff;
        --accent-color: #198a59ff;
        --submenu-bg: #f8fafc;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: #f1f5f9;
        margin: 0;
    }

    .sidebar {
        width: 260px;
        height: 100vh;
        background: var(--sidebar-bg);
        border-right: 1px solid #e2e8f0;
        padding: 1.5rem 1rem;
        overflow-y: auto;
    }

    .sidebar-header {
        font-size: 0.75rem;
        font-weight: 700;
        color: #94a3b8;
        letter-spacing: 0.1em;
        padding: 0 1rem 1rem;
        text-transform: uppercase;
    }

    .main-menu {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .menu-item {
        position: relative;
    }

    .menu-item a {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        color: var(--sidebar-color);
        text-decoration: none;
        font-size: 0.925rem;
        font-weight: 500;
        border-radius: 8px;
        transition: var(--transition);
        cursor: pointer;
    }

    /* Style saat menu induk aktif */
    .menu-item.active > a {
        background-color: var(--sidebar-active-bg);
        color: var(--sidebar-active-color);
        font-weight: 600;
    }

    .menu-item a:hover {
        background-color: var(--sidebar-active-bg);
        color: var(--sidebar-active-color);
    }

    .menu-icon {
        width: 1.5rem;
        margin-right: 0.75rem;
        display: flex;
        justify-content: center;
        font-size: 1.1rem;
    }

    .menu-arrow {
        margin-left: auto;
        font-size: 0.75rem;
        transition: var(--transition);
    }

    /* Rotasi panah saat submenu terbuka */
    .menu-item.expanded .menu-arrow {
        transform: rotate(180deg);
    }

    /* Submenu Container */
    .submenu-container {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-in-out;
        background-color: var(--submenu-bg);
        border-radius: 0 0 8px 8px;
        margin-top: -4px;
        margin-bottom: 0;
    }

    .submenu-container.open {
        max-height: 500px;
        margin-bottom: 0.5rem;
        padding-bottom: 0.5rem;
    }

    .submenu-container a {
        padding: 0.6rem 1rem 0.6rem 3.25rem;
        font-size: 0.85rem;
        display: block;
        border-left: 3px solid transparent;
        border-radius: 0;
        font-weight: 400;
    }

    /* Style saat link submenu aktif */
    .submenu-container a.sub-active {
        color: var(--sidebar-active-color);
        border-left-color: var(--accent-color);
        background-color: #f1f5f9;
        font-weight: 600;
    }

    .submenu-container a:hover {
        background-color: #f1f5f9;
        color: var(--sidebar-active-color);
    }
</style>

<?php 
    $role = session()->get('role') ?? 'member'; 
?>

<div class="sidebar">
    <div class="sidebar-header">Main Menu (<?= ucfirst($role) ?>)</div>

    <div class="main-menu" id="nav-accordion">
        <!-- Dashboard -->
        <div class="menu-item">
            <a href="<?= ($role == 'admin') ? '/admin/dashboard' : '/member/dashboard' ?>" class="nav-link">
                <span class="menu-icon"><i class="fas fa-home"></i></span>
                <span>Home</span>
            </a>
        </div>

        <?php if ($role == 'admin') : ?>
        <div class="menu-item">
            <a href="/admin/user" class="nav-link">
                <span class="menu-icon"><i class="fas fa-user"></i></span>
                <span>User Management</span>
            </a>
        </div>

        <!-- Dropdown: Pengumuman -->
        <div class="menu-item has-submenu">
            <a onclick="toggleSubMenu('pengumumanSubMenu', this);" class="dropdown-link">
                <span class="menu-icon"><i class="fa-solid fa-bullhorn"></i></span>
                <span>Pengumuman</span>
                <span class="menu-arrow"><i class="fas fa-angle-down"></i></span>
            </a>
            <div id="pengumumanSubMenu" class="submenu-container">
                <a href="/admin/pengumuman/index" class="nav-link">Daftar Pengumuman</a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Dropdown: Beasiswa -->
        <div class="menu-item has-submenu">
            <a onclick="toggleSubMenu('beasiswaSubMenu', this);" class="dropdown-link">
                <span class="menu-icon"><i class="fas fa-graduation-cap"></i></span>
                <span>Beasiswa</span>
                <span class="menu-arrow"><i class="fas fa-angle-down"></i></span>
            </a>
            <div id="beasiswaSubMenu" class="submenu-container">
                <?php if ($role == 'admin') : ?>
                    <a href="/admin/beasiswa/index" class="nav-link">Daftar Beasiswa</a>
                <?php endif; ?>
                <a href="/admin/beasiswa/create" class="nav-link">Pengajuan Baru</a>
            </div>
        </div>

        <!-- Dropdown: Lomba -->
        <div class="menu-item has-submenu">
            <a onclick="toggleSubMenu('lombaSubMenu', this);" class="dropdown-link">
                <span class="menu-icon"><i class="fas fa-trophy"></i></span>
                <span>Lomba</span>
                <span class="menu-arrow"><i class="fas fa-angle-down"></i></span>
            </a>
            <div id="lombaSubMenu" class="submenu-container">
                <?php if ($role == 'admin') : ?>
                    <a href="/admin/lomba/index" class="nav-link">Daftar Lomba</a>
                <?php endif; ?>
                <a href="/admin/lomba/create" class="nav-link">Ajukan Lomba</a>
            </div>
        </div>

        <!-- Dropdown: Event -->
        <div class="menu-item has-submenu">
            <a onclick="toggleSubMenu('eventSubMenu', this);" class="dropdown-link">
                <span class="menu-icon"><i class="fa-solid fa-calendar-days"></i></span>
                <span>Event</span>
                <span class="menu-arrow"><i class="fas fa-angle-down"></i></span>
            </a>
            <div id="eventSubMenu" class="submenu-container">
                <?php if ($role == 'admin') : ?>
                    <a href="/admin/event/index" class="nav-link">Daftar Event</a>
                <?php endif; ?>
                <a href="/admin/event/create" class="nav-link">Pengajuan Event</a>
            </div>
        </div>
        
        <!-- Dropdown: Berita -->
        <div class="menu-item has-submenu">
            <a onclick="toggleSubMenu('beritaSubMenu', this);" class="dropdown-link">
                <span class="menu-icon"><i class="fas fa-newspaper"></i></span>
                <span>Berita</span>
                <span class="menu-arrow"><i class="fas fa-angle-down"></i></span>
            </a>
            <div id="beritaSubMenu" class="submenu-container">
                <?php if ($role == 'admin') : ?>
                    <a href="/admin/berita/index" class="nav-link">Daftar Berita</a>
                <?php endif; ?>
                <a href="/admin/berita/create" class="nav-link">Pengajuan Berita</a>
            </div>
        </div>

        <!-- Dropdown: Katalog -->
        <div class="menu-item has-submenu">
            <a onclick="toggleSubMenu('katalogSubMenu', this);" class="dropdown-link">
                <span class="menu-icon"><i class="fa-solid fa-cart-shopping"></i></span>
                <span>Katalog</span>
                <span class="menu-arrow"><i class="fas fa-angle-down"></i></span>
            </a>
            <div id="katalogSubMenu" class="submenu-container">
                <?php if ($role == 'admin') : ?>
                    <a href="/admin/katalog/index" class="nav-link">Daftar Katalog</a>
                <?php endif; ?>
                <a href="/admin/katalog/create" class="nav-link">Pengajuan Katalog</a>
            </div>
        </div>

        <?php if ($role == 'admin' || $role == 'member') : ?>
        <div class="menu-item">
            <a href="/admin/kanban" class="nav-link">
                <span class="menu-icon"><i class="fa-solid fa-layer-group"></i></span>
                <span>Kanban Board</span>
            </a>
        </div>
        <?php endif; ?>

        <?php if ($role == 'admin') : ?>
        <div class="menu-item">
            <a href="/admin/laporan/index" class="nav-link">
                <span class="menu-icon"><i class="fa-regular fa-file-lines"></i></span>
                <span>Laporan Pengaduan</span>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
    /**
     * Fungsi Toggle Submenu manual saat diklik
     */
    function toggleSubMenu(id, element) {
        const submenu = document.getElementById(id);
        const parent = element.parentElement;
        const isOpen = submenu.classList.contains('open');
        
        // Tutup submenu lain (agar hanya 1 yang terbuka)
        document.querySelectorAll('.submenu-container').forEach(sm => {
            if(sm.id !== id) {
                sm.classList.remove('open');
                sm.parentElement.classList.remove('expanded');
            }
        });

        if (!isOpen) {
            submenu.classList.add('open');
            parent.classList.add('expanded');
        } else {
            submenu.classList.remove('open');
            parent.classList.remove('expanded');
        }
    }

    /**
     * Script Auto-Active Detection
     */
    document.addEventListener("DOMContentLoaded", function() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll(".nav-link");

        navLinks.forEach(link => {
            const linkHref = link.getAttribute("href");

            // Cek jika URL saat ini sama dengan href link
            if (currentPath === linkHref || currentPath.startsWith(linkHref + '/')) {
                
                // 1. Tandai link  aktif
                // Jika itu link di dalam submenu
                if (link.closest('.submenu-container')) {
                    link.classList.add("sub-active");
                    
                    // 2. Expand menu induk
                    const parentSubmenu = link.closest('.submenu-container');
                    const parentMenuItem = parentSubmenu.parentElement;
                    
                    parentSubmenu.classList.add('open');
                    parentMenuItem.classList.add('active'); 
                    parentMenuItem.classList.add('expanded'); 
                } else {
                    link.parentElement.classList.add("active");
                }
            }
        });
    });
</script>