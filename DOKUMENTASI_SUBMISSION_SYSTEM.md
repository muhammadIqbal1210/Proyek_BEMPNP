# DOKUMENTASI SISTEM SUBMISSION & APPROVAL

## Ringkasan Sistem
Sistem ini memungkinkan member untuk mengajukan konten (Beasiswa, Lomba, Event, Berita, dan Katalog) yang akan di-review oleh admin. Konten hanya akan tampil di halaman publik setelah disetujui oleh admin.

## Alur Kerja

### 1. MEMBER - Mengajukan Konten
**Langkah-langkah:**
1. Login dengan akun member
2. Akses menu sesuai tipe konten:
   - Member > Beasiswa
   - Member > Lomba
   - Member > Event
   - Member > Berita
   - Member > Katalog
3. Klik tombol "Ajukan [Konten] Baru"
4. Isi form dengan data yang diperlukan
5. Upload file/gambar jika diperlukan
6. Klik "Ajukan [Konten]"

**Status Pengajuan:**
- **Pending**: Menunggu persetujuan admin (masih bisa diedit/dihapus)
- **Approved**: Sudah disetujui dan akan tampil di halaman publik
- **Rejected**: Ditolak oleh admin (tidak bisa diedit, tapi bisa dihapus)

### 2. ADMIN - Mereview & Menyetujui Konten
**Akses Review Page:**
- Admin > Beasiswa > Pengajuan
- Admin > Lomba > Pengajuan  
- Admin > Event > Pengajuan
- Admin > Berita > Pengajuan
- Admin > Katalog > Pengajuan

**Opsi Aksi:**
- **Setujui**: Konten akan tampil di halaman publik
- **Tolak**: Konten tidak akan ditampilkan

### 3. PUBLIC - Melihat Konten yang Disetujui
Konten yang sudah disetujui akan tampil di:
- Halaman publik Beasiswa
- Halaman publik Lomba
- Halaman publik Event
- Halaman publik Berita
- Halaman publik Katalog

---

## FILE-FILE YANG DIBUAT/DIUBAH

### Database Migrations
```
app/Database/Migrations/2026-01-28-120000_AddStatusPengajuanAndUserIdToLombas.php
app/Database/Migrations/2026-01-28-120001_AddStatusPengajuanAndUserIdToEvents.php
app/Database/Migrations/2026-01-28-120002_AddStatusPengajuanAndUserIdToBerita.php
app/Database/Migrations/2026-01-28-120003_AddStatusPengajuanAndUserIdToKatalog.php
```

### Models (Updated)
```
app/Models/LombaModel.php (Added: status_pengajuan, user_id)
app/Models/EventModel.php (Added: status_pengajuan, user_id)
app/Models/BeritaModel.php (Added: status_pengajuan, user_id)
app/Models/KatalogModel.php (Added: status_pengajuan, user_id)
```

### Controllers - Member
```
app/Controllers/Member/Lomba.php (New)
app/Controllers/Member/Event.php (New)
app/Controllers/Member/Berita.php (New)
app/Controllers/Member/Katalog.php (New)
```

### Controllers - Admin (Updated dengan metode: pengajuan, approve, reject)
```
app/Controllers/Admin/Lomba.php
app/Controllers/Admin/Event.php
app/Controllers/Admin/Berita.php
app/Controllers/Admin/Katalog.php
```

### Routes (Updated)
```
app/Config/Routes.php
- Member routes: /member/lomba, /member/event, /member/berita, /member/katalog
- Admin routes: /admin/[konten]/pengajuan, /admin/[konten]/approve/{id}, /admin/[konten]/reject/{id}
```

### Views - Member
```
app/Views/member/lomba/create.php
app/Views/member/lomba/index.php
app/Views/member/lomba/edit.php

app/Views/member/event/create.php
app/Views/member/event/index.php
app/Views/member/event/edit.php

app/Views/member/berita/create.php
app/Views/member/berita/index.php
app/Views/member/berita/edit.php

app/Views/member/katalog/create.php
app/Views/member/katalog/index.php
app/Views/member/katalog/edit.php
```

