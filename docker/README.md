# Docker Setup for Battery Shop

## Quick Start

```bash
# 1. Copy environment file and generate key
cp .env.docker .env
php artisan key:generate --show
# Copy the generated key to .env file (APP_KEY=base64:...)

# 2. Build and start containers
docker-compose up -d --build

# 3. Wait for initialization (30-60 seconds), then visit:
# http://localhost:8000

# 4. Optional: Seed database with sample data
docker-compose exec app php artisan db:seed --force
```

## Services

| Service | URL | Description |
|---------|-----|-------------|
| App | http://localhost:8000 | Main application |
| phpMyAdmin | http://localhost:8080 | Database management |
| MySQL | localhost:3306 | Direct DB access |
| Redis | localhost:6379 | Cache/Session store |

## Common Commands

```bash
# View logs
docker-compose logs -f app
docker-compose logs -f mysql

# Run artisan commands
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
docker-compose exec app php artisan tinker

# Clear caches
docker-compose exec app php artisan optimize:clear

# Rebuild frontend
docker-compose exec app npm run build

# Shell access
docker-compose exec app sh
docker-compose exec mysql mysql -u root -p

# Stop and remove
docker-compose down -v
```

## Production Notes

1. **Security**: Change all default passwords in `.env`
2. **HTTPS**: Use a reverse proxy (Traefik, Nginx Proxy Manager) for SSL
3. **Backups**: Set up automated MySQL dumps
4. **Monitoring**: Add health checks and logging
5. **Scaling**: Use separate PHP-FPM workers for high traffic

## Database Credentials (phpMyAdmin)

- Host: mysql
- User: battery_user
- Password: (from DB_PASSWORD in .env)
- Database: battery_shop

## Troubleshooting

**App not starting?**
```bash
docker-compose logs app
# Check for migration errors or missing APP_KEY
```

**Database connection failed?**
```bash
docker-compose logs mysql
# Ensure mysql is healthy before app starts
```

**Permission errors?**
```bash
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

**Frontend assets missing?**
```bash
docker-compose exec app npm run build
```