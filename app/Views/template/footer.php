

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
        const parent = element.parentElement;
        const isOpen = menu.classList.contains('open');

        document.querySelectorAll('.submenu-container').forEach(sm => {
            if (sm.id !== menuId) {
                sm.classList.remove('open', 'show');
                sm.parentElement.classList.remove('active', 'expanded');
            }
        });

        menu.classList.toggle('open', !isOpen);
        menu.classList.toggle('show', !isOpen);
        parent.classList.toggle('active', !isOpen);
        parent.classList.toggle('expanded', !isOpen);
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
        const currentPath = window.location.pathname.replace('/index.php', '');
        document.querySelectorAll('.nav-link').forEach(link => {
            const linkHref = (link.getAttribute('href') || '').replace('/index.php', '');
            if (currentPath === linkHref || currentPath.startsWith(linkHref + '/')) {
                if (link.closest('.submenu-container')) {
                    link.classList.add('sub-active', 'active');
                    const parentSubmenu = link.closest('.submenu-container');
                    const parentMenuItem = parentSubmenu.parentElement;
                    parentSubmenu.classList.add('open', 'show');
                    parentMenuItem.classList.add('active', 'expanded');
                } else if (link.parentElement) {
                    link.parentElement.classList.add('active');
                }
            }
        });
    });
</script>
</body>
</html>
