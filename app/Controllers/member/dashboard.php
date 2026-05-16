<?php namespace App\Controllers\Member;

use App\Controllers\BaseController;
use App\Models\BeasiswaModel;
use App\Models\BeritaModel;
use App\Models\EventModel;
use App\Models\KatalogModel;
use App\Models\LombaModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        $categories = [
            'beasiswa' => [
                'label' => 'Beasiswa',
                'model' => BeasiswaModel::class,
                'title_field' => 'nama_beasiswa',
                'create_url' => 'member/beasiswa/create',
                'index_url' => 'member/beasiswa',
            ],
            'lomba' => [
                'label' => 'Lomba',
                'model' => LombaModel::class,
                'title_field' => 'nama_lomba',
                'create_url' => 'member/lomba/create',
                'index_url' => 'member/lomba',
            ],
            'event' => [
                'label' => 'Event',
                'model' => EventModel::class,
                'title_field' => 'nama_event',
                'create_url' => 'member/event/create',
                'index_url' => 'member/event',
            ],
            'berita' => [
                'label' => 'Berita',
                'model' => BeritaModel::class,
                'title_field' => 'judulberita',
                'create_url' => 'member/berita/create',
                'index_url' => 'member/berita',
            ],
            'katalog' => [
                'label' => 'Katalog',
                'model' => KatalogModel::class,
                'title_field' => 'nama_barang',
                'create_url' => 'member/katalog/create',
                'index_url' => 'member/katalog',
            ],
        ];

        $summary = [];
        $recent = [];

        foreach ($categories as $key => $category) {
            $modelClass = $category['model'];

            $summary[$key] = [
                'label' => $category['label'],
                'pending' => (new $modelClass())->where('user_id', $userId)->where('status_pengajuan', 'pending')->countAllResults(),
                'approved' => (new $modelClass())->where('user_id', $userId)->where('status_pengajuan', 'approved')->countAllResults(),
                'rejected' => (new $modelClass())->where('user_id', $userId)->where('status_pengajuan', 'rejected')->countAllResults(),
                'create_url' => $category['create_url'],
                'index_url' => $category['index_url'],
            ];

            $items = (new $modelClass())
                ->where('user_id', $userId)
                ->orderBy('created_at', 'DESC')
                ->limit(3)
                ->findAll();

            foreach ($items as $item) {
                $recent[] = [
                    'type' => $category['label'],
                    'title' => $item[$category['title_field']] ?? 'Tanpa judul',
                    'status' => $item['status_pengajuan'] ?? 'pending',
                    'created_at' => $item['created_at'] ?? null,
                    'url' => $category['index_url'],
                ];
            }
        }

        usort($recent, static function ($a, $b) {
            return strtotime($b['created_at'] ?? '1970-01-01') <=> strtotime($a['created_at'] ?? '1970-01-01');
        });

        $data = [
            'title'   => 'Dashboard Member',
            'halaman' => 'Dashboard Member',
            'content' => 'member/dashboard',
            'summary' => $summary,
            'recent'  => array_slice($recent, 0, 8),
        ];

        return view('template/wrapper', $data);
    }
}
