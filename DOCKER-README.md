# Inventory API - Docker Setup

## 🚀 Cara Menjalankan

### 1. Start Docker Containers
```bash
docker-compose up -d
```

### 2. Copy .env dan Setup Database
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Jalankan Migration
```bash
php artisan migrate
```

### 4. (Optional) Seed Data
```bash
php artisan db:seed
```

## 📦 Services

- **MySQL**: Port `3306`
  - Database: `inventory_db`
  - User: `inventory_user`
  - Password: `inventory_password`
  - Root Password: `root`

- **phpMyAdmin**: [http://localhost:8080](http://localhost:8080)
  - Server: `mysql`
  - Username: `root` atau `inventory_user`
  - Password: `root` atau `inventory_password`

## 🛠️ Commands

```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# View logs
docker-compose logs -f

# Restart containers
docker-compose restart

# Remove containers and volumes
docker-compose down -v
```

## 📝 Konfigurasi .env

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_db
DB_USERNAME=inventory_user
DB_PASSWORD=inventory_password
```
