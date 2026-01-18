# 🗄️ Database Schema Documentation

## Database Overview
- **Database Type**: SQLite
- **Location**: `database/database.sqlite`
- **Charset**: UTF-8
- **Collation**: utf8_unicode_ci

## 📊 Entity Relationship Diagram (ERD)

```
Users (1) ──── (N) Orders ──── (N) OrderItems ──── (1) Menus ──── (1) Categories
  │                │                                      
  │                ├── (N) Payments                       
  │                ├── (N) OrderStatusLogs                
  │                ├── (1) DeliveryTypes                  
  │                ├── (1) DeliveryAreas                  
  │                └── (1) Kurir [Users]                  
  │                                                       
  ├── (N) Carts ──── (1) Menus                           
  ├── (N) Addresses                                       
  ├── (1) UserSettings                                    
  └── (N) Contacts                                        
```

## 📋 Table Structures

### 👤 **users**
Menyimpan data pengguna sistem dengan berbagai role.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | User ID |
| name | VARCHAR(255) | NOT NULL | Nama lengkap |
| email | VARCHAR(255) | UNIQUE, NOT NULL | Email address |
| email_verified_at | TIMESTAMP | NULLABLE | Waktu verifikasi email |
| password | VARCHAR(255) | NULLABLE | Password (hashed) |
| google_id | VARCHAR(255) | NULLABLE | Google OAuth ID |
| phone | VARCHAR(255) | NULLABLE | Nomor telepon |
| role | ENUM | DEFAULT 'customer' | admin, customer, staff_dapur, admin_keuangan, kurir |
| is_active | BOOLEAN | DEFAULT true | Status aktif user |
| remember_token | VARCHAR(100) | NULLABLE | Remember token |
| created_at | TIMESTAMP | NOT NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NOT NULL | Waktu diupdate |

**Indexes:**
- PRIMARY: id
- UNIQUE: email

---

### 🛒 **orders**
Menyimpan data pesanan pelanggan.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Order ID |
| user_id | BIGINT | FOREIGN KEY → users.id | ID pelanggan |
| order_number | VARCHAR(255) | UNIQUE, NOT NULL | Nomor pesanan unik |
| total_quantity | INTEGER | NOT NULL | Total jumlah item |
| subtotal | DECIMAL(12,2) | NOT NULL | Subtotal harga |
| delivery_fee | DECIMAL(10,2) | NOT NULL | Biaya pengiriman |
| total_amount | DECIMAL(12,2) | NOT NULL | Total pembayaran |
| delivery_type_id | BIGINT | FOREIGN KEY → delivery_types.id | Jenis pengiriman |
| delivery_area_id | BIGINT | FOREIGN KEY → delivery_areas.id | Area pengiriman |
| delivery_address | TEXT | NOT NULL | Alamat pengiriman |
| delivery_date | DATE | NOT NULL | Tanggal pengiriman |
| delivery_time | TIME | NOT NULL | Waktu pengiriman |
| status | ENUM | DEFAULT 'pending' | Status pesanan |
| payment_status | ENUM | DEFAULT 'pending' | Status pembayaran |
| payment_proof | VARCHAR(255) | NULLABLE | File bukti pembayaran |
| notes | TEXT | NULLABLE | Catatan pesanan |
| cancellation_reason | TEXT | NULLABLE | Alasan pembatalan |
| assigned_kurir_id | BIGINT | FOREIGN KEY → users.id | ID kurir yang ditugaskan |
| delivery_photo | VARCHAR(255) | NULLABLE | Foto bukti pengiriman |
| created_at | TIMESTAMP | NOT NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NOT NULL | Waktu diupdate |

**Enums:**
- status: pending, payment_verified, preparing, ready, on_delivery, delivered, completed, cancelled
- payment_status: pending, verified, failed

**Indexes:**
- PRIMARY: id
- FOREIGN: user_id, delivery_type_id, delivery_area_id, assigned_kurir_id
- UNIQUE: order_number

---

### 🍽️ **order_items**
Detail item dalam setiap pesanan.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Item ID |
| order_id | BIGINT | FOREIGN KEY → orders.id | ID pesanan |
| menu_id | BIGINT | FOREIGN KEY → menus.id | ID menu |
| quantity | INTEGER | NOT NULL | Jumlah item |
| price | DECIMAL(10,2) | NOT NULL | Harga per item |
| subtotal | DECIMAL(12,2) | NOT NULL | Subtotal item |
| created_at | TIMESTAMP | NOT NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NOT NULL | Waktu diupdate |

**Indexes:**
- PRIMARY: id
- FOREIGN: order_id, menu_id

---

