# GitHub Secrets Configuration Guide

## Required Secrets untuk Deployment

Untuk mengaktifkan deployment otomatis, Anda perlu mengkonfigurasi secrets berikut di GitHub repository Anda.

### Cara Menambahkan Secrets

1. Buka repository GitHub Anda
2. Klik **Settings** → **Secrets and variables** → **Actions**
3. Klik **New repository secret**
4. Masukkan nama dan value untuk setiap secret

---

## Production Deployment Secrets

### PRODUCTION_SERVER
- **Deskripsi**: Hostname atau IP address server production
- **Contoh**: `production.example.com` atau `192.168.1.100`

### PRODUCTION_USER
- **Deskripsi**: Username SSH untuk login ke server production
- **Contoh**: `ubuntu`, `deployer`, atau `root`

### PRODUCTION_PATH
- **Deskripsi**: Path lengkap ke direktori aplikasi di server production
- **Contoh**: `/var/www/html/inventory-api` atau `/home/deployer/inventory-api`

### SSH_PRIVATE_KEY
- **Deskripsi**: Private SSH key untuk autentikasi ke server
- **Cara generate**:
  ```bash
  # Generate SSH key pair
  ssh-keygen -t ed25519 -C "github-actions-deploy" -f ./deploy_key
  
  # Copy public key ke server
  ssh-copy-id -i ./deploy_key.pub user@server
  
  # Gunakan isi deploy_key sebagai secret
  cat ./deploy_key
  ```

### SSH_PORT (Optional)
- **Deskripsi**: Port SSH (default: 22)
- **Contoh**: `22` atau `2222`

---

## Staging Deployment Secrets

### STAGING_SERVER
- **Deskripsi**: Hostname atau IP address server staging
- **Contoh**: `staging.example.com`

### STAGING_USER
- **Deskripsi**: Username SSH untuk login ke server staging
- **Contoh**: `ubuntu`, `deployer`

### STAGING_PATH
- **Deskripsi**: Path lengkap ke direktori aplikasi di server staging
- **Contoh**: `/var/www/html/inventory-api-staging`

---

## Variables (Optional)

Untuk mengkonfigurasi **Variables** (bukan secrets):
1. Buka **Settings** → **Secrets and variables** → **Actions**
2. Pilih tab **Variables**
3. Klik **New repository variable**

### PRODUCTION_URL
- **Deskripsi**: URL production aplikasi
- **Contoh**: `https://api.example.com`

### STAGING_URL
- **Deskripsi**: URL staging aplikasi
- **Contoh**: `https://staging-api.example.com`

---

## Checklist Setup

- [ ] PRODUCTION_SERVER
- [ ] PRODUCTION_USER
- [ ] PRODUCTION_PATH
- [ ] SSH_PRIVATE_KEY
- [ ] SSH_PORT (optional)
- [ ] STAGING_SERVER
- [ ] STAGING_USER
- [ ] STAGING_PATH
- [ ] PRODUCTION_URL (variable)
- [ ] STAGING_URL (variable)

---

## Testing Secrets

Setelah menambahkan secrets, test dengan:

1. Push ke branch `main` untuk trigger production deployment
2. Push ke branch `develop` untuk trigger staging deployment
3. Cek workflow logs di tab **Actions**

---

## Troubleshooting

### Error: "missing server host"
- Pastikan `PRODUCTION_SERVER` atau `STAGING_SERVER` sudah dikonfigurasi
- Periksa tidak ada typo di nama secret
- Secret harus match dengan nama yang digunakan di workflow file

### Error: SSH Connection Failed
- Verifikasi `SSH_PRIVATE_KEY` valid dan sesuai dengan public key di server
- Pastikan `SSH_PORT` benar (default: 22)
- Cek firewall server mengizinkan koneksi dari GitHub Actions IP

### Error: Permission Denied
- Pastikan user memiliki akses ke directory `PRODUCTION_PATH` atau `STAGING_PATH`
- Periksa user memiliki permission untuk menjalankan `git pull`
- Untuk `systemctl restart`, user mungkin perlu sudo access

---

## Server Setup Requirements

Server production/staging harus sudah di-setup dengan:

1. **Git**: untuk git pull
2. **Composer**: untuk composer install
3. **PHP 8.2**: untuk menjalankan artisan commands
4. **SSH Access**: dengan public key authentication
5. **Permissions**: user deployment harus memiliki write access ke aplikasi directory

### Example Server Setup

```bash
# Install PHP 8.2 dan dependencies
sudo apt update
sudo apt install php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Setup deployment directory
sudo mkdir -p /var/www/html/inventory-api
sudo chown deployer:deployer /var/www/html/inventory-api

# Clone repository
cd /var/www/html
git clone https://github.com/your-username/inventory-api.git

# Setup SSH key
mkdir -p ~/.ssh
chmod 700 ~/.ssh
nano ~/.ssh/authorized_keys  # Paste public key here
chmod 600 ~/.ssh/authorized_keys
```

---

## Security Best Practices

1. ✅ Gunakan SSH key authentication, bukan password
2. ✅ Buat user khusus untuk deployment (jangan gunakan root)
3. ✅ Limit sudo access hanya untuk command yang diperlukan
4. ✅ Gunakan environment-specific SSH keys
5. ✅ Rotate SSH keys secara berkala
6. ✅ Enable 2FA di GitHub account
7. ✅ Review workflow logs untuk mendeteksi aktivitas mencurigakan
