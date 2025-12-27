# API Usage Examples

## Authentication Examples

### Register a New User

**Request:**
```http
POST /api/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "SecureP@ss123",
  "password_confirmation": "SecureP@ss123"
}
```

**Response:**
```json
{
  "success": true,
  "message": "User registered successfully",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "created_at": "2025-12-27T10:00:00.000000Z"
    },
    "token": "1|abcdefghijklmnopqrstuvwxyz1234567890"
  }
}
```

### Login

**Request:**
```http
POST /api/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "SecureP@ss123"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "role": "staff"
    },
    "token": "2|zyxwvutsrqponmlkjihgfedcba0987654321"
  }
}
```

## Product Management Examples

### Get All Products

**Request:**
```http
GET /api/products
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "sku": "PROD-001",
      "name": "Laptop Dell XPS 15",
      "description": "High-performance laptop for professionals",
      "price": 1500.00,
      "unit": "pcs",
      "category": "Electronics",
      "supplier_id": 1,
      "created_at": "2025-12-27T10:00:00.000000Z",
      "updated_at": "2025-12-27T10:00:00.000000Z"
    },
    {
      "id": 2,
      "sku": "PROD-002",
      "name": "Wireless Mouse",
      "description": "Ergonomic wireless mouse",
      "price": 25.00,
      "unit": "pcs",
      "category": "Accessories",
      "supplier_id": 2,
      "created_at": "2025-12-27T11:00:00.000000Z",
      "updated_at": "2025-12-27T11:00:00.000000Z"
    }
  ],
  "meta": {
    "total": 2,
    "per_page": 15,
    "current_page": 1
  }
}
```

### Get Single Product

**Request:**
```http
GET /api/products/1
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "sku": "PROD-001",
    "name": "Laptop Dell XPS 15",
    "description": "High-performance laptop for professionals",
    "price": 1500.00,
    "unit": "pcs",
    "category": "Electronics",
    "supplier_id": 1,
    "supplier": {
      "id": 1,
      "name": "Dell Technologies",
      "contact_person": "Jane Smith",
      "email": "jane@dell.com",
      "phone": "+1234567890"
    },
    "stock_levels": [
      {
        "warehouse_id": 1,
        "warehouse_name": "Main Warehouse",
        "quantity": 50,
        "minimum_stock": 10
      }
    ],
    "created_at": "2025-12-27T10:00:00.000000Z",
    "updated_at": "2025-12-27T10:00:00.000000Z"
  }
}
```

### Create Product

**Request:**
```http
POST /api/products
Authorization: Bearer {token}
Content-Type: application/json

{
  "sku": "PROD-003",
  "name": "Mechanical Keyboard",
  "description": "RGB mechanical gaming keyboard",
  "price": 120.00,
  "unit": "pcs",
  "category": "Accessories",
  "supplier_id": 3
}
```

**Response:**
```json
{
  "success": true,
  "message": "Product created successfully",
  "data": {
    "id": 3,
    "sku": "PROD-003",
    "name": "Mechanical Keyboard",
    "description": "RGB mechanical gaming keyboard",
    "price": 120.00,
    "unit": "pcs",
    "category": "Accessories",
    "supplier_id": 3,
    "created_at": "2025-12-27T12:00:00.000000Z",
    "updated_at": "2025-12-27T12:00:00.000000Z"
  }
}
```

### Update Product

**Request:**
```http
PUT /api/products/3
Authorization: Bearer {token}
Content-Type: application/json

{
  "price": 110.00,
  "description": "RGB mechanical gaming keyboard - Special Edition"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Product updated successfully",
  "data": {
    "id": 3,
    "sku": "PROD-003",
    "name": "Mechanical Keyboard",
    "description": "RGB mechanical gaming keyboard - Special Edition",
    "price": 110.00,
    "unit": "pcs",
    "category": "Accessories",
    "supplier_id": 3,
    "created_at": "2025-12-27T12:00:00.000000Z",
    "updated_at": "2025-12-27T12:30:00.000000Z"
  }
}
```

### Delete Product

**Request:**
```http
DELETE /api/products/3
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "message": "Product deleted successfully"
}
```

## Stock Management Examples

### Get Stock Levels

**Request:**
```http
GET /api/stocks
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "product_id": 1,
      "product_name": "Laptop Dell XPS 15",
      "warehouse_id": 1,
      "warehouse_name": "Main Warehouse",
      "quantity": 50,
      "minimum_stock": 10,
      "status": "sufficient",
      "last_updated": "2025-12-27T10:00:00.000000Z"
    },
    {
      "id": 2,
      "product_id": 2,
      "product_name": "Wireless Mouse",
      "warehouse_id": 1,
      "warehouse_name": "Main Warehouse",
      "quantity": 5,
      "minimum_stock": 20,
      "status": "low_stock",
      "last_updated": "2025-12-27T11:00:00.000000Z"
    }
  ]
}
```

