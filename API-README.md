# Inventory Management API

REST API untuk sistem manajemen inventory dengan role-based access control (RBAC).

## 🚀 Quick Start

```bash
# Clone repository
git clone https://github.com/FarhanPerdana123/inventory-management-api.git
cd inventory-api

# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Start Docker database
docker-compose up -d

# Run migrations & seeders
php artisan migrate:fresh --seed

# Start server
php artisan serve
```

API: `http://localhost:8000/api`

## 👥 Default Users

| Email | Password | Role |
|-------|----------|------|
| admin@inventory.com | password | Admin |
| staff@inventory.com | password | Staff |
| owner@inventory.com | password | Owner |

## 📋 API Endpoints

### Authentication
- `POST /api/auth/register` - Register new user
- `POST /api/auth/login` - Login
- `POST /api/auth/logout` - Logout (auth)
- `GET /api/auth/me` - Get current user (auth)

### Roles (Admin only)
- `GET /api/roles` - List roles
- `POST /api/roles` - Create role
- `GET /api/roles/{id}` - Get role
- `PUT /api/roles/{id}` - Update role
- `DELETE /api/roles/{id}` - Delete role

### Users (Admin only)
- `GET /api/users` - List users
- `POST /api/users` - Create user
- `GET /api/users/{id}` - Get user
- `PUT /api/users/{id}` - Update user
- `DELETE /api/users/{id}` - Delete user
- `POST /api/users/{id}/roles` - Assign roles

### Products
- `GET /api/products` - List products (auth)
- `POST /api/products` - Create product (Admin, Staff)
- `GET /api/products/{id}` - Get product (auth)
- `PUT /api/products/{id}` - Update product (Admin, Staff)
- `DELETE /api/products/{id}` - Delete product (Admin)

### Suppliers
- `GET /api/suppliers` - List suppliers (auth)
- `POST /api/suppliers` - Create supplier (Admin, Staff)
- `GET /api/suppliers/{id}` - Get supplier (auth)
- `PUT /api/suppliers/{id}` - Update supplier (Admin, Staff)
- `DELETE /api/suppliers/{id}` - Delete supplier (Admin)

### Warehouses
- `GET /api/warehouses` - List warehouses (auth)
- `POST /api/warehouses` - Create warehouse (Admin)
- `GET /api/warehouses/{id}` - Get warehouse (auth)
- `PUT /api/warehouses/{id}` - Update warehouse (Admin)
- `DELETE /api/warehouses/{id}` - Delete warehouse (Admin)

### Stocks
- `GET /api/stocks` - List stocks (auth)
- `GET /api/stocks/summary` - Stock summary (Owner, Admin)
- `POST /api/stocks/adjustments` - Stock adjustment (Admin)

### Transactions
- `GET /api/transactions` - List transactions (auth)
- `GET /api/transactions/{id}` - Get transaction (auth)
- `POST /api/transactions/in` - Create IN transaction (Admin, Staff)
- `POST /api/transactions/out` - Create OUT transaction (Admin, Staff)
- `POST /api/transactions/{id}/void` - Void transaction (Admin)

### Reports (Owner, Admin)
- `GET /api/reports/daily-stock` - Daily stock report
- `GET /api/reports/monthly-transactions` - Monthly transactions
- `GET /api/reports/fast-moving` - Fast moving products

## 🔐 Authentication

All endpoints (except register & login) require Bearer token:

```http
Authorization: Bearer {your_token_here}
```

Get token from login response:
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@inventory.com","password":"password"}'
```

## 📝 Example Requests

### Create Product
```bash
curl -X POST http://localhost:8000/api/products \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "sku": "PRD-009",
    "name": "New Product",
    "description": "Product description",
    "price": 100000
  }'
```

### Create Transaction IN
```bash
curl -X POST http://localhost:8000/api/transactions/in \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "supplier_id": 1,
    "warehouse_id": 1,
    "transaction_date": "2025-12-26",
    "note": "Purchase order",
    "items": [
      {
        "product_id": 1,
        "quantity": 10,
        "price": 8500000
      }
    ]
  }'
```

### Create Transaction OUT
```bash
curl -X POST http://localhost:8000/api/transactions/out \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "warehouse_id": 1,
    "transaction_date": "2025-12-26",
    "note": "Sales order",
    "items": [
      {
        "product_id": 1,
        "quantity": 5,
        "price": 8500000
      }
    ]
  }'
```

## 🏗️ Database Schema

See [docs/erd.md](docs/erd.md) for complete ERD diagram.

## 🛠️ Tech Stack

- Laravel 12
- PHP 8.2+
- MySQL 8.0
- Laravel Sanctum (Authentication)
- Docker (Database)

## 📚 Documentation

- [Implementation Guide](IMPLEMENTATION.md) - Complete implementation details
- [ERD Documentation](docs/erd.md) - Database schema
- [Docker Setup](DOCKER-README.md) - Docker configuration

## 🔒 Role-Based Access Control

| Role | Permissions |
|------|------------|
| Admin | Full access to all resources |
| Staff | Manage products, suppliers, transactions |
| Owner | Read-only reports and summaries |

## 📦 Features

- ✅ JWT/Sanctum Authentication
- ✅ Role-based authorization
- ✅ Product management
- ✅ Supplier management
- ✅ Warehouse management
- ✅ Stock tracking with auto-update
- ✅ Transaction IN/OUT/ADJUST
- ✅ Transaction void (reverse entry)
- ✅ Stock summary by warehouse
- ✅ Daily stock reports
- ✅ Monthly transaction reports
- ✅ Fast moving products analysis
- ✅ Pagination & search
- ✅ API Resources for clean responses

## 🧪 Testing

```bash
# Run migrations
php artisan migrate:fresh --seed

# Test with curl or Postman
# See examples above
```

## 📄 License

MIT License

## 👨‍💻 Author

Farhan Perdana