### Views - Admin
```
app/Views/admin/lomba/pengajuan.php
app/Views/admin/event/pengajuan.php
app/Views/admin/berita/pengajuan.php
app/Views/admin/katalog/pengajuan.php
```

---

## LANGKAH IMPLEMENTASI

### 1. Jalankan Migrations
```bash
php spark migrate
```

### 2. Pastikan Folder Upload Ada
Buat folder-folder berikut di `/public/uploads/`:
```
uploads/
├── beasiswa/
├── lomba/
├── event/
├── berita/
└── katalog/
```

### 3. Update Navigation Menu (Optional)
Jika ingin menambahkan link ke menu, update file template Anda untuk menambahkan:
```
Member: Beasiswa, Lomba, Event, Berita, Katalog
Admin: Beasiswa, Lomba, Event, Berita, Katalog (dengan sub-menu "Pengajuan")
```

---

## FIELD DATABASE

### Semua Tabel (Beasiswa, Lomba, Events, Berita, Katalog)
Ditambahkan 2 field baru:

| Field | Type | Description |
|-------|------|-------------|
| `status_pengajuan` | ENUM('pending', 'approved', 'rejected') | Status approval konten |
| `user_id` | INT (unsigned, nullable) | ID user yang mengajukan |

---

## VALIDASI INPUT

### Beasiswa
- Nama: Required, Max 255 karakter
- Deskripsi: Required
- Tanggal Buka: Required, Format date
- Tanggal Tutup: Required, Format date
- Link Informasi: Required, Valid URL
- Poster: Optional, Max 2MB, Image file

### Lomba
- Nama: Required, Max 255 karakter
- Kategori: Required, Max 255 karakter
- Deskripsi: Required
- Link Informasi: Required, Valid URL
- Poster: Required, Max 2MB, Image file

### Event
- Nama: Required, Max 255 karakter
- Deskripsi: Required
- Link Informasi: Required, Valid URL
- Waktu: Required, Format date
- Biaya: gratis/berbayar
- File: Optional, Max 5MB

### Berita
- Judul: Required, Min 5 karakter, Max 255 karakter
- Isi: Required
- Tanggal: Required, Format date
- Gambar: Required, Max 2MB, Image file

### Katalog
- Nama Barang: Required, Min 3 karakter, Max 255 karakter
- Deskripsi: Required
- Harga: Required, Numeric
- Link Jual: Required, Valid URL
- Foto: Required, Max 2MB, Image file

---

## KONTROL AKSES

### Member
- Hanya bisa lihat pengajuan milik sendiri
- Hanya bisa edit pengajuan dengan status "pending"
- Bisa hapus pengajuan dengan status "pending" atau "rejected"

### Admin
- Lihat semua pengajuan
- Approve atau Reject sesuai kebutuhan
- Kelola konten yang sudah approved di menu utama

### Public
- Hanya lihat konten dengan status "approved"

---

## TROUBLESHOOTING

### 1. Form tidak masuk database
- Cek apakah database sudah dimigrasi: `php spark migrate`
- Cek permission folder uploads
- Cek error logs di `writable/logs/`

### 2. File tidak ter-upload
- Pastikan folder `/public/uploads/[tipe-konten]/` sudah ada dan writable
- Cek ukuran file (max 2MB untuk image, 5MB untuk file)
- Cek format file yang diupload

### 3. Halaman tidak muncul
- Clear browser cache atau akses dengan incognito mode
- Cek Routes sudah benar di `app/Config/Routes.php`
- Cek error logs untuk detail error

---

## FITUR TAMBAHAN YANG BISA DIKEMBANGKAN

1. **Notification**: Notifikasi ke member saat pengajuan diapprove/reject
2. **Comment**: Admin bisa memberikan feedback ke member saat reject
3. **Batch Approval**: Approve multiple submissions sekaligus
4. **Export**: Export data pengajuan ke Excel
5. **Revision Request**: Admin bisa minta revisi dari member
6. **Scheduled Publishing**: Set waktu publikasi otomatis untuk konten

---

**Status**: Implementasi Selesai ✓
**Tanggal**: 16 Mei 2026
**Versi**: 1.0
