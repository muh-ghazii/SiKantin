# 🍽️ SiKantin — Sistem Informasi Pemesanan Kantin

> Project Akhir Mata Kuliah Pemrograman Web II  
> Teknologi: Laravel 13, MySQL, Bootstrap 5, GitHub

---

## 👥 Anggota Tim & Role

| Nama | Role | Branch GitHub |
|---|---|---|
| Ghazi | Backend | `backend` |
| Malik | Frontend | `frontend` |
| Andre | Database | `database` |

---

## 📋 Daftar Isi

1. [Fitur Aplikasi](#fitur-aplikasi)
2. [Teknologi yang Digunakan](#teknologi)
3. [Cara Clone & Setup Project](#cara-clone--setup-project)
4. [Struktur Folder](#struktur-folder)
5. [Pembagian Tugas](#pembagian-tugas)
6. [Dokumentasi API](#dokumentasi-api)
7. [Panduan Git & Workflow](#panduan-git--workflow)
8. [Timeline Project](#timeline-project)

---

## ✨ Fitur Aplikasi

### Role Admin
- Login & Logout
- Dashboard statistik (total pesanan, pendapatan, menu terlaris)
- Manajemen Kategori (CRUD)
- Manajemen Menu (CRUD + upload gambar)
- Manajemen Pesanan (lihat semua pesanan, update status)

### Role Pelanggan
- Register & Login
- Lihat daftar menu berdasarkan kategori
- Buat pesanan
- Lihat riwayat pesanan
- Lihat status pesanan

---

## 🛠️ Teknologi

| Layer | Teknologi |
|---|---|
| Backend Framework | Laravel 13 |
| Database | MySQL |
| Frontend CSS | Bootstrap 5 |
| Template Engine | Laravel Blade |
| API Auth | Laravel Sanctum |
| Version Control | Git + GitHub |
| Local Server | XAMPP (Apache + MySQL) |

---

## 🚀 Cara Clone & Setup Project

### Prasyarat — Install dulu di laptop masing-masing:
- [XAMPP](https://www.apachefriends.org/) (Apache + MySQL)
- [Composer](https://getcomposer.org/)
- [Git](https://git-scm.com/)
- [Visual Studio Code](https://code.visualstudio.com/)
- [Laravel Herd](https://herd.laravel.com/) *(opsional, tapi disarankan)*

---

### Langkah 1 — Clone Repository

Buka terminal dan jalankan:

```bash
cd C:\xampp\htdocs
git clone https://github.com/muh-ghazii/SiKantin.git
cd SiKantin
```

---

### Langkah 2 — Install Dependencies

```bash
composer install
```

Tunggu sampai selesai (butuh beberapa menit tergantung koneksi internet).

---

### Langkah 3 — Setup File Environment

```bash
cp .env.example .env
php artisan key:generate
```

Lalu buka file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307          # Sesuaikan dengan port MySQL kamu (cek di XAMPP)
DB_DATABASE=sikantin
DB_USERNAME=root
DB_PASSWORD=          # Kosong jika tidak ada password
```

> ⚠️ **Penting:** Cek port MySQL di XAMPP Control Panel. Kalau tertulis 3307 gunakan 3307, kalau 3306 gunakan 3306.

---

### Langkah 4 — Buat Database

1. Buka XAMPP Control Panel → Start **Apache** dan **MySQL**
2. Buka browser → `http://localhost:8080/phpmyadmin`
3. Klik **Baru** → isi nama database: `sikantin` → pilih collation `utf8mb4_unicode_ci` → klik **Buat**

---

### Langkah 5 — Jalankan Migration & Seeder

```bash
php artisan migrate:fresh --seed
```

Perintah ini akan:
- Membuat semua tabel di database
- Mengisi data awal (user admin, kategori, menu)

---

### Langkah 6 — Jalankan Server

```bash
php artisan serve
```

Buka browser → `http://127.0.0.1:8000`

---

### Akun Default untuk Testing

| Role | Email | Password |
|---|---|---|
| Admin | admin@sikantin.com | password123 |
| Pelanggan | pelanggan@sikantin.com | password123 |

---

## 📁 Struktur Folder

```
SiKantin/
├── app/
│   ├── Http/
│   │   ├── Controllers/          ← [BACKEND] Logic bisnis
│   │   │   ├── AuthController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── MenuController.php
│   │   │   ├── OrderController.php
│   │   │   └── DashboardController.php
│   │   └── Middleware/           ← [BACKEND] Auth & role check
│   │       └── AdminMiddleware.php
│   └── Models/                   ← [BACKEND] Model database
│       ├── User.php
│       ├── Category.php
│       ├── Menu.php
│       ├── Order.php
│       └── OrderItem.php
│
├── database/
│   ├── migrations/               ← [DATABASE] Struktur tabel
│   └── seeders/                  ← [DATABASE] Data awal
│
├── resources/
│   └── views/                    ← [FRONTEND] Tampilan HTML/Blade
│       ├── layouts/              ← Template utama (header, footer, sidebar)
│       ├── auth/                 ← Halaman login & register
│       ├── dashboard/            ← Halaman dashboard admin
│       ├── menu/                 ← Halaman menu (list, tambah, edit)
│       ├── category/             ← Halaman kategori
│       └── orders/               ← Halaman pesanan
│
├── public/
│   ├── css/                      ← [FRONTEND] Custom CSS
│   ├── js/                       ← [FRONTEND] Custom JavaScript
│   └── images/                   ← [FRONTEND] Gambar statis
│
├── routes/
│   ├── api.php                   ← [BACKEND] Route API
│   └── web.php                   ← [BACKEND+FRONTEND] Route web
│
└── .env                          ← Konfigurasi lokal (jangan di-push!)
```

---

## 👨‍💻 Pembagian Tugas

---

### 🔧 BACKEND (Muhammad Ghazi)

**Branch:** `backend`  
**Folder utama:** `app/Http/Controllers/`, `app/Models/`, `routes/`, `database/`

#### ✅ Sudah Selesai:
- [x] Setup Laravel + konfigurasi database
- [x] Migration semua tabel (users, categories, menus, orders, order_items)
- [x] Model + relasi antar tabel
- [x] API Authentication (Register, Login, Logout) dengan Sanctum Token
- [x] API Category (CRUD)
- [x] API Menu (CRUD)
- [x] API Order (Buat, Lihat, Update Status)
- [x] AdminMiddleware (proteksi route khusus admin)
- [x] Seeder (User Admin, Pelanggan, Kategori, Menu)
- [x] API Dashboard (statistik)

#### 📝 Yang Masih Perlu Dikerjakan:
- [x] Upload gambar menu
- [x] API profile user (lihat & edit profil)
- [x] Fix logout (hapus token dari database)
- [x] Filter & search menu berdasarkan nama/kategori
- [x] Pagination untuk daftar menu dan pesanan
- [x] Route web untuk menghubungkan ke views frontend
- [x] Integrasi frontend + backend saat fase merge

#### 📌 Cara Kerja:
```bash
# Selalu update dari main sebelum mulai kerja
git checkout backend
git pull origin backend

# Setelah selesai coding
git add .
git commit -m "feat: deskripsi fitur yang dibuat"
git push origin backend
```

---

### 🎨 FRONTEND (Teman Frontend)

**Branch:** `frontend`  
**Folder utama:** `resources/views/`, `public/css/`, `public/js/`

#### 📝 Semua Yang Harus Dikerjakan:

**1. Setup Layout Utama**
- [x] Buat `resources/views/layouts/app.blade.php` — template utama dengan navbar dan sidebar
- [x] Buat `resources/views/layouts/guest.blade.php` — template untuk halaman login/register
- [x] Install Bootstrap 5 (via CDN di layout)

**2. Halaman Auth**
- [x] `resources/views/auth/login.blade.php` — form login (email + password)
- [x] `resources/views/auth/register.blade.php` — form register (nama + email + password)

**3. Halaman Admin**
- [x] `resources/views/dashboard/index.blade.php` — dashboard statistik (total pesanan, pendapatan, menu terlaris)
- [x] `resources/views/category/index.blade.php` — daftar kategori + tombol tambah/edit/hapus
- [x] `resources/views/category/create.blade.php` — form tambah kategori
- [x] `resources/views/category/edit.blade.php` — form edit kategori
- [x] `resources/views/menu/index.blade.php` — daftar menu dengan gambar + harga
- [x] `resources/views/menu/create.blade.php` — form tambah menu (dengan upload gambar)
- [x] `resources/views/menu/edit.blade.php` — form edit menu
- [x] `resources/views/orders/index.blade.php` — daftar semua pesanan (admin)
- [x] `resources/views/orders/show.blade.php` — detail pesanan + tombol update status

**4. Halaman Pelanggan**
- [x] `resources/views/home/index.blade.php` — halaman utama daftar menu berdasarkan kategori
- [x] `resources/views/orders/create.blade.php` — form buat pesanan (pilih menu + jumlah)
- [x] `resources/views/orders/history.blade.php` — riwayat pesanan pelanggan

#### 📌 Cara Kerja:
```bash
# Clone repo dan buat branch frontend
git clone https://github.com/muh-ghazii/SiKantin.git
cd SiKantin
git checkout -b frontend

# Setelah selesai coding
git add .
git commit -m "feat: nama halaman yang dibuat"
git push origin frontend
```

#### 📌 Panduan Blade Laravel (untuk Frontend):

Membuat halaman baru:
```html
{{-- resources/views/menu/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Menu')

@section('content')
    <h1>Daftar Menu</h1>
    {{-- Konten halaman di sini --}}
@endsection
```

Menampilkan data dari controller:
```html
@foreach($menus as $menu)
    <div class="card">
        <h5>{{ $menu->nama_menu }}</h5>
        <p>Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
    </div>
@endforeach
```

Membuat form:
```html
<form action="/menu" method="POST">
    @csrf
    <input type="text" name="nama_menu" class="form-control">
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
```

---

### 🗄️ DATABASE (Teman Database)

**Branch:** `database`  
**Folder utama:** `database/migrations/`, `database/seeders/`

#### ✅ Sudah Selesai (dibuat oleh Backend):
- [x] Tabel `users` (id, nama, email, password, role, timestamps)
- [x] Tabel `categories` (id, nama_kategori, timestamps)
- [x] Tabel `menus` (id, category_id, nama_menu, deskripsi, harga, stok, gambar_url, timestamps)
- [x] Tabel `orders` (id, user_id, total_harga, status, timestamps)
- [x] Tabel `order_items` (id, order_id, menu_id, jumlah, subtotal, timestamps)

#### 📝 Yang Masih Perlu Dikerjakan:

**1. Tambah Seeder Data Lengkap**
- [x] Tambah minimal 10 data menu yang realistis di `MenuSeeder.php`
- [x] Tambah data kategori yang lengkap di `CategorySeeder.php`
- [x] Buat `OrderSeeder.php` — data pesanan contoh untuk testing

**2. Buat File SQL Backup**
- [x] Export struktur database ke file `database/sikantin.sql`
- [x] File ini digunakan sebagai backup dan dokumentasi

**3. Optimasi Database**
- [x] Cek semua foreign key sudah benar
- [x] Pastikan index pada kolom yang sering dicari (email, status)
- [x] Dokumentasi ERD final (sudah tersedia di `database/ERD.md`)

**4. Update Migration jika Ada Perubahan**
- [x] Kalau ada kolom yang perlu ditambah, buat migration baru
- [x] Jangan edit migration yang sudah ada!

#### 📌 Cara Kerja:
```bash
# Clone repo dan buat branch database
git clone https://github.com/muh-ghazii/SiKantin.git
cd SiKantin
git checkout -b database

# Menambah seeder baru
php artisan make:seeder NamaSeeder

# Jalankan ulang semua migration + seeder
php artisan migrate:fresh --seed

# Setelah selesai
git add .
git commit -m "feat: tambah seeder data lengkap"
git push origin database
```

#### 📌 Cara Export Database ke SQL:
1. Buka `http://localhost:8080/phpmyadmin`
2. Klik database `sikantin`
3. Klik tab **Ekspor**
4. Pilih format **SQL**
5. Klik **Kirim**
6. Simpan file sebagai `database/sikantin.sql`
7. Push ke GitHub

---

## 📡 Dokumentasi API

Base URL: `http://127.0.0.1:8000/api`

### Authentication

| Method | Endpoint | Deskripsi | Auth |
|---|---|---|---|
| POST | `/register` | Daftar akun baru | ❌ |
| POST | `/login` | Login, mendapat token | ❌ |
| POST | `/logout` | Logout | ✅ |
| GET | `/me` | Data user yang login | ✅ |

**Contoh Request Login:**
```json
POST /api/login
{
    "email": "admin@sikantin.com",
    "password": "password123"
}
```

**Contoh Response Login:**
```json
{
    "status": "success",
    "message": "Login berhasil",
    "token": "1|abc123...",
    "data": {
        "id": 1,
        "nama": "Admin SiKantin",
        "email": "admin@sikantin.com",
        "role": "admin"
    }
}
```

---

### Menu

| Method | Endpoint | Deskripsi | Auth | Role |
|---|---|---|---|---|
| GET | `/menus` | Daftar semua menu | ❌ | Semua |
| GET | `/menus/{id}` | Detail menu | ❌ | Semua |
| POST | `/menus` | Tambah menu | ✅ | Admin |
| PUT | `/menus/{id}` | Edit menu | ✅ | Admin |
| DELETE | `/menus/{id}` | Hapus menu | ✅ | Admin |

**Cara pakai token di Postman:**
- Tab **Authorization** → pilih **Bearer Token** → paste token dari login

---

### Kategori

| Method | Endpoint | Deskripsi | Auth | Role |
|---|---|---|---|---|
| GET | `/categories` | Daftar semua kategori | ❌ | Semua |
| GET | `/categories/{id}` | Detail kategori + menu | ❌ | Semua |
| POST | `/categories` | Tambah kategori | ✅ | Admin |
| PUT | `/categories/{id}` | Edit kategori | ✅ | Admin |
| DELETE | `/categories/{id}` | Hapus kategori | ✅ | Admin |

---

### Pesanan

| Method | Endpoint | Deskripsi | Auth | Role |
|---|---|---|---|---|
| GET | `/orders` | Lihat pesanan | ✅ | Admin: semua, Pelanggan: miliknya |
| POST | `/orders` | Buat pesanan baru | ✅ | Pelanggan |
| GET | `/orders/{id}` | Detail pesanan | ✅ | Login |
| PUT | `/orders/{id}/status` | Update status pesanan | ✅ | Admin |

**Contoh Request Buat Pesanan:**
```json
POST /api/orders
Authorization: Bearer {token}
{
    "items": [
        { "menu_id": 1, "jumlah": 2 },
        { "menu_id": 5, "jumlah": 1 }
    ]
}
```

**Status Pesanan:**
- `pending` → baru dibuat (default)
- `proses` → sedang diproses
- `selesai` → pesanan selesai
- `dibatalkan` → pesanan dibatalkan

---

### Dashboard (Admin Only)

| Method | Endpoint | Deskripsi | Auth | Role |
|---|---|---|---|---|
| GET | `/dashboard` | Statistik lengkap | ✅ | Admin |

**Response Dashboard:**
```json
{
    "status": "success",
    "data": {
        "statistik": {
            "total_pelanggan": 10,
            "total_menu": 12,
            "total_kategori": 4,
            "total_pesanan": 25,
            "total_pendapatan": 500000
        },
        "pesanan_per_status": [...],
        "menu_terlaris": [...],
        "pesanan_terbaru": [...]
    }
}
```

---

## 🔀 Panduan Git & Workflow

### Aturan Branch

```
main          ← kode final yang sudah jadi dan di-merge
├── backend   ← khusus backend (Muhammad Ghazi)
├── frontend  ← khusus frontend (teman frontend)
└── database  ← khusus database (teman database)
```

### Aturan Commit Message

Format: `[type]: [deskripsi singkat]`

| Type | Digunakan untuk |
|---|---|
| `feat` | Fitur baru |
| `fix` | Perbaikan bug |
| `update` | Update/perubahan kecil |
| `docs` | Update dokumentasi |
| `style` | Perubahan tampilan/CSS |

**Contoh commit yang baik:**
```bash
git commit -m "feat: tambah halaman login dan register"
git commit -m "fix: perbaiki bug harga tidak tampil"
git commit -m "style: rapikan tampilan dashboard admin"
git commit -m "docs: update README dokumentasi API"
```

### Cara Merge ke Main (dilakukan bersama)

```bash
# Pastikan semua branch sudah push terbaru
# Lakukan saat fase integrasi (minggu ke-3)

git checkout main
git merge backend
git merge frontend
git merge database
git push origin main
```

---

## 📅 Timeline Project

| Tanggal | Target | PIC |
|---|---|---|
| 29 Mei - 1 Jun | Setup project, semua bisa run di laptop masing-masing | Semua |
| 2 - 4 Jun | Semua fitur backend selesai + fitur frontend 50% | Backend + Frontend |
| 5 - 7 Jun | Frontend selesai + database seeder lengkap | Frontend + Database |
| 8 - 9 Jun | **Integrasi** — merge semua branch, testing bersama | Semua |
| 10 Jun | **DEADLINE** — final polish, fix bug, siap presentasi | Semua |

---

## ❓ FAQ

**Q: Kenapa saya tidak bisa akses `localhost/SiKantin`?**  
A: Pastikan XAMPP sudah nyala dan jalankan `php artisan serve` di terminal.

**Q: Error "No connection could be made"?**  
A: MySQL belum nyala. Buka XAMPP Control Panel → Start MySQL.

**Q: Error port 3306?**  
A: Cek port MySQL di XAMPP. Kalau 3307, ubah `DB_PORT=3307` di file `.env`.

**Q: Bagaimana cara test API tanpa frontend?**  
A: Gunakan Postman atau Thunder Client (ekstensi VS Code).

**Q: Saya edit file yang salah, bagaimana?**  
A: Jalankan `git checkout -- nama_file.php` untuk kembalikan ke versi terakhir.

---

## 📞 Kontak Tim

Kalau ada pertanyaan atau butuh bantuan, hubungi di grup WhatsApp tim atau diskusi via GitHub Issues.

---

*README ini dibuat untuk keperluan project akhir Pemrograman Web II — SiKantin 2024*