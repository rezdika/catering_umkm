# 📋 Dokumentasi Sistem Catering UMKM

## 🏢 Tentang Project
Sistem manajemen catering untuk UMKM yang memungkinkan pelanggan memesan makanan secara online dengan fitur lengkap mulai dari pemesanan, pembayaran, hingga pengiriman.

## 🚀 Teknologi yang Digunakan
- **Framework**: Laravel 11
- **Database**: SQLite
- **Frontend**: Blade Templates, Bootstrap 5
- **Authentication**: Laravel Auth + Google OAuth
- **Notifications**: Laravel Notifications

## 👥 Sistem Role & Akses

### 1. **Admin** (`admin`)
- Akses penuh ke semua fitur sistem
- Manajemen user, menu, kategori, pengaturan
- Dashboard utama dengan overview lengkap

### 2. **Staff Dapur** (`staff_dapur`)
- Dashboard khusus dapur dengan monitoring produksi
- Manajemen pesanan (payment_verified → preparing → ready)
- Laporan produksi dan performa dapur
- **Route Prefix**: `/admin/kitchen`

### 3. **Admin Keuangan** (`admin_keuangan`)
- Verifikasi pembayaran manual dan otomatis
- Laporan keuangan dan transaksi
- Bulk verification pembayaran
- **Route Prefix**: `/admin/finance`

### 4. **Kurir** (`kurir`)
- Manajemen pengiriman pesanan
- Update status pengiriman (ready → on_delivery → delivered)
- Laporan pengiriman
- **Route Prefix**: `/admin/kurir`

### 5. **Customer** (`customer`)
- Pemesanan makanan online
- Manajemen profil dan alamat
- History pesanan dan notifikasi
- **Route Prefix**: `/user`

## 📊 Alur Bisnis Sistem

### Alur Pemesanan:
```
Customer Order → Pending → Payment Upload → Payment Verification → 
Payment Verified → Kitchen Processing → Ready → Kurir Pickup → 
On Delivery → Delivered → Completed
```

### Status Pesanan:
- `pending`: Pesanan baru, menunggu pembayaran
- `payment_verified`: Pembayaran terverifikasi, siap diproses dapur
- `preparing`: Sedang dimasak di dapur
- `ready`: Siap untuk diambil kurir
- `on_delivery`: Dalam perjalanan pengiriman
- `delivered`: Sudah sampai ke customer
- `completed`: Pesanan selesai
- `cancelled`: Pesanan dibatalkan

## 🗄️ Struktur Database

### Tabel Utama:

#### **users**
```sql
- id, name, email, phone, password
- role: admin|customer|staff_dapur|admin_keuangan|kurir
- google_id, is_active
```

#### **orders**
```sql
- id, user_id, order_number, total_quantity
- subtotal, delivery_fee, total_amount
- delivery_type_id, delivery_area_id, delivery_address
- delivery_date, delivery_time
- status, payment_status, notes
- assigned_kurir_id, delivery_photo
```

#### **order_items**
```sql
- id, order_id, menu_id, quantity, price, subtotal
```

#### **payments**
```sql
- id, order_id, amount, payment_method
- sender_name, status, verified_by, verified_at
```

#### **order_status_logs**
```sql
- id, order_id, status, updated_by, notes, created_at
```

## 🔧 Fitur Utama

### 🍳 Dashboard Staff Dapur
- **Statistik Real-time**: Pesanan hari ini, sedang diproses, siap kirim
- **Progress Tracking**: Tingkat penyelesaian produksi
- **Menu Summary**: Ringkasan menu yang perlu dibuat
- **Quick Actions**: Navigasi cepat ke fitur utama
- **Auto Refresh**: Dashboard update otomatis setiap 2 menit

### 💰 Dashboard Keuangan
- **Payment Verification**: Verifikasi pembayaran manual/otomatis
- **Bulk Operations**: Verifikasi multiple pembayaran sekaligus
- **Financial Reports**: Laporan keuangan dengan filter periode
- **Payment Methods**: Bank Transfer, QRIS, COD

