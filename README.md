# Sistem Manajemen Inventaris DFC Cirebon (UTS PBO)

Aplikasi web CRUD berbasis **Laravel 13** yang mengadaptasi entitas **Inventaris** (gabungan konsep `StokGudang` dan `Lokasi`) dari proyek Capstone **Aplikasi Manajemen Restoran DFC Cirebon**. Seluruh data inventaris disimpan pada **Session (`SESSION_DRIVER=file`)** tanpa menggunakan koneksi database maupun Eloquent.

## Ringkasan Arsitektur

- **Pola**: `Route -> Controller -> Blade`
- **Routing (`routes/web.php`)**:
  - `GET /inventaris` (`inventaris.index`) &rarr; `InventarisController@index`
  - `GET /inventaris/create` (`inventaris.create`) &rarr; `InventarisController@create`
  - `POST /inventaris` (`inventaris.store`) &rarr; `InventarisController@store`
  - `GET /inventaris/{kode}` (`inventaris.show`) &rarr; `InventarisController@show`
  - `GET /inventaris/{kode}/edit` (`inventaris.edit`) &rarr; `InventarisController@edit`
  - `PUT|PATCH /inventaris/{kode}` (`inventaris.update`) &rarr; `InventarisController@update`
  - `DELETE /inventaris/{kode}` (`inventaris.destroy`) &rarr; `InventarisController@destroy`
- **Controller (`app/Http/Controllers/InventarisController.php`)**: Memisahkan logika CRUD ke 7 method utama (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`) dengan penyimpanan berbasis session file.
- **Blade Views (`resources/views/`)**:
  - `layouts/app.blade.php` (layout utama: judul, navigasi, `@yield('content')`, footer)
  - `inventaris/index.blade.php` (daftar tabel, notifikasi status, pesan kosong, tombol Detail/Edit/Hapus)
  - `inventaris/create.blade.php` (form tambah data)
  - `inventaris/edit.blade.php` (form edit dengan nilai lama dan `@method('PUT')`)
  - `inventaris/show.blade.php` (detail lengkap satu item inventaris)

## Langkah Menjalankan Proyek Secara Lokal

1. Pastikan **PHP 8.3+** dan **Composer** sudah terpasang.
2. Masuk ke direktori proyek dan instal dependensi:
   ```bash
   composer install
   ```
3. Salin file konfigurasi `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Pastikan pada `.env` sudah tertulis:
   ```env
   SESSION_DRIVER=file
   ```
4. Buat application key Laravel:
   ```bash
   php artisan key:generate
   ```
5. Pastikan folder `storage/framework/sessions` tersedia dan dapat ditulisi.
6. Verifikasi daftar route:
   ```bash
   php artisan route:list
   ```
7. Jalankan server pengembangan lokal:
   ```bash
   php artisan serve
   ```
8. Buka browser dan akses `http://127.0.0.1:8000/inventaris`.

## Dokumentasi Screenshot

### 1. Daftar Route (`php artisan route:list`)
![Terminal php artisan route:list](Screenshoots/Terminal%20php%20artisan%20routelist.png)

### 2. Daftar Inventaris Saat Kosong
![Daftar Inventaris Kosong](Screenshoots/Daftar%20Inventaris%20Kosong.png)

### 3. Form Tambah Inventaris
![Form Tambah Inventaris](Screenshoots/Form%20Tambah%20Inventaris.png)

### 4. Daftar Inventaris Terisi & Notifikasi Sukses
![Daftar Inventaris Terisi dan Notifikasi Sukses](Screenshoots/Daftar%20Inventaris%20Terisi%20+%20Notifikasi%20Sukses.png)

### 5. Halaman Detail Inventaris
![Halaman Detail Inventaris](Screenshoots/Halaman%20Detail%20Inventaris.png)

### 6. Halaman Edit Inventaris
![Edit Inventaris](Screenshoots/Edit%20Inventaris.png)

### 7. Hasil Setelah Update Data Inventaris
![Hasil Setelah Update](Screenshoots/Update%20In.png)

### 8. Penanganan Data Inventaris Tidak Ditemukan
![Data Inventaris Tidak Ditemukan](Screenshoots/Hasil%20Setelah%20Update.png)

### 9. Dialog Konfirmasi Hapus
![Dialog Konfirmasi Hapus](Screenshoots/Dialog%20Konfirmasi%20Hapus.png)

### 10. Hasil Setelah Dihapus
![Hasil Setelah Dihapus](Screenshoots/Hasil%20Setelah%20Dihapus.png)

