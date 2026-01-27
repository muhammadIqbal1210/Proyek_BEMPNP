<!-- Import Dependencies -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
:root {
    --primary: #4e73df;
    --success: #1cc88a;
    --info: #36b9cc;
    --warning: #f6c23e;
    --danger: #e74a3b;
    --secondary: #858796;
    --dark: #5a5c69;
    --light: #f8f9fc;
    --white: #ffffff;
    --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --gradient-success: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    --shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    --shadow-lg: 0 1rem 3rem rgba(0, 0, 0, 0.175);
}

body {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    font-family: 'Nunito', sans-serif;
    color: var(--dark);
}

.dashboard-header {
    background: var(--gradient-success);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-lg);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: var(--shadow);
    transition: transform 0.3s ease;
    border-top: 4px solid var(--primary);
}

.stat-card:hover { transform: translateY(-5px); }
.stat-card.success { border-top-color: var(--success); }
.stat-card.warning { border-top-color: var(--warning); }
.stat-card.danger { border-top-color: var(--danger); }

.charts-section {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

.chart-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: var(--shadow);
    display: flex;
    flex-direction: column;
}

.chart-container {
    position: relative;
    flex-grow: 1;
    min-height: 250px;
    width: 100%;
}

.activities-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.activity-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: var(--shadow);
}

.activity-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #eee;
}

.activity-icon {
    width: 35px;
    height: 35px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    color: white;
}

@media (max-width: 992px) {
    .charts-section { grid-template-columns: 1fr; }
}
</style>