### 🚚 Dashboard Kurir
- **Order Assignment**: Pengambilan pesanan yang ready
- **Delivery Tracking**: Update status pengiriman
- **Photo Proof**: Upload foto bukti pengiriman
- **Route Optimization**: (Future feature)

### 👤 Customer Features
- **Menu Browsing**: Katalog menu dengan kategori
- **Shopping Cart**: Keranjang belanja dengan quantity
- **Multiple Address**: Manajemen alamat pengiriman
- **Order Tracking**: Real-time status pesanan
- **Notifications**: Notifikasi update status

## 🛠️ Setup & Installation

### Requirements:
- PHP 8.2+
- Composer
- Node.js & NPM

### Installation Steps:
```bash
# Clone repository
git clone [repository-url]
cd catering-umkm

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed

# Build assets
npm run build

# Start server
php artisan serve
```

### Default Login Credentials:
```
Admin: admin@catering.com / admin123
Staff Dapur: dapur@catering.com / dapur123
Admin Keuangan: keuangan@catering.com / keuangan123
Kurir: kurir@catering.com / kurir123
Customer: user@test.com / user123
```

## 📁 Struktur Project

```
app/
├── Http/Controllers/
│   ├── Admin/
│   │   ├── Kitchen/          # Controllers untuk staff dapur
│   │   ├── Finance/          # Controllers untuk keuangan
│   │   └── Kurir/           # Controllers untuk kurir
│   ├── Auth/                # Authentication
│   └── User/                # Customer controllers
├── Models/                  # Eloquent models
├── Notifications/           # Custom notifications
└── Middleware/             # Custom middleware

resources/views/
├── admin/
│   ├── kitchen/            # Views staff dapur
│   ├── finance/            # Views keuangan
│   └── kurir/             # Views kurir
├── auth/                   # Login/register views
└── user/                   # Customer views

database/
├── migrations/             # Database migrations
└── seeders/               # Database seeders
```

## 🔐 Security Features

- **Role-based Access Control**: Middleware untuk kontrol akses
- **CSRF Protection**: Laravel CSRF token
- **Input Validation**: Comprehensive form validation
- **File Upload Security**: Secure file handling
- **SQL Injection Prevention**: Eloquent ORM protection

## 📱 Responsive Design

- **Mobile-First**: Optimized untuk mobile devices
- **Bootstrap 5**: Modern responsive framework
- **Kitchen Tablet**: Optimized untuk tablet di dapur
- **Print-Friendly**: Receipt dan laporan bisa dicetak

## 🔔 Notification System

- **Real-time Updates**: Notifikasi status pesanan
- **Email Notifications**: (Future feature)
- **Push Notifications**: (Future feature)
- **In-app Notifications**: Notification panel

## 📈 Reporting & Analytics

### Staff Dapur:
- Laporan produksi harian/bulanan
- Analisis menu populer
- Performance metrics dapur

### Keuangan:
- Laporan transaksi dan pembayaran
- Revenue analysis
- Export ke Excel/PDF

### Kurir:
- Laporan pengiriman
- Performance tracking
- Route efficiency

## 🚧 Known Issues & Improvements

### Current Issues:
1. **OrderStatusLog Model**: Inconsistency antara migration (`updated_by`) dan model (`changed_by`)
2. **Kitchen Dashboard**: Hanya menampilkan pesanan dengan delivery_date hari ini
3. **Real-time Updates**: Perlu WebSocket untuk real-time yang lebih baik

### Future Improvements:
- Inventory management
- WhatsApp integration
- Mobile app
- Advanced analytics
- Multi-location support

## 🤝 Contributing

1. Fork repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Create Pull Request

## 📞 Support

Untuk pertanyaan atau bantuan, hubungi tim development.

---
**Last Updated**: January 2025
**Version**: 1.0.0