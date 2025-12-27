# System Architecture

## Overview

This document describes the architecture of the Inventory API system, including components, data flow, and design patterns.

## High-Level Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                         Client Layer                             │
│  (Web Apps, Mobile Apps, Third-party Integrations)              │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         │ HTTPS/REST
                         │
┌────────────────────────▼────────────────────────────────────────┐
│                      API Gateway Layer                           │
│                    (Nginx Web Server)                            │
│  - Rate Limiting                                                 │
│  - SSL/TLS Termination                                          │
│  - Request Routing                                              │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         │
┌────────────────────────▼────────────────────────────────────────┐
│                   Application Layer                              │
│                   (Laravel 11 API)                               │
│                                                                  │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐         │
│  │              │  │              │  │              │         │
│  │ Controllers  │──│  Services    │──│ Repositories │         │
│  │              │  │              │  │              │         │
│  └──────────────┘  └──────────────┘  └──────────────┘         │
│                                                                  │
│  ┌──────────────────────────────────────────────────┐          │
│  │           Middleware Layer                        │          │
│  │  - Authentication (Sanctum)                      │          │
│  │  - Authorization (Roles)                         │          │
│  │  - CORS                                          │          │
│  │  - Validation                                    │          │
│  └──────────────────────────────────────────────────┘          │
│                                                                  │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         │ Eloquent ORM
                         │
┌────────────────────────▼────────────────────────────────────────┐
│                     Data Layer                                   │
│                   (MySQL Database)                               │
│                                                                  │
│  ┌─────────┐  ┌──────────┐  ┌───────────┐  ┌────────────┐     │
│  │ Users   │  │ Products │  │ Suppliers │  │ Warehouses │     │
│  └─────────┘  └──────────┘  └───────────┘  └────────────┘     │
│                                                                  │
│  ┌─────────┐  ┌──────────────┐  ┌──────────────────┐          │
│  │ Stocks  │  │ Transactions │  │ TransactionItems │          │
│  └─────────┘  └──────────────┘  └──────────────────┘          │
│                                                                  │
└──────────────────────────────────────────────────────────────────┘
```

## Component Architecture

### 1. API Gateway (Nginx)

**Responsibilities:**
- SSL/TLS termination
- Load balancing
- Static file serving
- Request routing to PHP-FPM
- Rate limiting
- DDoS protection

### 2. Application Layer (Laravel)

#### 2.1 HTTP Layer
```
routes/api.php
    ├── Authentication Routes
    ├── Product Routes
    ├── Supplier Routes
    ├── Warehouse Routes
    ├── Stock Routes
    └── Transaction Routes
```

#### 2.2 Controller Layer
```
app/Http/Controllers/
    ├── AuthController.php
    ├── ProductController.php
    ├── SupplierController.php
    ├── WarehouseController.php
    ├── StockController.php
    └── TransactionController.php
```

**Pattern:** Thin controllers - delegate business logic to services

#### 2.3 Service Layer (Business Logic)
```
app/Services/
    ├── AuthService.php
    ├── ProductService.php
    ├── StockService.php
    └── TransactionService.php
```

**Responsibilities:**
- Business logic implementation
- Data validation
- Complex operations
- Transaction management

#### 2.4 Model Layer (Data Access)
```
app/Models/
    ├── User.php
    ├── Role.php
    ├── Product.php
    ├── Supplier.php
    ├── Warehouse.php
    ├── Stock.php
    ├── Transaction.php
    └── TransactionItem.php
```

**Pattern:** Active Record (Eloquent ORM)

### 3. Database Layer (MySQL)

**Design Pattern:** Relational Database with normalized tables

## Request Flow

```
1. Client Request
   │
   ▼
2. Nginx (API Gateway)
   │
   ▼
3. Laravel Route Matching
   │
   ▼
4. Middleware Pipeline
   ├── CORS Middleware
   ├── Authentication Middleware (Sanctum)
   ├── Authorization Middleware
   └── Validation Middleware
   │
   ▼
5. Controller
   │
   ▼
6. Service Layer (Business Logic)
   │
   ▼
7. Model/Repository (Data Access)
   │
   ▼
8. Database Query
   │
   ▼
9. Response Formation
   │
   ▼
