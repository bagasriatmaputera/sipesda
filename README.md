📘 SIPESDA

Sistem Informasi Pelanggaran Siswa Da’il Khairaat

<img width="1373" height="734" alt="image" src="https://github.com/user-attachments/assets/5b74e3ff-5b7f-43c1-8d7f-58580885270f" />


📌 Deskripsi Proyek

SIPESDA adalah aplikasi berbasis web yang digunakan untuk mencatat, memantau, dan melaporkan pelanggaran siswa secara terpusat, serta mengirimkan notifikasi otomatis kepada orang tua melalui WhatsApp.

Aplikasi ini dirancang untuk meningkatkan pengawasan, transparansi, dan komunikasi antara pihak sekolah dan orang tua siswa.

🎯 Tujuan

Mencatat pelanggaran siswa secara cepat dan terstruktur

Memberikan notifikasi real-time ke orang tua siswa

Mengurangi pelanggaran berulang

Membantu guru dalam monitoring perilaku siswa

Menyediakan laporan pelanggaran yang akurat

👥 Pengguna Sistem

Admin Sekolah

Guru BK

Guru Piket

Orang Tua (sebagai penerima notifikasi WhatsApp)

⚙️ Fitur Utama
1. Manajemen Data

Data Siswa

Data Orang Tua (Nomor WhatsApp)

Data Guru

Jenis Pelanggaran & Poin

2. Pencatatan Pelanggaran

Input pelanggaran oleh Guru BK / Guru Piket

Perhitungan poin otomatis

Riwayat pelanggaran siswa

3. Notifikasi WhatsApp

Pengiriman pesan otomatis ke orang tua

Template pesan dapat dikustomisasi

Mendukung WhatsApp Gateway / API

4. Rekap & Laporan

Laporan per siswa

Laporan bulanan

Export PDF & Excel

5. Sistem Peringatan

Notifikasi jika poin melewati batas

Rekomendasi tindakan (pemanggilan orang tua, skorsing, dll)

🏗️ Arsitektur Sistem

Aplikasi ini menggunakan Service & Repository Pattern:

Controller
   ↓
Service (Business Logic)
   ↓
Repository (Query Database)
   ↓
Model (Eloquent ORM)

🧱 Teknologi yang Digunakan

Laravel 10+

MySQL / MariaDB

REST API

WhatsApp Gateway (Fonnte / Wablas / WA Cloud API)

Bootstrap / Tailwind (UI)

🗂️ Struktur Folder (Ringkas)
app/
 ├── Models/
 ├── Repository/
 ├── Services/
 ├── Http/Controllers/
database/
 ├── migrations/
routes/
 ├── api.php

📄 Database Schema (Tabel Utama)

users (default Laravel)

siswa

orang_tua

jenis_pelanggaran

pelanggaran

batas_poin

template_pesan

notifikasi_wa

📨 Contoh Template Pesan WhatsApp
Yth. Bapak/Ibu Orang Tua Ananda {{nama_siswa}}
Kami informasikan bahwa pada hari {{tanggal}},
Ananda melakukan pelanggaran:

{{jenis_pelanggaran}}
Poin Pelanggaran : {{poin}}
Total Poin Saat Ini : {{total_poin}}

Mohon perhatian dan kerja samanya.
Hormat kami,
{{nama_sekolah}}

🚀 Instalasi (Sementara)
git clone https://github.com/username/sipesda.git
cd sipesda
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

🔐 Role User
Role	Akses
Admin	Full akses
Guru BK	Input & monitoring
Guru Piket	Input pelanggaran
📌 Status Proyek

🟡 Development (On Going)

 WhatsApp Gateway


📚 Catatan

Dokumentasi ini bersifat sementara dan akan diperbarui seiring perkembangan proyek.
