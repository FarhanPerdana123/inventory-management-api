# Entity Relationship Diagram (ERD)

## Inventory Management System

```mermaid
erDiagram
    USERS ||--o{ USER_ROLES : has
    ROLES ||--o{ USER_ROLES : assigned
    USERS ||--o{ TRANSACTIONS : performs
    SUPPLIERS ||--o{ TRANSACTIONS : supplies
    TRANSACTIONS ||--o{ TRANSACTION_ITEMS : contains
    PRODUCTS ||--o{ TRANSACTION_ITEMS : included
    PRODUCTS ||--o{ STOCKS : stored
    WAREHOUSES ||--o{ STOCKS : holds

    USERS {
        bigint id PK
        string name
        string username
        string email
        string password
        timestamp email_verified_at
        timestamp created_at
        timestamp updated_at
    }

    ROLES {
        bigint id PK
        string name
        string description
        timestamp created_at
        timestamp updated_at
    }

    USER_ROLES {
        bigint id PK
        bigint user_id FK
        bigint role_id FK
    }

    PRODUCTS {
        bigint id PK
        string sku
        string name
        text description
        decimal price
        timestamp created_at
        timestamp updated_at
    }

    SUPPLIERS {
        bigint id PK
        string name
        string phone
        string address
        timestamp created_at
        timestamp updated_at
    }

    WAREHOUSES {
        bigint id PK
        string name
        string location
        timestamp created_at
        timestamp updated_at
    }

    STOCKS {
        bigint id PK
        bigint product_id FK
        bigint warehouse_id FK
        int quantity
        timestamp created_at
        timestamp updated_at
    }

    TRANSACTIONS {
        bigint id PK
        bigint user_id FK
        bigint supplier_id FK
        string type
        date transaction_date
        text note
        timestamp created_at
        timestamp updated_at
    }

    TRANSACTION_ITEMS {
        bigint id PK
        bigint transaction_id FK
        bigint product_id FK
        int quantity
        decimal price
    }
```

## Table Descriptions

### USERS
Menyimpan data pengguna sistem dengan role-based access control (RBAC).

### ROLES
Menyimpan data role/peran pengguna:
- **Admin**: Full access to all features and settings
- **Staff**: Manage products, suppliers, and create transactions
- **Owner**: Read-only access to reports and summary

### USER_ROLES
Pivot table untuk relasi many-to-many antara users dan roles.

### PRODUCTS
Menyimpan data produk dengan SKU unique identifier.

### SUPPLIERS
Menyimpan data pemasok/supplier produk.

### WAREHOUSES
Menyimpan data gudang penyimpanan produk.

### STOCKS
Pivot table untuk menyimpan stok produk di setiap gudang dengan constraint unique (product_id, warehouse_id).

### TRANSACTIONS
Menyimpan transaksi inventory dengan tipe:
- **IN**: Transaksi masuk (pembelian dari supplier)
- **OUT**: Transaksi keluar (penjualan/pengeluaran)
- **ADJUST**: Penyesuaian stok (stock opname, koreksi)

### TRANSACTION_ITEMS
Menyimpan detail item dari setiap transaksi.

## Relationships

| From | To | Type | Description |
|------|-----|------|-------------|
| USERS | USER_ROLES | One-to-Many | User memiliki satu atau lebih role |
| ROLES | USER_ROLES | One-to-Many | Role dapat dimiliki oleh banyak user |
| USERS | TRANSACTIONS | One-to-Many | User melakukan transaksi |
| SUPPLIERS | TRANSACTIONS | One-to-Many | Supplier terkait dengan transaksi IN |
| TRANSACTIONS | TRANSACTION_ITEMS | One-to-Many | Transaksi memiliki banyak item |
| PRODUCTS | TRANSACTION_ITEMS | One-to-Many | Produk dapat muncul di banyak item transaksi |
| PRODUCTS | STOCKS | One-to-Many | Produk disimpan di berbagai gudang |
| WAREHOUSES | STOCKS | One-to-Many | Gudang menyimpan berbagai produk |

## Business Rules

1. **Stock Management**
   - Setiap produk dapat disimpan di multiple gudang
   - Unique constraint pada (product_id, warehouse_id) untuk menghindari duplikasi
   - Quantity dapat negatif untuk tracking (akan divalidasi di aplikasi)

2. **Transaction Flow**
   - Transaksi IN: Menambah stok (dengan supplier)
   - Transaksi OUT: Mengurangi stok (tanpa supplier)
   - Transaksi ADJUST: Koreksi stok (tanpa supplier)

3. **User Access Control**
   - User dapat memiliki multiple roles
   - Authorization berbasis role untuk setiap endpoint API

4. **Data Integrity**
   - Cascade delete pada user_roles, stocks, transaction_items
   - Null on delete untuk supplier_id pada transactions
