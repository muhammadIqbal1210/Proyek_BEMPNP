<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BeasiswaModel;
use App\Models\BeritaModel;
use App\Models\EventModel;
use App\Models\KatalogModel;
use App\Models\LaporanModel;
use App\Models\LombaModel;
use App\Models\PengumumanModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title'   => 'Dashboard Admin',
            'halaman' => 'Dashboard Admin',
            'content' => 'admin/dashboard',

            'totals' => [
                'users'      => (new UserModel())->countAllResults(),
                'beasiswa'   => (new BeasiswaModel())->where('status_pengajuan', 'approved')->countAllResults(),
                'lomba'      => (new LombaModel())->where('status_pengajuan', 'approved')->countAllResults(),
                'event'      => (new EventModel())->where('status_pengajuan', 'approved')->countAllResults(),
                'berita'     => (new BeritaModel())->where('status_pengajuan', 'approved')->countAllResults(),
                'katalog'    => (new KatalogModel())->where('status_pengajuan', 'approved')->countAllResults(),
                'laporan'    => (new LaporanModel())->countAllResults(),
                'pengumuman' => (new PengumumanModel())->countAllResults(),
            ],

            'pending' => [
                'beasiswa' => (new BeasiswaModel())->where('status_pengajuan', 'pending')->countAllResults(),
                'lomba'    => (new LombaModel())->where('status_pengajuan', 'pending')->countAllResults(),
                'event'    => (new EventModel())->where('status_pengajuan', 'pending')->countAllResults(),
                'berita'   => (new BeritaModel())->where('status_pengajuan', 'pending')->countAllResults(),
                'katalog'  => (new KatalogModel())->where('status_pengajuan', 'pending')->countAllResults(),
            ],

            'active' => [
                'beasiswa'   => (new BeasiswaModel())
                    ->groupStart()
                        ->where('status_beasiswa', 'buka')
                        ->orWhere('status_beasiswa', 'Buka')
                    ->groupEnd()
                    ->where('status_pengajuan', 'approved')
                    ->countAllResults(),
                'pengumuman' => (new PengumumanModel())->where('status', 'aktif')->countAllResults(),
            ],

            'recent' => [
                'beasiswa' => (new BeasiswaModel())->orderBy('created_at', 'DESC')->limit(4)->findAll(),
                'lomba'    => (new LombaModel())->orderBy('created_at', 'DESC')->limit(4)->findAll(),
                'event'    => (new EventModel())->orderBy('created_at', 'DESC')->limit(4)->findAll(),
                'berita'   => (new BeritaModel())->orderBy('created_at', 'DESC')->limit(4)->findAll(),
                'laporan'  => (new LaporanModel())->orderBy('created_at', 'DESC')->limit(4)->findAll(),
            ],
        ];

        $data['pending_total'] = array_sum($data['pending']);
        $contentTotal = max(1, ($data['totals']['beasiswa'] ?? 0) + ($data['totals']['lomba'] ?? 0) + ($data['totals']['event'] ?? 0) + ($data['totals']['berita'] ?? 0) + ($data['totals']['katalog'] ?? 0));
        $data['content_chart'] = [
            ['label' => 'Beasiswa', 'value' => $data['totals']['beasiswa'] ?? 0, 'percent' => round((($data['totals']['beasiswa'] ?? 0) / $contentTotal) * 100), 'color' => '#16a34a'],
            ['label' => 'Lomba', 'value' => $data['totals']['lomba'] ?? 0, 'percent' => round((($data['totals']['lomba'] ?? 0) / $contentTotal) * 100), 'color' => '#f59e0b'],
            ['label' => 'Event', 'value' => $data['totals']['event'] ?? 0, 'percent' => round((($data['totals']['event'] ?? 0) / $contentTotal) * 100), 'color' => '#2563eb'],
            ['label' => 'Berita', 'value' => $data['totals']['berita'] ?? 0, 'percent' => round((($data['totals']['berita'] ?? 0) / $contentTotal) * 100), 'color' => '#dc2626'],
            ['label' => 'Katalog', 'value' => $data['totals']['katalog'] ?? 0, 'percent' => round((($data['totals']['katalog'] ?? 0) / $contentTotal) * 100), 'color' => '#7c3aed'],
        ];
        $pendingSafeTotal = max(1, $data['pending_total']);
        $data['approval_chart'] = [
            'approved' => max(0, 100 - min(100, round(($data['pending_total'] / ($contentTotal + $data['pending_total'])) * 100))),
            'pending' => min(100, round(($data['pending_total'] / ($contentTotal + $data['pending_total'])) * 100)),
            'pending_breakdown' => array_map(static fn ($value) => round(($value / $pendingSafeTotal) * 100), $data['pending']),
        ];

        return view('template/wrapper', $data);
    }
}
