# Monitoring Setup - Grafana, Prometheus & cAdvisor

## Overview

Proyek ini dilengkapi dengan stack monitoring komprehensif menggunakan:
- **Prometheus**: Sistem monitoring dan time-series database
- **Grafana**: Platform visualisasi dan dashboard
- **cAdvisor**: Container monitoring untuk Docker
- **Node Exporter**: Metrics host/server

## Arsitektur Monitoring

```
┌─────────────┐     ┌──────────────┐     ┌──────────────┐
│   Grafana   │────▶│  Prometheus  │────▶│   cAdvisor   │
│  (Port 3000)│     │  (Port 9090) │     │  (Port 8081) │
└─────────────┘     └──────────────┘     └──────────────┘
                            │
                            │
                            ▼
                    ┌──────────────┐
                    │Node Exporter │
                    │  (Port 9100) │
                    └──────────────┘
```

## Services & Ports

| Service | Port | Deskripsi |
|---------|------|-----------|
| Grafana | 3000 | Dashboard visualisasi metrics |
| Prometheus | 9090 | Time-series database & query engine |
| cAdvisor | 8081 | Container resource monitoring |
| Node Exporter | 9100 | Host/server metrics |

## Quick Start

### 1. Start Monitoring Stack

```bash
docker-compose up -d
```

Ini akan menjalankan semua services termasuk monitoring stack.

### 2. Access Services

#### Grafana Dashboard
- URL: http://localhost:3000
- Username: `admin`
- Password: `admin`
- Saat pertama login, Anda akan diminta mengubah password

#### Prometheus
- URL: http://localhost:9090
- Akses Prometheus UI untuk query metrics langsung

#### cAdvisor
- URL: http://localhost:8081
- Monitor container metrics secara real-time

## Configuration

### Prometheus Configuration

File konfigurasi: `monitoring/prometheus/prometheus.yml`

Scrape targets yang dikonfigurasi:
- **Prometheus** (self-monitoring)
- **cAdvisor** (container metrics)
- **Node Exporter** (host metrics)

Edit file ini untuk menambahkan scrape targets baru.

### Grafana Configuration

#### Datasources
File: `monitoring/grafana/provisioning/datasources/prometheus.yml`
- Prometheus sudah dikonfigurasi sebagai default datasource

#### Dashboards
File: `monitoring/grafana/provisioning/dashboards/dashboard.yml`
- Auto-provisioning untuk dashboards

## Recommended Grafana Dashboards

Import dashboard berikut untuk monitoring yang lebih baik:

### 1. Docker Container Monitoring (ID: 193)
- **Dashboard ID**: 193
- **Metrics**: Container CPU, Memory, Network, Disk I/O
- **Source**: cAdvisor

### 2. Node Exporter Full (ID: 1860)
- **Dashboard ID**: 1860
- **Metrics**: Host CPU, Memory, Disk, Network
- **Source**: Node Exporter

### 3. Docker and System Monitoring (ID: 893)
- **Dashboard ID**: 893
- **Metrics**: Combined container and host metrics

### Cara Import Dashboard:

1. Login ke Grafana (http://localhost:3000)
2. Klik icon "+" di sidebar → Import
3. Masukkan Dashboard ID (contoh: 193)
4. Klik "Load"
5. Pilih Prometheus sebagai datasource
6. Klik "Import"

## Metrics yang Dikumpulkan

### Container Metrics (cAdvisor)
- CPU usage per container
- Memory usage & limits
- Network I/O
- Filesystem usage
- Container uptime

### Host Metrics (Node Exporter)
- CPU utilization
- Memory usage
- Disk space & I/O
- Network traffic
- System load

### Prometheus Metrics
- Scrape duration
- Time series count
- Query performance

## Advanced Configuration

### Adding Custom Metrics Exporters

Edit `docker-compose.yml` untuk menambahkan exporter:

#### MySQL Exporter (Optional)
```yaml
mysql-exporter:
  image: prom/mysqld-exporter
  container_name: inventory-api-mysql-exporter
  environment:
    - DATA_SOURCE_NAME=inventory_user:inventory_password@(mysql:3306)/inventory_db
  ports:
    - "9104:9104"
  networks:
    - inventory-network
```

Lalu uncomment job MySQL di `monitoring/prometheus/prometheus.yml`.

#### Nginx Exporter (Optional)
```yaml
nginx-exporter:
  image: nginx/nginx-prometheus-exporter:latest
  container_name: inventory-api-nginx-exporter
  command:
    - -nginx.scrape-uri=http://nginx:80/stub_status
  ports:
    - "9113:9113"
  networks:
    - inventory-network
```

### Retention & Storage

Prometheus menggunakan volume `prometheus_data` untuk persistensi data.

Default retention: 15 hari

Untuk mengubah retention, edit command di docker-compose.yml:
```yaml
command:
  - '--storage.tsdb.retention.time=30d'  # Simpan 30 hari
```

## Alerting (Optional)

### Setup Alertmanager

1. Tambahkan Alertmanager ke docker-compose.yml
2. Buat alert rules di Prometheus
3. Konfigurasi notification channels (email, Slack, dll)

Contoh alert rule (`monitoring/prometheus/alerts.yml`):
```yaml
groups:
  - name: container_alerts
    interval: 30s
    rules:
      - alert: ContainerDown
        expr: up == 0
        for: 1m
        labels:
          severity: critical
        annotations:
          summary: "Container {{ $labels.instance }} is down"
```

## Troubleshooting

### Prometheus tidak bisa scrape targets

```bash
# Check Prometheus logs
docker logs inventory-api-prometheus

# Verify network connectivity
docker exec inventory-api-prometheus ping cadvisor
```

### Grafana tidak bisa connect ke Prometheus

1. Cek datasource configuration di Grafana
2. Pastikan URL: `http://prometheus:9090`
3. Test connection di Grafana → Configuration → Data Sources

### cAdvisor metrics tidak muncul

- Windows: cAdvisor memiliki keterbatasan di Windows
- Solusi: Gunakan Docker Desktop dengan WSL2 backend

## Security Considerations

### Production Deployment

1. **Change default passwords**:
   ```yaml
   environment:
     - GF_SECURITY_ADMIN_PASSWORD=your_secure_password
   ```

2. **Enable authentication untuk Prometheus**
3. **Use reverse proxy dengan SSL**
4. **Restrict network access**
5. **Regular backup Grafana dashboards**

## Performance Tips

1. **Adjust scrape intervals** berdasarkan kebutuhan
2. **Reduce retention period** jika storage terbatas
3. **Use recording rules** untuk query yang sering digunakan
4. **Monitor Prometheus resource usage**

## Resources

- [Prometheus Documentation](https://prometheus.io/docs/)
- [Grafana Documentation](https://grafana.com/docs/)
- [cAdvisor GitHub](https://github.com/google/cadvisor)
- [Public Grafana Dashboards](https://grafana.com/grafana/dashboards/)

## Maintenance

### Backup Grafana Dashboards
```bash
docker exec inventory-api-grafana grafana-cli admin export-dashboard > backup.json
```

### Update Containers
```bash
docker-compose pull
docker-compose up -d
```

### Clean Up Old Data
```bash
# Stop services
docker-compose down

# Remove volumes (WARNING: This deletes all metrics data)
docker volume rm inventory-api_prometheus_data
docker volume rm inventory-api_grafana_data

# Restart
docker-compose up -d
```

## Support

Untuk pertanyaan atau issues, silakan buat issue di repository project.
