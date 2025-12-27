# 📦 Inventory Management API

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Docker-Ready-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker">
</p>

<p align="center">
<a href="https://github.com/FarhanPerdana123/inventory-management-api/actions"><img src="https://github.com/FarhanPerdana123/inventory-management-api/workflows/CI/CD%20Pipeline/badge.svg" alt="Build Status"></a>
<a href="https://github.com/FarhanPerdana123/inventory-management-api/blob/main/LICENSE"><img src="https://img.shields.io/github/license/FarhanPerdana123/inventory-management-api" alt="License"></a>
<a href="https://github.com/FarhanPerdana123/inventory-management-api/releases"><img src="https://img.shields.io/github/v/release/FarhanPerdana123/inventory-management-api" alt="Latest Release"></a>
</p>

---

## 📖 About

A **production-ready RESTful API** for comprehensive inventory management built with Laravel 11. This system enables efficient management of products, suppliers, warehouses, stock levels, and transactions with enterprise-grade **role-based access control (RBAC)** and automated CI/CD pipeline.

**Perfect for:** E-commerce platforms, warehouse management systems, retail operations, and supply chain management.

## ✨ Key Features

### Core Functionality

| Feature | Description |
|---------|-------------|
| 🔐 **Authentication** | Secure JWT token-based authentication with Laravel Sanctum |
| 👥 **RBAC** | Role-based access control (Admin, Manager, Staff) |
| 📦 **Product Management** | Complete CRUD with SKU, categorization, and pricing |
| 🏭 **Supplier Management** | Supplier tracking with contact information |
| 🏢 **Multi-Warehouse** | Support for multiple warehouse locations |
| 📊 **Stock Tracking** | Real-time inventory with minimum stock alerts |
| 💼 **Transactions** | Stock in/out operations with full audit trail |
| 📈 **Reporting** | Inventory reports and analytics |
| 🔄 **CI/CD** | Automated testing and deployment pipeline |
| 🐳 **Docker** | Containerized deployment ready |

### Advanced Features
- ✅ Search & filtering with pagination
- ✅ Automatic stock level updates
- ✅ Transaction history tracking
- ✅ Low stock alerts
- ✅ API rate limiting
- ✅ Comprehensive error handling
- ✅ Database seeding for testing
- ✅ API documentation with examples

## 🛠️ Tech Stack

- **Framework:** Laravel 11.x
- **Language:** PHP 8.2+
- **Database:** MySQL 8.0
- **Authentication:** Laravel Sanctum
- **API:** RESTful API
- **Containerization:** Docker & Docker Compose
- **Web Server:** Nginx
- **CI/CD:** GitHub Actions
- **Testing:** PHPUnit
- **Code Quality:** PHPStan, Laravel Pint, PHP CodeSniffer
### Backend
| Technology | Version | Purpose |
|------------|---------|---------|
| **Laravel** | 11.x | PHP framework |
| **PHP** | 8.2+ | Programming language |
| **MySQL** | 8.0 | Relational database |
| **Laravel Sanctum** | Latest | API authentication |
| **Eloquent ORM** | Built-in | Database operations |

### DevOps & Tools
| Technology | Purpose |
|------------|---------|
| **Docker** | Containerization |
| **Docker Compose** | Multi-container orchestration |
| **Nginx** | Web server |
| **GitHub Actions** | CI/CD automation |
| **PHPUnit** | Unit & feature testing |

### Code Quality
| Tool | Purpose |
|------|---------|
| **PHPStan** | Static analysis (Level 5) |
| **Laravel Pint** | Code formatting |
| **PHP CodeSniffer** | PSR-12 compliance |
| **Composer Audit** | Security scanning |

### Installation

#### Method 1: Local Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/FarhanPerdana123/inventory-management-api.git
   cd inventory-api
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   Edit `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=inventory_db
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

6. **Start the server**
   ```bash
   php artisan serve
   ```

The API will be available at `http://localhost:8000`