10. JSON Response to Client
```

## Design Patterns

### 1. MVC (Model-View-Controller)
- **Model**: Eloquent models for data representation
- **View**: JSON responses (API resources)
- **Controller**: HTTP request handling

### 2. Repository Pattern (Optional)
```php
interface ProductRepositoryInterface {
    public function find($id);
    public function all();
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
```

### 3. Service Layer Pattern
```php
class StockService {
    public function adjustStock($productId, $warehouseId, $quantity);
    public function checkLowStock();
    public function transferStock($from, $to, $productId, $quantity);
}
```

### 4. Factory Pattern
```php
// Database seeding
UserFactory::class
ProductFactory::class
```

### 5. Observer Pattern
```php
// Model events
Product::created(function($product) {
    // Initialize stock records
});
```

## Authentication Flow

```
┌─────────┐
│ Client  │
└────┬────┘
     │
     │ 1. POST /api/login
     │    (email, password)
     ▼
┌─────────────────┐
│ AuthController  │
└────┬────────────┘
     │
     │ 2. Validate credentials
     ▼
┌─────────────────┐
│  User Model     │
└────┬────────────┘
     │
     │ 3. Create token
     ▼
┌─────────────────┐
│ Sanctum Token   │
└────┬────────────┘
     │
     │ 4. Return token
     ▼
┌─────────┐
│ Client  │
└─────────┘
     │
     │ 5. Subsequent requests
     │    Header: Authorization: Bearer {token}
     ▼
┌─────────────────┐
│ Auth Middleware │
└────┬────────────┘
     │
     │ 6. Validate token
     ▼
┌─────────────────┐
│ Protected Route │
└─────────────────┘
```

## Authorization Model

### Role-Based Access Control (RBAC)

```
┌─────────────────────────────────────────┐
│              Roles                      │
├─────────────────────────────────────────┤
│  Admin    │ Manager   │ Staff           │
├───────────┼───────────┼─────────────────┤
│  Full     │ Limited   │ Read + Limited  │
│  Access   │ Write     │ Write           │
└─────────────────────────────────────────┘
```

**Permissions Matrix:**

| Action                | Admin | Manager | Staff |
|-----------------------|-------|---------|-------|
| Create Product        | ✓     | ✓       | ✗     |
| Update Product        | ✓     | ✓       | ✗     |
| Delete Product        | ✓     | ✗       | ✗     |
| View Product          | ✓     | ✓       | ✓     |
| Create Transaction    | ✓     | ✓       | ✓     |
| Delete Transaction    | ✓     | ✓       | ✗     |
| Manage Users          | ✓     | ✗       | ✗     |
| View Reports          | ✓     | ✓       | ✓     |

## Data Flow - Stock Transaction Example

```
1. User initiates transaction (Stock In/Out)
   │
   ▼
2. TransactionController receives request
   │
   ▼
3. Validation (Request class)
   ├── Check product exists
   ├── Check warehouse exists
   ├── Check sufficient stock (for Stock Out)
   └── Validate quantities
   │
   ▼
4. TransactionService processes business logic
   │
   ├─▶ Create Transaction record
   │   │
   │   └─▶ Transaction Model
   │
   ├─▶ Create TransactionItem records
   │   │
   │   └─▶ TransactionItem Model
   │
   └─▶ Update Stock levels
       │
       └─▶ Stock Model
   │
   ▼
5. Database Transaction (ACID)
   ├── BEGIN
   ├── INSERT into transactions
   ├── INSERT into transaction_items
   ├── UPDATE stocks
   └── COMMIT
   │
   ▼
6. Return success response
```

## Scalability Considerations

### Horizontal Scaling
```
┌──────────────┐
│ Load Balancer│
└──────┬───────┘
       │
   ┌───┴───┬───────────┬──────────┐
   │       │           │          │
   ▼       ▼           ▼          ▼
[API 1] [API 2]   [API 3]    [API N]
   │       │           │          │
   └───┬───┴───────────┴──────────┘
       │
       ▼
┌──────────────┐
│   Database   │
│  (Master)    │
└──────┬───────┘
       │
   ┌───┴───┐
   │       │
   ▼       ▼
[Read    [Read
Replica] Replica]
```

### Caching Strategy
```
┌─────────┐
│ Client  │
└────┬────┘
     │
     ▼
┌─────────────┐
│ Application │
└────┬────────┘
     │
     ├─▶ Check Cache (Redis)
     │   ├── Hit: Return cached data
     │   └── Miss: Query database
     │
     └─▶ Database
         │
         └─▶ Store in cache
```

## Security Architecture

### Defense in Depth

```
Layer 1: Network Security
  ├── Firewall
  ├── DDoS Protection
  └── SSL/TLS

Layer 2: Application Gateway
  ├── Rate Limiting
  ├── Request Validation
  └── WAF (Web Application Firewall)

Layer 3: Application Security
  ├── Authentication (Sanctum)
  ├── Authorization (RBAC)
  ├── CSRF Protection
  ├── Input Validation
  └── Output Encoding

Layer 4: Data Security
  ├── Encrypted Connections
  ├── Password Hashing
  ├── SQL Injection Prevention
  └── Data Encryption at Rest
```

## Monitoring & Logging

```
Application Logs
  ├── Error Logs (storage/logs/laravel.log)
  ├── Access Logs (Nginx)
  ├── Security Events
  └── Performance Metrics

Monitoring Stack
  ├── Application Performance Monitoring
  ├── Database Query Monitoring
  ├── API Response Times
  └── Error Rate Tracking
```

## Deployment Architecture

### Docker Containerization

```
┌─────────────────────────────────────────┐
│          Docker Compose Stack           │
├─────────────────────────────────────────┤
│                                         │
│  ┌────────────┐  ┌─────────────┐       │
│  │    Nginx   │  │   PHP-FPM   │       │
│  │ Container  │──│  Container  │       │
│  └────────────┘  └─────────────┘       │
│                         │               │
│                         │               │
│                  ┌──────▼──────┐        │
│                  │    MySQL    │        │
│                  │  Container  │        │
│                  └─────────────┘        │
│                                         │
└─────────────────────────────────────────┘
```

## Technology Stack Details

| Component          | Technology        | Version |
|--------------------|-------------------|---------|
| Language           | PHP               | 8.2+    |
| Framework          | Laravel           | 11.x    |
| Database           | MySQL             | 8.0     |
| Authentication     | Laravel Sanctum   | Latest  |
| Web Server         | Nginx             | 1.20+   |
| Container Runtime  | Docker            | 20.10+  |
| Cache (Optional)   | Redis             | 7.0+    |
| Queue (Optional)   | Redis/Database    | -       |

## Future Enhancements

1. **Caching Layer**: Redis for session and data caching
2. **Message Queue**: For async processing (email, reports)
3. **Search Engine**: Elasticsearch for advanced product search
4. **File Storage**: S3 or MinIO for file uploads
5. **Real-time**: WebSockets for live inventory updates
6. **Microservices**: Split into smaller services as needed
7. **GraphQL**: Alternative API endpoint
8. **Event Sourcing**: For audit trail and history

---

**Last Updated**: December 27, 2025
