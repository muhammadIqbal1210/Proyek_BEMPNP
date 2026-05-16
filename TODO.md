# TODO: Implementasi Sistem Pengajuan Beasiswa

## Langkah-langkah Implementasi:

### 1. Buat Migrasi untuk Tabel Pengajuan Beasiswa
- [ ] Buat file migrasi baru untuk tabel `pengajuan_beasiswa`
- [ ] Jalankan migrasi untuk membuat tabel

### 2. Buat Model PengajuanBeasiswaModel
- [ ] Buat model dengan relasi ke UserModel dan BeasiswaModel
- [ ] Tambahkan validation rules

### 3. Update Admin Beasiswa Controller
- [ ] Tambahkan method pengajuan() untuk daftar pengajuan
- [ ] Tambahkan method approve() dan reject() untuk approval
- [ ] Update routes untuk admin pengajuan

### 4. Buat Member Beasiswa Controller
- [ ] Buat controller baru untuk member
- [ ] Tambahkan method index() untuk daftar pengajuan member
- [ ] Tambahkan method apply() untuk mengajukan beasiswa
- [ ] Update routes untuk member beasiswa

### 5. Buat Views untuk Admin Pengajuan
- [ ] Buat view admin/beasiswa/pengajuan.php
- [ ] Tambahkan modal untuk approve/reject

### 6. Buat Views untuk Member
- [ ] Buat view member/beasiswa/index.php (daftar pengajuan)
- [ ] Buat view member/beasiswa/apply.php (form pengajuan)
- [ ] Update sidebar jika diperlukan

### 7. Update Routes
- [ ] Tambahkan routes untuk admin pengajuan
- [ ] Tambahkan routes untuk member beasiswa

### 8. Testing
- [ ] Test flow pengajuan dari member
- [ ] Test approval dari admin
- [ ] Test status update