#### Method 2: Docker Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/FarhanPerdana123/inventory-management-api.git
   cd inventory-api
   ```

2. **Start Docker containers**
   ```bash
   docker-compose up -d
   ```

3. **Install dependencies**
   ```bash
   docker-compose exec app composer install
   ```

---

## 🗄️ Database Schema (ERD)

### Entity Relationship Diagram

```
┌─────────────┐         ┌──────────────┐         ┌─────────────┐
│    Users    │────────▶│  User_Roles  │◀────────│    Roles    │
└─────────────┘         └──────────────┘         └─────────────┘
      │                                                  │
      │                                                  │
      │ created_by                                       │
      ▼                                                  │
┌──────────────┐                                        │
│ Transactions │                                        │
└──────┬───────┘                                        │
       │                                                 │
       │                                                 │
       │            ┌─────────────┐                     │
       └───────────▶│   Products  │◀────────────────────┘
       │            └──────┬──────┘                      
       │                   │                             
       │                   │                             
       │            ┌──────▼───────┐                    
       │            │   Suppliers  │                    
       │            └──────────────┘                    
       │                                                 
**Step 1: Register**
```bash
POST /api/auth/register
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "SecureP@ss123",
  "password_confirmation": "SecureP@ss123"
}
```

**Step 2: Login**
```bash
POST /api/auth/login
{
  "email": "john@example.com",
  "password": "SecureP@ss123"
}

Response:
{
  "token": "1|abcdefghijklmnopqrstuvwxyz",
  "user": { ... }
}
```

**Step 3: Access Protected Routes**
```bash
GET /api/products
Headers:
  Authorization: Bearer 1|abcdefghijklmnopqrstuvwxyz
```

---

## 📚 API Overviewany-to-Many: Users ↔ Roles (via user_roles)
- One-to-Many: Transaction → TransactionItems, Product → Stocks

For detailed schema, see [docs/erd.md](docs/erd.md)

---

## 🏗️ System Architecture

```
┌─────────────────────────────────────────────────┐
│              Client Applications                 │
│     (Web, Mobile, Third-party Services)         │
└────────────────────┬────────────────────────────┘
                     │ HTTPS/REST
                     ▼
┌─────────────────────────────────────────────────┐
│            Nginx (Reverse Proxy)                 │
│  • SSL/TLS Termination                          │
│  • Rate Limiting                                │
│  • Load Balancing                               │
└────────────────────┬────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────┐
│           Laravel API Application                │
│                                                  │
│  ┌──────────────┐  ┌──────────────┐            │
│  │ Controllers  │─▶│   Services   │            │
│  └──────────────┘  └──────┬───────┘            │
│                            │                     │
│  ┌─────────────────────────▼────────────────┐  │
│  │         Middleware Layer                  │  │
│  │  • Authentication (Sanctum)              │  │
│  │  • Authorization (RBAC)                  │  │
│  │  • Validation                            │  │
│  └─────────────────────┬────────────────────┘  │
│                        │                         │
│  ┌─────────────────────▼────────────────────┐  │
│  │         Eloquent ORM                      │  │
│  └─────────────────────┬────────────────────┘  │
└────────────────────────┼────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────┐
│              MySQL Database                      │
│   • Products  • Suppliers  • Warehouses         │
│   • Stocks    • Transactions • Users            │
└─────────────────────────────────────────────────┘
```

See detailed architecture: [docs/ARCHITECTURE.md](docs/ARCHITECTURE.md)

---

## 🔐 Authentication

This API uses **Laravel Sanctum** for token-based authentication.

### Authentication Flow

```
1. Register/Login → 2. Receive Token → 3. Use Token in Headers → 4. Access Protected Routes
```

### Quick Example*
   ```bash
   docker-compose exec app cp .env.example .env
   docker-compose exec app php artisan key:generate
   ```

5. **Run migrations**
   ```bash
   docker-compose exec app php artisan migrate --seed
   ```

