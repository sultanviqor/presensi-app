# presensi-app

## Overview
Laravel 10 app ini mengimplementasikan beberapa fitur seperti autentikasi, mengatur absen & izin pegawai, pelacakan kehadiran, dan waktu countdown.

## Fitur

### Login
- Tidak bisa akses ke halaman berauth ketika blm login dan vice versa.

### Absen
- Hanya bisa absen masuk & pulang sesuai koordinat yg ditentukan (lokasi kantor).
- Hanya bisa absen pulang sesuai waktu yang ditentukan (mengikuti jam kerja).
- Setiap hari pukul 23:00 Asia/Jakarta otomatis menambahkan absen jenis tidak masuk dengan user yang blm absen dihari tersebut.
- Tidak bisa duplikat absen dihari yg sama.

### Izin
- Otomoatis menambahkan izin & absen jenis izin sesuai dengan rentang waktu yang ditentukan.
- Tidak bisa duplikat izin dihari yg sama.

### Waktu Countdown
- Menghitur mundur dari absen masuk sampai dengan jam kerja selesai.

## Notes
- Mengubah lokasi kantor ada di UserController line 80 & 119.
- Mengubah jam kerja ada di Usercontroller line 100.