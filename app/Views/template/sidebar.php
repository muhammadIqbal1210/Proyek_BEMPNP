<?php
/**
 * Perbaikan Sidebar:
 * 1. Menghapus class 'fixed' dari '.main-menu' agar mengikuti overflow parent.
 * 2. Menambahkan 'display: flex' dan 'flex-direction: column' pada .sidebar.
 * 3. Mengatur padding dan scrollbar agar lebih responsif.
 */
?>

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

    /* PERBAIKAN UTAMA: Sidebar sebagai container scroll tunggal */
    .sidebar {
        width: 260px;
        height: 100vh;
        position: fixed; /* Sidebar tetap di kiri */
        top: 0;
        left: 0;
        background: var(--sidebar-bg);
        border-right: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        z-index: 50;
    }

    .sidebar-header {
        font-size: 0.75rem;
        font-weight: 700;
        color: #94a3b8;
        letter-spacing: 0.1em;
        padding: 1.5rem 1rem 1rem;
        text-transform: uppercase;
        flex-shrink: 0; /* Header tidak ikut menyusut */
    }

    /* Area menu yang bisa di-scroll */
    .main-menu-container {
        flex-grow: 1;
        overflow-y: auto;
        padding: 0 1rem 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    /* Mempercantik scrollbar */
    .main-menu-container::-webkit-scrollbar {
        width: 5px;
    }
    .main-menu-container::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
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

    .menu-item.expanded .menu-arrow {
        transform: rotate(180deg);
    }

    .submenu-container {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-in-out;
        background-color: var(--submenu-bg);
        border-radius: 8px;
        margin-top: 2px;
    }

    .submenu-container.open {
        max-height: 1000px; /* Ditingkatkan agar muat banyak item */
        margin-bottom: 0.5rem;
        padding: 0.25rem 0;
    }

    .submenu-container a {
        padding: 0.6rem 1rem 0.6rem 3.25rem;
        font-size: 0.85rem;
        display: block;
        border-left: 3px solid transparent;
        border-radius: 0;
        font-weight: 400;
    }

    .submenu-container a.sub-active {
        color: var(--sidebar-active-color);
        border-left-color: var(--accent-color);
        background-color: #f1f5f9;
        font-weight: 600;
    }
</style>

<?php 
    $role = session()->get('role') ?? 'member'; 
?>

<div class="sidebar">
    <div class="sidebar-header">Main Menu (<?= ucfirst($role) ?>)</div>

    <!-- Hapus class 'fixed' dan 'top-0' di sini karena sudah dihandle parent -->
    <div class="main-menu-container" id="nav-accordion">
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

        <div class="menu-item has-submenu">
            <a onclick="toggleSubMenu('internalSubMenu', this);" class="dropdown-link">
                <span class="menu-icon"><i class="fas fa-briefcase"></i></span>
                <span>Data Internal</span>
                <span class="menu-arrow"><i class="fas fa-angle-down"></i></span>
            </a>
            <div id="internalSubMenu" class="submenu-container">
                <?php if ($role == 'admin') : ?>
                    <a href="/admin/pengurus" class="nav-link">Kepengurusan</a>
                    <a href="/admin/profil" class="nav-link">Profil Kabinet</a>
                    <a href="/admin/kontak" class="nav-link">Kontak Penting</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleSubMenu(id, element) {
        const submenu = document.getElementById(id);
        const parent = element.parentElement;
        const isOpen = submenu.classList.contains('open');
        
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

    document.addEventListener("DOMContentLoaded", function() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll(".nav-link");

        navLinks.forEach(link => {
            const linkHref = link.getAttribute("href");
            if (currentPath === linkHref || currentPath.startsWith(linkHref + '/')) {
                if (link.closest('.submenu-container')) {
                    link.classList.add("sub-active");
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