The API will be available at `http://localhost:8080`

For detailed Docker instructions, see [DOCKER-README.md](DOCKER-README.md)

## 📚 API Documentation

### Base URL
```
http://localhost:8000/api
```

### Authentication
Most endpoints require authentication. Include the token in the Authorization header:
```
Authorization: Bearer {your-token}
```

### Quick Start Example

```bash
# 1. Register a new user
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John Doe","email":"john@example.com","password":"SecureP@ss123","password_confirmation":"SecureP@ss123"}'

# 2. Login and get token
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"john@example.com","password":"SecureP@ss123"}'

# 3. Use token to access protected endpoints
curl -X GET http://localhost:8000/api/products \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Available Endpoints

#### Authentication
- `POST /api/register` - Register new user
- `POST /api/login` - User login
- `POST /api/logout` - User logout

#### Products
- `GET /api/products` - List all products (supports search, sort, pagination)
- `POST /api/products` - Create product
- `GET /api/products/{id}` - Get product details
- `PUT /api/products/{id}` - Update product
- `DELETE /api/products/{id}` - Delete product

#### Suppliers
- `GET /api/suppliers` - List all suppliers
- `POST /api/suppliers` - Create supplier
- `GET /api/suppliers/{id}` - Get supplier details
- `PUT /api/suppliers/{id}` - Update supplier
- `DELETE /api/suppliers/{id}` - Delete supplier

#### Warehouses
- `GET /api/warehouses` - List all warehouses
**📚 Complete Documentation:**
- 📖 [API Examples with cURL](docs/API_EXAMPLES.md)
- 📮 [Postman Collection](docs/postman_collection.json)
- 📋 [Full API Reference](API-README.md)

---

## 👥 Roles & Permissions

**Pipeline Stages:**

```
┌─────────┐   ┌──────────┐   ┌──────────┐   ┌─────────┐
│  BUILD  │──▶│   TEST   │──▶│   TEST   │──▶│ DEPLOY  │
│         │   │ QUALITY  │   │ SECURITY │   │         │
└─────────┘   └──────────┘   └──────────┘   └─────────┘
                    │              │
                    ▼              ▼
              ┌──────────┐   ┌──────────┐
              │   TEST   │   │  Reports │
              │   UNIT   │   │  Upload  │
              └──────────┘   └──────────┘