### 💳 **payments**
Menyimpan data pembayaran pesanan.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Payment ID |
| order_id | BIGINT | FOREIGN KEY → orders.id | ID pesanan |
| amount | DECIMAL(12,2) | NOT NULL | Jumlah pembayaran |
| payment_method | ENUM | NOT NULL | Metode pembayaran |
| sender_name | VARCHAR(255) | NULLABLE | Nama pengirim |
| status | ENUM | DEFAULT 'pending' | Status pembayaran |
| verified_by | BIGINT | FOREIGN KEY → users.id | ID yang memverifikasi |
| verified_at | TIMESTAMP | NULLABLE | Waktu verifikasi |
| notes | TEXT | NULLABLE | Catatan pembayaran |
| created_at | TIMESTAMP | NOT NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NOT NULL | Waktu diupdate |

**Enums:**
- payment_method: bank_transfer, qris, cod
- status: pending, verified, failed

**Indexes:**
- PRIMARY: id
- FOREIGN: order_id, verified_by

---

### 📝 **order_status_logs**
Log perubahan status pesanan.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Log ID |
| order_id | BIGINT | FOREIGN KEY → orders.id | ID pesanan |
| status | VARCHAR(255) | NOT NULL | Status baru |
| updated_by | BIGINT | FOREIGN KEY → users.id | ID yang mengupdate |
| notes | TEXT | NULLABLE | Catatan perubahan |
| created_at | TIMESTAMP | NOT NULL | Waktu perubahan |

**Note:** Ada inconsistency antara migration (updated_by) dan model (changed_by)

**Indexes:**
- PRIMARY: id
- FOREIGN: order_id, updated_by

---

### 🍕 **menus**
Daftar menu makanan yang tersedia.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Menu ID |
| category_id | BIGINT | FOREIGN KEY → categories.id | ID kategori |
| name | VARCHAR(255) | NOT NULL | Nama menu |
| slug | VARCHAR(255) | UNIQUE, NOT NULL | URL slug |
| description | TEXT | NULLABLE | Deskripsi menu |
| price | DECIMAL(10,2) | NOT NULL | Harga menu |
| image | VARCHAR(255) | NULLABLE | Gambar menu |
| is_available | BOOLEAN | DEFAULT true | Status ketersediaan |
| created_at | TIMESTAMP | NOT NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NOT NULL | Waktu diupdate |

**Indexes:**
- PRIMARY: id
- FOREIGN: category_id
- UNIQUE: slug

---

### 📂 **categories**
Kategori menu makanan.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Category ID |
| name | VARCHAR(255) | NOT NULL | Nama kategori |
| slug | VARCHAR(255) | UNIQUE, NOT NULL | URL slug |
| description | TEXT | NULLABLE | Deskripsi kategori |
| image | VARCHAR(255) | NULLABLE | Gambar kategori |
| is_active | BOOLEAN | DEFAULT true | Status aktif |
| created_at | TIMESTAMP | NOT NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NOT NULL | Waktu diupdate |

**Indexes:**
- PRIMARY: id
- UNIQUE: slug

---

### 🛒 **carts**
Keranjang belanja sementara.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Cart ID |
| user_id | BIGINT | FOREIGN KEY → users.id | ID user |
| menu_id | BIGINT | FOREIGN KEY → menus.id | ID menu |
| quantity | INTEGER | NOT NULL | Jumlah item |
| created_at | TIMESTAMP | NOT NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NOT NULL | Waktu diupdate |

**Indexes:**
- PRIMARY: id
- FOREIGN: user_id, menu_id

---

### 🚚 **delivery_types**
Jenis pengiriman yang tersedia.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Type ID |
| name | VARCHAR(255) | NOT NULL | Nama jenis pengiriman |
| description | TEXT | NULLABLE | Deskripsi |
| is_active | BOOLEAN | DEFAULT true | Status aktif |
| created_at | TIMESTAMP | NOT NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NOT NULL | Waktu diupdate |

---

### 📍 **delivery_areas**
Area pengiriman yang dilayani.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Area ID |
| name | VARCHAR(255) | NOT NULL | Nama area |
| fee | DECIMAL(10,2) | NOT NULL | Biaya pengiriman |
| is_active | BOOLEAN | DEFAULT true | Status aktif |
| created_at | TIMESTAMP | NOT NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NOT NULL | Waktu diupdate |

---

