# 🔌 API Documentation - Catering UMKM

## Base URL
```
http://localhost:8000
```

## Authentication
Sistem menggunakan Laravel Session-based authentication.

## 📋 Endpoints Overview

### 🔐 Authentication Routes

#### Login
```http
POST /login
Content-Type: application/x-www-form-urlencoded

email=user@example.com&password=password123
```

#### Register
```http
POST /register
Content-Type: application/x-www-form-urlencoded

name=John Doe&email=user@example.com&password=password123&password_confirmation=password123
```

#### Google OAuth
```http
GET /auth/google
GET /auth/google/callback
```

#### Logout
```http
POST /logout
```

### 👤 User/Customer Routes

#### Get Cart Count
```http
GET /user/cart/count
Authorization: Session

Response:
{
    "count": 3
}
```

#### Add to Cart
```http
POST /user/cart
Content-Type: application/x-www-form-urlencoded

menu_id=1&quantity=2
```

#### Update Cart Item
```http
PUT /user/cart/{cart_id}
Content-Type: application/x-www-form-urlencoded

quantity=3
```

#### Create Order
```http
POST /user/orders
Content-Type: application/x-www-form-urlencoded

delivery_type_id=1&delivery_area_id=1&delivery_address=Jl. Example&delivery_date=2025-01-15&delivery_time=12:00&notes=Extra spicy
```

#### Upload Payment Proof
```http
POST /user/orders/{order_id}/payment
Content-Type: multipart/form-data

payment_proof=@file.jpg&payment_method=bank_transfer&sender_name=John Doe&amount=150000
```

### 🍳 Kitchen Staff Routes

#### Get Today's Orders
```http
GET /admin/kitchen/orders/today
Authorization: Session (staff_dapur role)

Response:
{
    "orders": [
        {
            "id": 1,
            "order_number": "ORD-20250110-ABC123",
            "status": "payment_verified",
            "delivery_time": "12:00:00",
            "user": {
                "name": "John Doe",
                "phone": "081234567890"
            },
            "order_items": [
                {
                    "menu": {
                        "name": "Nasi Gudeg"
                    },
                    "quantity": 2
                }
            ]
        }
    ]
}
```

#### Update Order Status (Kitchen)
```http
PATCH /admin/kitchen/orders/{order_id}/status
Content-Type: application/x-www-form-urlencoded

status=preparing
```

### 💰 Finance Routes

#### Get Payments for Verification
```http
GET /admin/finance/payments
Authorization: Session (admin_keuangan role)

Query Parameters:
- status: pending|verified|failed
- payment_method: bank_transfer|qris|cod
- date_from: 2025-01-01
- date_to: 2025-01-31
- search: order_number or customer_name
```

#### Verify Payment
```http
PATCH /admin/finance/payments/{payment_id}/verify
Content-Type: application/x-www-form-urlencoded

status=verified&notes=Payment confirmed
```

#### Bulk Verify Payments
```http
POST /admin/finance/payments/bulk-verify
Content-Type: application/x-www-form-urlencoded

payment_ids[]=1&payment_ids[]=2&status=verified&notes=Bulk verification
```

#### Create Manual Payment
```http
POST /admin/finance/payments
Content-Type: application/x-www-form-urlencoded

order_id=1&amount=150000&payment_method=bank_transfer&sender_name=John Doe&status=verified&notes=Manual entry
```

### 🚚 Kurir Routes

#### Get Available Orders
```http
GET /admin/kurir/orders
Authorization: Session (kurir role)

Query Parameters:
- status: ready|on_delivery
```

#### Take Order
```http
PATCH /admin/kurir/orders/{order_id}/take
```

#### Complete Delivery
```http
PATCH /admin/kurir/orders/{order_id}/complete
Content-Type: multipart/form-data

delivery_photo=@proof.jpg&notes=Delivered successfully
```

### 📊 Admin Routes

#### Get Dashboard Stats
```http
GET /admin/dashboard
Authorization: Session (admin role)

Response:
{
    "stats": {
        "total_orders": 150,
        "pending_payments": 5,
        "active_orders": 12,
        "completed_today": 8
    }
}
```

#### Manage Users
```http
GET /admin/users
PUT /admin/users/{user_id}
DELETE /admin/users/{user_id}
```

#### Manage Menus
```http
GET /admin/menus
POST /admin/menus
PUT /admin/menus/{menu_id}
DELETE /admin/menus/{menu_id}
```

## 📱 Response Format

### Success Response
```json
{
    "success": true,
    "message": "Operation completed successfully",
    "data": {
        // Response data
    }
}
```

### Error Response
```json
{
    "success": false,
    "message": "Error message",
    "errors": {
        "field_name": ["Validation error message"]
    }
}
```

## 🔔 Notification Endpoints

#### Get Notifications
```http
GET /user/notifications
Authorization: Session

Response:
{
    "notifications": [
        {
            "id": "uuid",
            "type": "OrderStatusNotification",
            "data": {
                "order_number": "ORD-20250110-ABC123",
                "old_status": "preparing",
                "new_status": "ready",
                "message": "Pesanan Anda sudah siap untuk dikirim"
            },
            "read_at": null,
            "created_at": "2025-01-10T10:30:00Z"
        }
    ]
}
```

#### Mark Notification as Read
```http
PATCH /user/notifications/{notification_id}/read
```

#### Mark All Notifications as Read
```http
PATCH /user/notifications/read-all
```

#### Get Unread Count
```http
GET /user/notifications/count

Response:
{
    "count": 3
}
```

## 🛡️ Error Codes

| Code | Description |
|------|-------------|
| 200  | Success |
| 201  | Created |
| 400  | Bad Request |
| 401  | Unauthorized |
| 403  | Forbidden |
| 404  | Not Found |
| 422  | Validation Error |
| 500  | Internal Server Error |

## 📝 Data Models

### Order Status Flow
```
pending → payment_verified → preparing → ready → on_delivery → delivered → completed
                ↓
            cancelled (can be cancelled from any status before on_delivery)
```

### Payment Status
- `pending`: Menunggu verifikasi
- `verified`: Sudah diverifikasi
- `failed`: Ditolak

### User Roles
- `admin`: Full access
- `customer`: Customer access
- `staff_dapur`: Kitchen management
- `admin_keuangan`: Finance management
- `kurir`: Delivery management

## 🔧 Rate Limiting
- Authentication endpoints: 5 requests per minute
- API endpoints: 60 requests per minute
- File uploads: 10 requests per minute

## 📋 Validation Rules

### Order Creation
```php
'delivery_type_id' => 'required|exists:delivery_types,id'
'delivery_area_id' => 'required|exists:delivery_areas,id'
'delivery_address' => 'required|string|max:500'
'delivery_date' => 'required|date|after_or_equal:today'
'delivery_time' => 'required|date_format:H:i'
'notes' => 'nullable|string|max:500'
```

### Payment Upload
```php
'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048'
'payment_method' => 'required|in:bank_transfer,qris,cod'
'sender_name' => 'required|string|max:255'
'amount' => 'required|numeric|min:0'
```

---
**API Version**: 1.0.0
**Last Updated**: January 2025