<div class="container-fluid py-4">
    <div class="dashboard-header animate__animated animate__fadeInDown">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1"><i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin</h2>
                <p class="mb-0 opacity-75">Sistem Informasi BEM Terintegrasi</p>
            </div>
            <div class="text-end d-none d-md-block">
                <div class="h5 mb-0"><?php echo date('l, d M Y'); ?></div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid animate__animated animate__fadeInUp animate__delay-1s">
        <div class="stat-card success">
            <div class="stat-label text-success small fw-bold uppercase">Total Users</div>
            <div class="h3 fw-bold mb-0"><?php echo number_format($total_users ?? 0); ?></div>
        </div>
        <div class="stat-card info">
            <div class="stat-label text-info small fw-bold">Beasiswa Aktif</div>
            <div class="h3 fw-bold mb-0"><?php echo $active_beasiswas ?? 0; ?></div>
        </div>
        <div class="stat-card warning">
            <div class="stat-label text-warning small fw-bold">Total Berita</div>
            <div class="h3 fw-bold mb-0"><?php echo $total_beritas ?? 0; ?></div>
        </div>
        <div class="stat-card danger">
            <div class="stat-label text-danger small fw-bold">Pengumuman Aktif</div>
            <div class="h3 fw-bold mb-0"><?php echo $active_pengumumans ?? 0; ?></div>
        </div>
    </div>

    <!-- Charts -->
    <div class="charts-section animate__animated animate__fadeInUp animate__delay-2s">
        <div class="chart-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold m-0"><i class="fas fa-chart-line text-primary me-2"></i>Analisis Pertumbuhan</h6>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-primary" onclick="switchChart('users')">Users</button>
                    <button class="btn btn-outline-primary" onclick="switchChart('beasiswas')">Beasiswa</button>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="growthChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <h6 class="fw-bold mb-3"><i class="fas fa-chart-pie text-success me-2"></i>Distribusi User</h6>
            <div class="chart-container" style="min-height: 200px;">
                <canvas id="distributionChart"></canvas>
            </div>
            <!-- Legenda Manual agar tidak tertutup -->
            <div class="mt-3">
                <div class="d-flex justify-content-between mb-1 small">
                    <span><i class="fas fa-circle text-primary me-1"></i> Super Admin</span>
                    <span class="fw-bold" id="val-superadmin">0</span>
                </div>
                <div class="d-flex justify-content-between mb-1 small">
                    <span><i class="fas fa-circle text-success me-1"></i> Admin</span>
                    <span class="fw-bold" id="val-admin">0</span>
                </div>
                <div class="d-flex justify-content-between mb-1 small">
                    <span><i class="fas fa-circle text-info me-1"></i> Member</span>
                    <span class="fw-bold" id="val-member">0</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="activities-section animate__animated animate__fadeInUp animate__delay-3s">
        <div class="activity-card">
            <h6 class="fw-bold mb-3">Beasiswa Terbaru</h6>
            <?php if(!empty($recent_beasiswas)): foreach(array_slice($recent_beasiswas, 0, 4) as $b): ?>
            <div class="activity-item">
                <div class="activity-icon bg-info"><i class="fas fa-graduation-cap"></i></div>
                <div class="small">
                    <div class="fw-bold"><?php echo esc($b['nama_beasiswa']); ?></div>
                    <div class="text-muted"><?php echo date('d M Y', strtotime($b['created_at'])); ?></div>
                </div>
            </div>
            <?php endforeach; else: echo "<p class='text-muted small'>Tidak ada data.</p>"; endif; ?>
        </div>

        <div class="activity-card">
            <h6 class="fw-bold mb-3">Berita Terbaru</h6>
            <?php if(!empty($recent_beritas)): foreach(array_slice($recent_beritas, 0, 4) as $n): ?>
            <div class="activity-item">
                <div class="activity-icon bg-warning"><i class="fas fa-newspaper"></i></div>
                <div class="small">
                    <div class="fw-bold"><?php echo esc($n['judulberita']); ?></div>
                    <div class="text-muted"><?php echo esc($n['author'] ?? 'Admin'); ?></div>
                </div>
            </div>
            <?php endforeach; else: echo "<p class='text-muted small'>Tidak ada data.</p>"; endif; ?>
        </div>

        <div class="activity-card">
            <h6 class="fw-bold mb-3">Laporan Terbaru</h6>
            <?php if(!empty($recent_laporans)): foreach(array_slice($recent_laporans, 0, 4) as $l): ?>
            <div class="activity-item">
                <div class="activity-icon bg-danger"><i class="fas fa-file-alt"></i></div>
                <div class="small">
                    <div class="fw-bold"><?php echo esc(substr($l['isi'], 0, 30)); ?><?php echo strlen($l['isi']) > 30 ? '...' : ''; ?></div>
                    <div class="text-muted"><?php echo date('d M Y', strtotime($l['created_at'])); ?> • <?php echo esc($l['status_laporan'] ?? 'Pending'); ?></div>
                </div>
            </div>
            <?php endforeach; else: echo "<p class='text-muted small'>Tidak ada data.</p>"; endif; ?>
        </div>

        <div class="activity-card">
            <h6 class="fw-bold mb-3">Event Terbaru</h6>
            <?php if(!empty($recent_events)): foreach(array_slice($recent_events, 0, 4) as $e): ?>
            <div class="activity-item">
                <div class="activity-icon bg-success"><i class="fas fa-calendar-alt"></i></div>
                <div class="small">
                    <div class="fw-bold"><?php echo esc($e['nama_event']); ?></div>
                    <div class="text-muted"><?php echo date('d M Y', strtotime($e['created_at'])); ?> • <?php echo ($e['biaya'] && is_numeric($e['biaya'])) ? 'Rp ' . number_format((float)$e['biaya'], 0, ',', '.') : 'Free'; ?></div>
                </div>
            </div>
            <?php endforeach; else: echo "<p class='text-muted small'>Tidak ada data.</p>"; endif; ?>
        </div>

        <div class="activity-card">
            <h6 class="fw-bold mb-3">Lomba Terbaru</h6>
            <?php if(!empty($recent_lombas)): foreach(array_slice($recent_lombas, 0, 4) as $l): ?>
            <div class="activity-item">
                <div class="activity-icon bg-primary"><i class="fas fa-trophy"></i></div>
                <div class="small">
                    <div class="fw-bold"><?php echo esc($l['nama_lomba']); ?></div>
                    <div class="text-muted"><?php echo date('d M Y', strtotime($l['created_at'])); ?> • <?php echo esc($l['kategori'] ?? 'Umum'); ?></div>
                </div>
            </div>
            <?php endforeach; else: echo "<p class='text-muted small'>Tidak ada data.</p>"; endif; ?>
        </div>
        <div class="activity-card">
            <h6 class="fw-bold mb-3">Katalog Terbaru</h6>
            <?php if(!empty($recent_katalogs)): foreach(array_slice($recent_katalogs, 0, 4) as $l): ?>
            <div class="activity-item">
                <div class="activity-icon" style="background-color: #fd7e14; border-color: #fd7e14;"><i class="fas fa-cart-shopping"></i></div>
                <div class="small">
                    <div class="fw-bold"><?php echo esc($l['nama_barang']); ?></div>
                    <div class="text-muted"><?php echo date('d M Y', strtotime($l['created_at'])); ?></div>
                </div>
            </div>
            <?php endforeach; else: echo "<p class='text-muted small'>Tidak ada data.</p>"; endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Growth Chart
    const growthCtx = document.getElementById('growthChart').getContext('2d');
    const dbGrowth = {
        users: <?php echo json_encode($user_growth ?? array_fill(0, 12, 0)); ?>,
        beasiswas: <?php echo json_encode($beasiswa_growth ?? array_fill(0, 12, 0)); ?>,
        beasiswa_buka: <?php echo json_encode($beasiswa_growth_buka ?? array_fill(0, 12, 0)); ?>,
        beasiswa_tutup: <?php echo json_encode($beasiswa_growth_tutup ?? array_fill(0, 12, 0)); ?>
    };

    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const currentMonth = new Date().getMonth();
    const dynamicLabels = [];
    for (let i = 11; i >= 0; i--) {
        let m = currentMonth - i;
        if (m < 0) m += 12;
        dynamicLabels.push(monthNames[m]);
    }

    const growthChart = new Chart(growthCtx, {
        type: 'line',
        data: {
            labels: dynamicLabels,
            datasets: [{
                label: 'Users',
                data: dbGrowth.users,
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    window.switchChart = (type) => {
        growthChart.data.datasets[0].data = dbGrowth[type];
        growthChart.data.datasets[0].label = type.toUpperCase();
        growthChart.update();
    };

    // 2. User Distribution Chart (FIXED LABEL CLIPPING)
    const distCtx = document.getElementById('distributionChart').getContext('2d');
    const rawDist = <?php echo json_encode($role_distribution ?? []); ?>;
    
    // Normalisasi pencarian data
    const getVal = (name) => {
        const key = Object.keys(rawDist).find(k => k.toLowerCase().replace(' ', '') === name.toLowerCase());
        return key ? parseInt(rawDist[key]) : 0;
    };

    const dataVals = [getVal('superadmin'), getVal('admin'), getVal('member')];
    
    // Update teks legenda manual
    document.getElementById('val-superadmin').innerText = dataVals[0];
    document.getElementById('val-admin').innerText = dataVals[1];
    document.getElementById('val-member').innerText = dataVals[2];

    new Chart(distCtx, {
        type: 'doughnut',
        data: {
            labels: ['Super Admin', 'Admin', 'Member'],
            datasets: [{
                data: dataVals,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                hoverOffset: 10,
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            layout: {
                padding: { top: 10, bottom: 10, left: 10, right: 10 }
            },
            plugins: {
                legend: { display: false } // Matikan legenda default agar tidak tertutup
            }
        }
    });
});
</script>