```

**Automated Checks:**
- ✅ Code style (PSR-12)
- ✅ Static analysis (PHPStan)
- ✅ Security audit
- ✅ Unit & feature tests
- ✅ Code coverage report

See: [docs/CI-CD.md](docs/CI-CD.md)

---

## 🗺️ Roadmap

### ✅ Completed (v1.0)
- [x] Core inventory management
- [x] Authentication & RBAC
- [x] Multi-warehouse support
- [x] Transaction management
- [x] Docker containerization
- [x] CI/CD pipeline
- [x] Comprehensive documentation

### 🚧 In Progress
- [ ] Advanced reporting & analytics
- [ ] Export functionality (Excel, PDF)
- [ ] Email notifications

### 📋 Planned (v2.0)
- [ ] Barcode scanning support
- [ ] Mobile application (Flutter)
- [ ] Multi-language support (i18n)
- [ ] GraphQL API endpoint
- [ ] Webhook integrations
- [ ] Real-time notifications (WebSocket)
- [ ] Advanced search (Elasticsearch)
- [ ] Audit logging system

### 💡 Future Considerations
- [ ] Machine learning for demand forecasting
- [ ] Mobile barcode scanner app
- [ ] Third-party integrations (Shopify, WooCommerce)
- [ ] Multi-currency support
- [ ] Advanced analytics dashboard

---

## 🤝 Contributing

Contributions are welcome! Please read our [Contributing Guidelines](CONTRIBUTING.md) first.

### Quick Start for Contributors

1. Fork the repository
2. Create a feature branch: `git checkout -b feat/amazing-feature`
3. Commit your changes: `git commit -m 'feat: add amazing feature'`
4. Push to the branch: `git push origin feat/amazing-feature`
5. Open a Pull Request

**Read more:**
- [Code of Conduct](CODE_OF_CONDUCT.md)
- [Development Workflow](CONTRIBUTING.md#development-workflow)
- [Coding Standards](CONTRIBUTING.md#coding-standards)

---

## 📄 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

```
MIT License - You are free to:
✓ Use commercially
✓ Modify
✓ Distribute
✓ Private use
```

---

## 📞 Contact & Support

| Channel | Link |
|---------|------|
| 🐛 Issues | [GitHub Issues](https://github.com/FarhanPerdana123/inventory-management-api/issues) |
| 💬 Discussions | [GitHub Discussions](https://github.com/FarhanPerdana123/inventory-management-api/discussions) |
| 📧 Email | muhammadfarhanperdana@mail.ugm.ac.id |
| 🔒 Security | [Security Policy](SECURITY.md) |

---

## 📚 Documentation Index

| Document | Description |
|----------|-------------|
| [API Examples](docs/API_EXAMPLES.md) | Complete request/response examples |
| [Architecture](docs/ARCHITECTURE.md) | System design & patterns |
| [CI/CD Guide](docs/CI-CD.md) | Pipeline documentation |
| [Database ERD](docs/erd.md) | Database schema |
| [Docker Guide](DOCKER-README.md) | Containerization guide |
| [Contributing](CONTRIBUTING.md) | How to contribute |
| [Changelog](CHANGELOG.md) | Version history |
| [Security](SECURITY.md) | Security policy |
| [Code of Conduct](CODE_OF_CONDUCT.md) | Community guidelines |

---

## 🙏 Acknowledgments

- Built with [Laravel](https://laravel.com/) - The PHP Framework for Web Artisans
- Powered by [Laravel Sanctum](https://laravel.com/docs/sanctum) for authentication
- Containerized with [Docker](https://www.docker.com/)
- Automated with [GitHub Actions](https://github.com/features/actions)

---

## ⭐ Show Your Support

If this project helped you, please give it a ⭐️!

---

<p align="center">
  <strong>Made with ❤️ for the Laravel Community</strong>
  <br>
  <sub>Built by developers, for developers</sub>

│       └── TransactionItem.php
├── database/
│   ├── migrations/
│   │   ├── 2025_12_22_074639_roles.php
│   │   ├── 2025_12_22_074718_products.php
│   │   ├── 2025_12_22_074731_suppliers.php
│   │   └── ...
│   └── seeders/
│       ├── RoleSeeder.php
│       ├── UserSeeder.php
│       └── ProductSeeder.php
├── routes/
│   ├── api.php              # API routes
│   └── web.php
├── tests/
│   ├── Feature/
│   │   ├── AuthTest.php
│   │   ├── ProductTest.php
│   │   └── TransactionTest.php
│   └── Unit/
├── docs/
│   ├── API_EXAMPLES.md      # Request/response examples
│   ├── ARCHITECTURE.md      # System architecture
│   ├── CI-CD.md            # CI/CD documentation
│   ├── erd.md              # Database schema
│   └── postman_collection.json
├── .github/
│   ├── workflows/
│   │   └── ci-cd.yml       # GitHub Actions pipeline
│   ├── ISSUE_TEMPLATE/
│   └── pull_request_template.md
├── docker-compose.yml
├── Dockerfile
├── nginx.conf
├── CONTRIBUTING.md
├── CODE_OF_CONDUCT.md
├── SECURITY.md
├── CHANGELOG.md
└── README.md
```

---

## 🧪 Testing

Run the test suite:

```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage

# Run specific test file
php artisan test tests/Feature/ProductTest.php

# Run specific test method
php artisan test --filter test_user_can_create_product
```

**Test Coverage:**
- ✅ Authentication tests
- ✅ Authorization tests
- ✅ CRUD operations tests
- ✅ Business logic tests
- ✅ API validation tests

