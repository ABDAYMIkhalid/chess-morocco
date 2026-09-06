# Chess Morocco

Chess Morocco is a tournament management platform.

## Backend

```bash
cd backend
composer install
php artisan migrate --seed
php artisan serve
```

Set the MySQL values in `backend/.env` before migrating. The included Docker Compose file creates the `chess_morocco` database and user automatically.

The API is available at `/api/v1`. Run tests with `php artisan test`; tests use an isolated in-memory SQLite database.
