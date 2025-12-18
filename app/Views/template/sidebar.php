
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
        <a href="/admin/user  ">
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
            <span class="menu-icon"><i class="fa-solid fa-calendar-days"></i></i></span>
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
        <a onclick="toggleSubMenu('katalogSubMenu', this);" class="dropdown-toggle-link">
            <span class="menu-icon"><i class="fa-solid fa-cart-shopping"></i></span>
            <span>Katalog</span>
            <span class="menu-arrow"><i class="fas fa-angle-down"></i></span>
        </a>
        <div id="katalogSubMenu" class="submenu-container">
            <a href="/admin/katalog/index">Daftar Katalog</a>
            <a href="/admin/katalog/create">Pengajuan Katalog</a>
        </div>
    </div>
    <div class="menu-item">
        <a href="/admin/kanban">
            <span class="menu-icon"><i class="fa-solid fa-check-to-slot"></i></span>
            <span>Kanban Board</span>
        </a>
    </div>
    <div class="menu-item">
        <a href="/admin/laporan/index">
            <span class="menu-icon"><i class="fa-regular fa-file-lines"></i></span>
            <span>Laporan</span>
        </a>
    </div>
</div>