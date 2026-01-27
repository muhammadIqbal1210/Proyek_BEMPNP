<?php namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\BeasiswaModel;
use App\Models\PengurusModel;
use App\Models\LaporanModel;
use App\Models\EventModel;
use App\Models\BeritaModel;
use App\Models\KontakModel;
use App\Models\LombaModel;
use App\Models\PengumumanModel;
use App\Models\KatalogModel;

class Dashboard extends Controller
{
    public function index()
    {
        $data['title'] = 'Dashboard Admin';

        // Load all models
        $userModel = new UserModel();
        $beasiswaModel = new BeasiswaModel();
        $pengurusModel = new PengurusModel();
        $laporanModel = new LaporanModel();
        $eventModel = new EventModel();
        $beritaModel = new BeritaModel();
        $kontakModel = new KontakModel();
        $lombaModel = new LombaModel();
        $pengumumanModel = new PengumumanModel();
        $katalogModel = new KatalogModel();

        // Fetch comprehensive data
        $data['total_users'] = $userModel->countAll();
        $data['total_beasiswas'] = $beasiswaModel->countAll();
        $data['total_beritas'] = $beritaModel->countAll();
        $data['total_events'] = $eventModel->countAll();
        $data['total_laporans'] = $laporanModel->countAll();
        $data['total_lombas'] = $lombaModel->countAll();
        $data['total_pengumumans'] = $pengumumanModel->countAll();
        $data['total_katalogs'] = $katalogModel->countAll();
        $data['total_kontaks'] = $kontakModel->countAll();

        // Role distribution - optimized to avoid loading all data into memory
        $db = \Config\Database::connect();
        $roleQuery = $db->query("SELECT role, COUNT(*) as count FROM users GROUP BY role");
        $roleResults = $roleQuery->getResultArray();

        $data['role_distribution'] = [
            'superadmin' => 0,
            'admin' => 0,
            'member' => 0,
        ];

        foreach ($roleResults as $row) {
            if (isset($data['role_distribution'][$row['role']])) {
                $data['role_distribution'][$row['role']] = (int)$row['count'];
            }
        }

        // Monthly data for charts - actual data from database
        $data['user_growth'] = $this->getMonthlyGrowth('users');
        $data['beasiswa_growth'] = $this->getMonthlyGrowth('beasiswas');
        $data['berita_growth'] = $this->getMonthlyGrowth('berita');

        // Recent activities
        $data['recent_beasiswas'] = $beasiswaModel->orderBy('created_at', 'DESC')->limit(5)->find();
        $data['recent_beritas'] = $beritaModel->orderBy('created_at', 'DESC')->limit(5)->find();
        $data['recent_events'] = $eventModel->orderBy('created_at', 'DESC')->limit(5)->find();
        $data['recent_laporans'] = $laporanModel->orderBy('created_at', 'DESC')->limit(5)->find();
        $data['recent_pengumumans'] = $pengumumanModel->orderBy('created_at', 'DESC')->limit(5)->find();
        $data['recent_lombas'] = $lombaModel->orderBy('created_at', 'DESC')->limit(5)->find();
        $data['recent_katalogs'] = $katalogModel->orderBy('created_at', 'DESC')->limit(5)->find();

        // Active items
        $data['active_beasiswas'] = $beasiswaModel->where('status_beasiswa', 'buka')->countAllResults();
        $data['active_lombas'] = $lombaModel->where('status_lomba', 'aktif')->countAllResults();
        $data['active_pengumumans'] = $pengumumanModel->where('status', 'aktif')->countAllResults();

        // Gunakan helper 'view' atau fungsi view() bawaan CI4
        echo view('template/header', $data);
        echo view('admin/dashboard', $data);
        echo view('template/footer', $data);
    }

    /**
     * Get monthly growth data for the past 12 months - optimized single query
     */
    private function getMonthlyGrowth($table)
    {
        $db = \Config\Database::connect();

        // Calculate date range for past 12 months
        $endDate = date('Y-m-d H:i:s');
        $startDate = date('Y-m-d H:i:s', strtotime('-12 months'));

        // Single optimized query to get all monthly counts
        $query = $db->query("
            SELECT
                YEAR(created_at) as year,
                MONTH(created_at) as month,
                COUNT(*) as count
            FROM $table
            WHERE created_at >= '$startDate' AND created_at <= '$endDate'
            GROUP BY YEAR(created_at), MONTH(created_at)
            ORDER BY YEAR(created_at), MONTH(created_at)
        ");

        $results = $query->getResultArray();

        // Initialize array with zeros for all 12 months
        $growth = array_fill(0, 12, 0);

        // Map results to the correct month positions
        foreach ($results as $result) {
            $yearMonth = sprintf('%04d-%02d', $result['year'], $result['month']);
            $monthsAgo = $this->monthsDifference($yearMonth);

            if ($monthsAgo >= 0 && $monthsAgo < 12) {
                $growth[11 - $monthsAgo] = (int)$result['count'];
            }
        }

        return $growth;
    }

    /**
     * Get monthly growth data for the past 12 months by status - optimized single query
     */
    private function getMonthlyGrowthByStatus($table, $statusColumn, $statusValue)
    {
        $db = \Config\Database::connect();

        // Calculate date range for past 12 months
        $endDate = date('Y-m-d H:i:s');
        $startDate = date('Y-m-d H:i:s', strtotime('-12 months'));

        // Single optimized query to get all monthly counts by status
        $query = $db->query("
            SELECT
                YEAR(created_at) as year,
                MONTH(created_at) as month,
                COUNT(*) as count
            FROM $table
            WHERE created_at >= '$startDate' AND created_at <= '$endDate' AND $statusColumn = '$statusValue'
            GROUP BY YEAR(created_at), MONTH(created_at)
            ORDER BY YEAR(created_at), MONTH(created_at)
        ");

        $results = $query->getResultArray();

        // Initialize array with zeros for all 12 months
        $growth = array_fill(0, 12, 0);

        // Map results to the correct month positions
        foreach ($results as $result) {
            $yearMonth = sprintf('%04d-%02d', $result['year'], $result['month']);
            $monthsAgo = $this->monthsDifference($yearMonth);

            if ($monthsAgo >= 0 && $monthsAgo < 12) {
                $growth[11 - $monthsAgo] = (int)$result['count'];
            }
        }

        return $growth;
    }

    /**
     * Calculate months difference from current date
     */
    private function monthsDifference($yearMonth)
    {
        $current = date('Y-m');
        $target = $yearMonth;

        $currentYear = (int)date('Y');
        $currentMonth = (int)date('m');
        $targetYear = (int)substr($target, 0, 4);
        $targetMonth = (int)substr($target, 5, 2);

        return ($currentYear - $targetYear) * 12 + ($currentMonth - $targetMonth);
    }
}
