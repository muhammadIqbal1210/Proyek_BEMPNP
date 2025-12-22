<!-- Import Dependencies -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root {
        --primary: #4e73df;
        --success: #1cc88a;
        --info: #36b9cc;
        --warning: #f6c23e;
        --danger: #e74a3b;
        --body-bg: #f8f9fc;
        --card-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
    }

    body {
        background-color: var(--body-bg);
        font-family: 'Nunito', sans-serif;
        color: #5a5c69;
    }

    .breadcrumb-item a { color: var(--primary); text-decoration: none; }

    .header-gradient {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
    }

    .card {
        border: none;
        box-shadow: var(--card-shadow);
        border-radius: 10px;
    }

    .stat-card {
        border-left: 4px solid;
        transition: transform 0.2s;
    }

    .stat-card:hover { transform: translateY(-3px); }

    .text-xs { font-size: .7rem; }
    .text-gray-300 { color: #dddfeb !important; }

    .table thead th {
        background-color: #f8f9fc;
        border-bottom: 2px solid #e3e6f0;
        color: #4e73df;
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    .badge-pill {
        padding: 0.5em 1em;
        border-radius: 50px;
    }

    .avatar-circle {
        width: 35px;
        height: 35px;
        background-color: #4e73df;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-weight: bold;
        font-size: 0.8rem;
    }
</style>

<div class="container-fluid py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent p-0 mb-4">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="header-gradient shadow-sm">
        <h3 class="fw-bold mb-1">Dashboard Overview</h3>
        <p class="mb-0 opacity-75">Kelola data dan lihat statistik utama aplikasi Anda secara real-time.</p>
    </div>

    <!-- Stats Row (Data Diambil dari Input Anda) -->
    <div class="row">
        <!-- Users Card -->
        <div class="col-md-3 mb-4">
            <div class="card stat-card border-primary h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Users</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">105</div>
                            <div class="mt-2 text-success text-xs">
                                <i class="fas fa-arrow-up"></i> 5% dari bulan lalu
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Roles Card -->
        <div class="col-md-3 mb-4">
            <div class="card stat-card border-info h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Roles</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">4</div>
                            <div class="mt-2 text-danger text-xs">
                                <i class="fas fa-arrow-down"></i> 0 baru
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tag fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Permissions Card -->
        <div class="col-md-3 mb-4">
            <div class="card stat-card border-warning h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Permissions</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">70</div>
                            <div class="mt-2 text-muted text-xs">Status: Aktif</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-key fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reports Card -->
        <div class="col-md-3 mb-4">
            <div class="card stat-card border-success h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Reports Sent</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">2/2</div>
                            <div class="mt-2 text-muted text-xs">Target Bulanan Selesai</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Pertumbuhan User (Total: 105)</h6>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light border dropdown-toggle" type="button">Filter</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 300px;">
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">Komposisi User</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2" style="height: 230px;">
                        <canvas id="rolesPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2"><i class="fas fa-circle text-primary"></i> Mahasiswa</span>
                        <span class="mr-2"><i class="fas fa-circle text-success"></i> Admin</span>
                        <span class="mr-2"><i class="fas fa-circle text-info"></i> Reviewer</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Pengajuan Beasiswa Terbaru</h6>
                    <button class="btn btn-primary btn-sm rounded-pill px-3">Lihat Semua</button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">No</th>
                                    <th>Mahasiswa</th>
                                    <th>Jenis Beasiswa</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4">1</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-3">AF</div>
                                            <div>
                                                <div class="fw-bold">Ahmad Fauzi</div>
                                                <div class="text-xs text-muted">Teknik Informatika</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>PPA</td>
                                    <td><span class="badge bg-warning text-dark badge-pill">Pending</span></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-info rounded-pill px-3">Lihat Detail</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4">2</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-3 bg-success">SR</div>
                                            <div>
                                                <div class="fw-bold">Siti Rahma</div>
                                                <div class="text-xs text-muted">Sistem Informasi</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>KIP Kuliah</td>
                                    <td><span class="badge bg-success badge-pill">Disetujui</span></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-info rounded-pill px-3">Lihat Detail</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Data Pertumbuhan User (Disesuaikan agar total akhir mencapai 105)
    const ctxGrowth = document.getElementById('growthChart').getContext('2d');
    new Chart(ctxGrowth, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
            datasets: [{
                label: "Total User",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: [40, 50, 45, 60, 70, 65, 80, 85, 90, 98, 102, 105], // Data berakhir di 105 sesuai stat
            }],
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false, drawBorder: false } },
                y: { ticks: { maxTicksLimit: 5, padding: 10 }, grid: { color: "rgb(234, 236, 244)", drawBorder: false } }
            }
        }
    });

    // Data Donut (Distribusi 105 User ke dalam 4 Roles)
    const ctxPie = document.getElementById('rolesPieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ["Mahasiswa", "Admin", "Reviewer", "Staff"],
            datasets: [{
                data: [90, 5, 5, 5], // Total 105
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#dda20a'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            cutout: '80%',
            plugins: { legend: { display: false } }
        }
    });
</script>