### Update Stock Level

**Request:**
```http
PUT /api/stocks/1
Authorization: Bearer {token}
Content-Type: application/json

{
  "quantity": 60,
  "minimum_stock": 15
}
```

**Response:**
```json
{
  "success": true,
  "message": "Stock updated successfully",
  "data": {
    "id": 1,
    "product_id": 1,
    "warehouse_id": 1,
    "quantity": 60,
    "minimum_stock": 15,
    "updated_at": "2025-12-27T13:00:00.000000Z"
  }
}
```

## Transaction Examples

### Create Stock In Transaction

**Request:**
```http
POST /api/transactions
Authorization: Bearer {token}
Content-Type: application/json

{
  "type": "in",
  "warehouse_id": 1,
  "reference_number": "PO-2025-001",
  "notes": "Incoming shipment from supplier",
  "items": [
    {
      "product_id": 1,
      "quantity": 20,
      "unit_price": 1450.00
    },
    {
      "product_id": 2,
      "quantity": 100,
      "unit_price": 23.00
    }
  ]
}
```

**Response:**
```json
{
  "success": true,
  "message": "Transaction created successfully",
  "data": {
    "id": 1,
    "type": "in",
    "warehouse_id": 1,
    "reference_number": "PO-2025-001",
    "notes": "Incoming shipment from supplier",
    "total_amount": 31300.00,
    "status": "completed",
    "items": [
      {
        "id": 1,
        "product_id": 1,
        "product_name": "Laptop Dell XPS 15",
        "quantity": 20,
        "unit_price": 1450.00,
        "subtotal": 29000.00
      },
      {
        "id": 2,
        "product_id": 2,
        "product_name": "Wireless Mouse",
        "quantity": 100,
        "unit_price": 23.00,
        "subtotal": 2300.00
      }
    ],
    "created_at": "2025-12-27T14:00:00.000000Z"
  }
}
```

### Create Stock Out Transaction

**Request:**
```http
POST /api/transactions
Authorization: Bearer {token}
Content-Type: application/json

{
  "type": "out",
  "warehouse_id": 1,
  "reference_number": "SO-2025-001",
  "notes": "Sales order fulfillment",
  "items": [
    {
      "product_id": 1,
      "quantity": 5,
      "unit_price": 1500.00
    }
  ]
}
```

**Response:**
```json
{
  "success": true,
  "message": "Transaction created successfully",
  "data": {
    "id": 2,
    "type": "out",
    "warehouse_id": 1,
    "reference_number": "SO-2025-001",
    "notes": "Sales order fulfillment",
    "total_amount": 7500.00,
    "status": "completed",
    "items": [
      {
        "id": 3,
        "product_id": 1,
        "product_name": "Laptop Dell XPS 15",
        "quantity": 5,
        "unit_price": 1500.00,
        "subtotal": 7500.00
      }
    ],
    "created_at": "2025-12-27T15:00:00.000000Z"
  }
}
```

### Get Transaction History

**Request:**
```http
GET /api/transactions?type=in&start_date=2025-12-01&end_date=2025-12-31
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "type": "in",
      "warehouse_id": 1,
      "warehouse_name": "Main Warehouse",
      "reference_number": "PO-2025-001",
      "total_amount": 31300.00,
      "items_count": 2,
      "status": "completed",
      "created_at": "2025-12-27T14:00:00.000000Z"
    }
  ],
  "meta": {
    "total": 1,
    "per_page": 15,
    "current_page": 1
  }
}
```

## Error Response Examples

### Validation Error

```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "email": [
      "The email field is required."
    ],
    "password": [
      "The password must be at least 8 characters."
    ]
  }
}
```

### Authentication Error

```json
{
  "success": false,
  "message": "Unauthenticated",
  "error": "Token not provided or invalid"
}
```

### Authorization Error

```json
{
  "success": false,
  "message": "Forbidden",
  "error": "You do not have permission to perform this action"
}
```

### Resource Not Found

```json
{
  "success": false,
  "message": "Resource not found",
  "error": "Product with ID 999 not found"
}
```

### Server Error

```json
{
  "success": false,
  "message": "Internal server error",
  "error": "An unexpected error occurred. Please try again later."
}
```

## cURL Examples

### Login with cURL

```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "SecureP@ss123"
  }'
```

### Get Products with cURL

```bash
curl -X GET http://localhost:8000/api/products \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json"
```

### Create Product with cURL

```bash
curl -X POST http://localhost:8000/api/products \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "sku": "PROD-004",
    "name": "USB Cable",
    "description": "USB-C to USB-A cable",
    "price": 10.00,
    "unit": "pcs",
    "category": "Accessories",
    "supplier_id": 1
  }'
```

---

For the complete Postman collection with all endpoints, import [docs/postman_collection.json](postman_collection.json).
