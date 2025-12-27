# Docker Setup

## 🚀 Quick Start

1. **Build dan jalankan containers:**
```bash
docker-compose up -d --build
```

2. **Masuk ke container app untuk setup database:**
```bash
docker-compose exec app php artisan migrate:fresh --seed
```

3. **Akses aplikasi:**
- API: http://localhost:8000/api
- phpMyAdmin: http://localhost:8080

## 📦 Containers

- **app**: PHP 8.2-FPM (Laravel application)
- **nginx**: Nginx web server (port 8000)
- **mysql**: MySQL 8.0 database (port 3306)
- **phpmyadmin**: Database admin interface (port 8080)

## 🔧 Perintah Docker

```bash
# Start semua containers
docker-compose up -d

# Build ulang (setelah update Dockerfile)
docker-compose up -d --build

# Stop semua containers
docker-compose down

# Lihat logs
docker-compose logs -f app

# Masuk ke container app (untuk artisan commands)
docker-compose exec app bash

# Jalankan artisan commands
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
docker-compose exec app php artisan cache:clear

# Restart service tertentu
docker-compose restart app nginx
```

## 🔑 Database Access

**MySQL:**
- Host: localhost (atau `mysql` dari dalam container)
- Port: 3306
- Database: inventory_db
- Username: root
- Password: root

**phpMyAdmin:**
- URL: http://localhost:8080
- Server: mysql
- Username: root
- Password: root

## 📝 Testing API

Setelah containers jalan, test API menggunakan Postman:

1. Import: `docs/postman_collection.json`
2. Login dengan:
   - Email: admin@inventory.com
   - Password: password
3. Token akan auto-save untuk request selanjutnya

## 🐛 Troubleshooting

**Permission error:**
```bash
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
docker-compose exec app chmod -R 775 storage bootstrap/cache
```

**Clear cache:**
```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
```

**Rebuild containers:**
```bash
docker-compose down
docker-compose up -d --build
```
