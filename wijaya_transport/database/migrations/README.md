Run the SQL migration to add customer fields to `bookings`.

Locally (MySQL CLI):

```bash
mysql -u <user> -p < database/migrations/2026-06-23-add-customer-fields-to-bookings.sql
```

With Docker Compose (service name `db`):

```bash
docker-compose exec db mysql -u${DB_USER:-root} -p${DB_PASS:-} ${DB_NAME:-wijaya_transport} < /var/www/html/database/migrations/2026-06-23-add-customer-fields-to-bookings.sql
```

Notes:
- If your MySQL version is older and doesn't support `ADD COLUMN IF NOT EXISTS`, use the guarded statements in the SQL file.
- After migration, bookings created via the site will persist `customer_name`, `customer_phone`, and `customer_email` when provided.
