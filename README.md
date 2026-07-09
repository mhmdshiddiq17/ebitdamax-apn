# EBITDA Max APN

## Impor Data Koperasi (Data SDM)

Tabel `sdm_kdkmp_entries` (digunakan oleh halaman `/monitoring` dan `/sdm-data`) diisi dari berkas ekspor "Laporan Koperasi" data pembangunan (`Export_Laporan_Koperasi_*.xlsx`), bukan diketik manual. NIK koperasi digunakan sebagai identifier unik.

### Menjalankan Impor (Lokal)

```bash
php artisan import:koperasi-karyawan /path/ke/Export_Laporan_Koperasi_*.xlsx
```

- Perintah ini melakukan **upsert** berdasarkan `nik`, sehingga aman dijalankan berulang kali untuk memperbarui data referensi (nama, provinsi, kabupaten/kota, kecamatan, kodam/korem/kodim, batch).
- Kolom `jumlah_karyawan` yang sudah diisi oleh tim HC **tidak akan pernah tertimpa**; hanya kolom referensi wilayah yang diperbarui.
- Kolom provinsi tidak tersedia pada berkas ekspor asli, sehingga nilainya diresolusi otomatis dari pemetaan `database/data/wilayah-kabupaten-kota.json` dan `database/data/wilayah-provinsi.json`.

### Menjalankan Impor ke Production (Laravel Cloud)

Untuk menjalankan impor langsung ke database production dari mesin lokal (bukan melalui SSH/tinker di server):

1. Ambil connection string PostgreSQL dari Laravel Cloud dashboard (Database → Connection details).
2. Simpan salinan isi `.env` lokal terlebih dahulu (atau catat nilai default `DB_CONNECTION=sqlite`) sebelum diganti.
3. Ganti sementara konfigurasi berikut di `.env` lokal:
   ```
   DB_CONNECTION=pgsql
   DB_HOST=<host dari Laravel Cloud>
   DB_PORT=5432
   DB_DATABASE=<nama database>
   DB_USERNAME=<user>
   DB_PASSWORD=<password>
   ```
4. Pastikan ekstensi `pdo_pgsql` PHP sudah terpasang secara lokal (`sudo apt install php8.3-pgsql` di Ubuntu) apabila belum ada.
5. Jalankan `php artisan config:clear` untuk memastikan cache konfigurasi lama tidak masih mengarah ke koneksi sebelumnya.
6. Jalankan migrasi (apabila ada migrasi baru) dan impor:
   ```bash
   php artisan migrate --force
   php artisan import:koperasi-karyawan /path/ke/Export_Laporan_Koperasi_*.xlsx
   ```
7. **Wajib mengembalikan `.env` ke `DB_CONNECTION=sqlite`** (dan menjalankan `php artisan config:clear` kembali) setelah selesai, agar pekerjaan lokal berikutnya tidak keliru mengarah ke database production.

**Jangan pernah mencantumkan kredensial database production ke dalam `.env.example` atau berkas yang di-tracking git.** Berkas `.env` sendiri sudah di-gitignore, namun tetap perlu berhati-hati saat menyalin kredensial ke tempat lain.
