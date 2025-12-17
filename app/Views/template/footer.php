

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar = document.getElementById('sidebarNav');
    const mainContent = document.getElementById('mainContent');
    const toggleButton = document.getElementById('sidebarToggle');
    
    // Fungsi Toggle Sub Menu (Expand/Hide)
    function toggleSubMenu(menuId, element) {
        // Ketika sidebar ter-collapse, submenu tidak akan berfungsi (sesuai kode asli)
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
    
    document.addEventListener('DOMContentLoaded', () => {
         // Fungsi yang ingin dijalankan saat DOM selesai dimuat
    });
</script>
</body>
</html>