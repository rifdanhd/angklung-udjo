# Workflow Pengembangan Website Saung Angklung Udjo

Dokumen ini menjelaskan alur kerja standar untuk pengembangan, pengujian, dan deploy website Saung Angklung Udjo.

## 1. Perencanaan & Analisis

- Kumpulkan kebutuhan bisnis dan fitur utama.
- Tentukan prioritas fitur: booking tiket, promo, produk, galeri, artikel, testimoni, kemitraan, admin panel.
- Review kondisi saat ini dalam repository: backend Laravel, frontend Blade/Tailwind, database MySQL.
- Buat user story dan dokumentasi singkat untuk setiap fitur.

## 2. Desain & Arsitektur

- Rancang struktur database untuk entitas utama: Booking, Product, Article, Gallery, Promo, Partnership, Testimoni.
- Tentukan routing dan area akses: frontend, auth, admin panel.
- Definisikan komponen UI utama di Blade: home, booking, produk, promo, galeri, artikel, kontak.
- Pastikan arsitektur mendukung multi-bahasa dan SEO.

## 3. Pengembangan

- Buat branch fitur baru untuk setiap modul: `feature/booking`, `feature/promo`, `feature/admin`, dsb.
- Implementasikan endpoint backend di `app/Http/Controllers` dan model di `app/Models`.
- Buat Blade views di `resources/views` dan atur style di Tailwind/asset.
- Tambahkan validasi request di `app/Http/Requests` bila diperlukan.
- Kelola asset publik di `public/` dan `resources/js`, `resources/css`.

## 4. Pengujian

- Jalankan unit/feature test di `tests/Unit` dan `tests/Feature`.
- Lakukan pengecekan manual untuk alur booking, formulir partnership, tambah promo, upload galeri.
- Uji responsif di perangkat mobile dan desktop.
- Verifikasi data binding dan regionalisasi bahasa.

## 5. Review & Merge

- Gunakan code review di branch feature.
- Pastikan semua perubahan mengikuti standar Laravel dan struktur repo.
- Lakukan merge ke branch utama setelah review dan test berhasil.

## 6. Deploy & Monitoring

- Persiapkan `.env` konfigurasi di server produksi.
- Jalankan `composer install`, `php artisan migrate`, `php artisan config:cache`, `php artisan route:cache` bila perlu.
- Pastikan permission folder `storage` dan `bootstrap/cache` benar.
- Tambahkan monitoring error dan performa (log, Laravel Telescope, atau error tracker lain).

## 7. Iterasi & Perbaikan

- Kumpulkan feedback pengguna dari admin dan visitor.
- Prioritaskan perbaikan bug, performance, dan usability.
- Susun fitur baru ke dalam roadmap berikut.

## Praktik Pengembangan

- Simpan kode dalam git, gunakan branch kecil dan commit deskriptif.
- Gunakan environment lokal yang mirror produksi sebanyak mungkin.
- Backup database sebelum perubahan migrasi besar.
- Dokumentasikan setiap fitur penting di README atau dokumen internal.

## Contoh Alur Tugas Harian

1. Ambil tugas dari roadmap / issue tracker.
2. Buat branch fitur: `feature/<nama-fitur>`.
3. Kembangkan model, controller, view, validasi.
4. Jalankan `php artisan test` dan cek browser.
5. Commit dan push, ajukan pull request.
6. Review, perbaiki, lalu merge.
7. Deploy ke staging/prod dan verifikasi.