### 🏠 **addresses**
Alamat pengiriman pelanggan.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Address ID |
| user_id | BIGINT | FOREIGN KEY → users.id | ID user |
| label | VARCHAR(255) | NOT NULL | Label alamat |
| recipient_name | VARCHAR(255) | NOT NULL | Nama penerima |
| phone | VARCHAR(255) | NOT NULL | Nomor telepon |
| address | TEXT | NOT NULL | Alamat lengkap |
| is_default | BOOLEAN | DEFAULT false | Alamat default |
| created_at | TIMESTAMP | NOT NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NOT NULL | Waktu diupdate |

---

### ⚙️ **settings**
Pengaturan sistem.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Setting ID |
| key | VARCHAR(255) | UNIQUE, NOT NULL | Key pengaturan |
| value | TEXT | NULLABLE | Value pengaturan |
| type | VARCHAR(255) | DEFAULT 'string' | Tipe data |
| created_at | TIMESTAMP | NOT NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NOT NULL | Waktu diupdate |

---

### 👤 **user_settings**
Pengaturan personal user.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Setting ID |
| user_id | BIGINT | FOREIGN KEY → users.id | ID user |
| notifications_enabled | BOOLEAN | DEFAULT true | Notifikasi aktif |
| email_notifications | BOOLEAN | DEFAULT true | Email notifikasi |
| created_at | TIMESTAMP | NOT NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NOT NULL | Waktu diupdate |

---

### 📞 **contacts**
Pesan kontak dari pelanggan.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Contact ID |
| name | VARCHAR(255) | NOT NULL | Nama pengirim |
| email | VARCHAR(255) | NOT NULL | Email pengirim |
| phone | VARCHAR(255) | NULLABLE | Nomor telepon |
| subject | VARCHAR(255) | NOT NULL | Subjek pesan |
| message | TEXT | NOT NULL | Isi pesan |
| is_read | BOOLEAN | DEFAULT false | Status dibaca |
| replied_at | TIMESTAMP | NULLABLE | Waktu dibalas |
| created_at | TIMESTAMP | NOT NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NOT NULL | Waktu diupdate |

---

### 🔔 **notifications**
Notifikasi sistem untuk user.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | CHAR(36) | PRIMARY KEY | UUID |
| type | VARCHAR(255) | NOT NULL | Tipe notifikasi |
| notifiable_type | VARCHAR(255) | NOT NULL | Model yang dinotifikasi |
| notifiable_id | BIGINT | NOT NULL | ID yang dinotifikasi |
| data | TEXT | NOT NULL | Data notifikasi (JSON) |
| read_at | TIMESTAMP | NULLABLE | Waktu dibaca |
| created_at | TIMESTAMP | NOT NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NOT NULL | Waktu diupdate |

---

## 🔗 Relationships Summary

### User Relationships:
- User **has many** Orders
- User **has many** Carts  
- User **has many** Addresses
- User **has one** UserSetting
- User **has many** OrderStatusLogs (as changer)
- User **has many** Payments (as verifier)

### Order Relationships:
- Order **belongs to** User
- Order **has many** OrderItems
- Order **has many** Payments
- Order **has many** OrderStatusLogs
- Order **belongs to** DeliveryType
- Order **belongs to** DeliveryArea
- Order **belongs to** User (as kurir)

### Menu Relationships:
- Menu **belongs to** Category
- Menu **has many** OrderItems
- Menu **has many** Carts

## 📊 Data Seeding

### Default Users:
```sql
INSERT INTO users (name, email, role, password) VALUES
('Admin Catering', 'admin@catering.com', 'admin', 'hashed_password'),
('Staff Dapur', 'dapur@catering.com', 'staff_dapur', 'hashed_password'),
('Admin Keuangan', 'keuangan@catering.com', 'admin_keuangan', 'hashed_password'),
('Kurir Pengiriman', 'kurir@catering.com', 'kurir', 'hashed_password'),
('Test User', 'user@test.com', 'customer', 'hashed_password');
```

### Sample Categories:
- Makanan Utama
- Lauk Pauk  
- Minuman
- Dessert

### Sample Delivery Areas:
- Jakarta Pusat (Rp 10,000)
- Jakarta Selatan (Rp 15,000)
- Jakarta Timur (Rp 15,000)

## 🔧 Database Maintenance

### Backup Command:
```bash
cp database/database.sqlite database/backup_$(date +%Y%m%d_%H%M%S).sqlite
```

### Migration Commands:
```bash
php artisan migrate              # Run migrations
php artisan migrate:rollback     # Rollback last batch
php artisan migrate:fresh        # Drop all tables and re-run
php artisan migrate:fresh --seed # Fresh migration with seeding
```

### Seeding Commands:
```bash
php artisan db:seed              # Run all seeders
php artisan db:seed --class=AdminSeeder  # Run specific seeder
```

---
**Database Version**: 1.0.0
**Last Updated**: January 2025