---
- `GET /api/stocks` - List all stock levels
- `POST /api/stocks` - Create stock record
- `GET /api/stocks/{id}` - Get stock details
- `PUT /api/stocks/{id}` - Update stock level
- `DELETE /api/stocks/{id}` - Delete stock record

#### Transactions
- `GET /api/transactions` - List all transactions
- `POST /api/transactions` - Create transaction (stock in/out)
- `GET /api/transactions/{id}` - Get transaction details
- `PUT /api/transactions/{id}` - Update transaction
- `DELETE /api/transactions/{id}` - Delete transaction

### Documentation Resources

- 📖 **[API Examples](docs/API_EXAMPLES.md)** - Detailed request/response examples
- 📮 **[Postman Collection](docs/postman_collection.json)** - Import into Postman
- 📋 **[Complete API Guide](API-README.md)** - Full API reference
- 🏗️ **[Architecture](docs/ARCHITECTURE.md)** - System design and patterns

## 🔄 CI/CD Pipeline

This project uses GitHub Actions for automated CI/CD with the following stages:

1. **Build** - Docker image creation and registry push
2. **Test Quality** - Code style and static analysis
3. **Test Security** - Dependency vulnerability scanning
4. **Test Unit** - Automated testing with coverage
5. **Deploy** - Automated deployment to staging/production

For detailed CI/CD documentation, see [docs/CI-CD.md](docs/CI-CD.md)

## 🧪 Testing

Run tests with PHPUnit:

```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage

# Run specific test file
php artisan test tests/Feature/ProductTest.php
```

## 📊 Database Schema

For database structure and relationships, see [docs/erd.md](docs/erd.md)

## 🤝 Contributing

We welcome contributions! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details on:
- Code of conduct
- Development workflow
- Coding standards
- Pull request process
- Issue reporting

## 📝 Changelog

See [CHANGELOG.md](CHANGELOG.md) for a history of changes to this project.

## 📄 License

This project is open-sourced software licensed under the [MIT License](LICENSE).

## 🔒 Security

If you discover a security vulnerability, please send an email to security@example.com. All security vulnerabilities will be promptly addressed.

## 👥 Authors & Contributors

- **Development Team** - Initial work and maintenance
- See [CONTRIBUTING.md](CONTRIBUTING.md) for how to contribute

## 🙏 Acknowledgments

- Built with [Laravel](https://laravel.com/)
- Inspired by modern inventory management systems
- Thanks to all contributors

## 📚 Additional Documentation

- 📖 [API Examples](docs/API_EXAMPLES.md) - Request/response examples
- 🏗️ [Architecture](docs/ARCHITECTURE.md) - System design
- 🔄 [CI/CD Guide](docs/CI-CD.md) - Pipeline documentation
- 🔒 [Security Policy](SECURITY.md) - Security guidelines
- 📋 [Database ERD](docs/erd.md) - Database structure
- 🤝 [Code of Conduct](CODE_OF_CONDUCT.md) - Community guidelines

## 📞 Support

- 📫 **Email:** muhammadfarhanperdana@mail.ugm.ac.id
- 🐛 **Issues:** [GitHub Issues](https://github.com/FarhanPerdana123/inventory-management-api/issues)
- 💬 **Discussions:** [GitHub Discussions](https://github.com/FarhanPerdana123/inventory-management-api/discussions)
- 📖 **Documentation:** [Wiki](https://github.com/FarhanPerdana123/inventory-management-api/wiki)

## 🗺️ Roadmap

- [ ] Export functionality (Excel, PDF)
- [ ] Advanced reporting and analytics
- [ ] Email notifications for low stock
- [ ] Barcode scanning support
- [ ] Mobile application
- [ ] Multi-language support
- [ ] GraphQL API support
- [ ] Webhook integrations

---

<p align="center">Made with ❤️ using Laravel</p>

