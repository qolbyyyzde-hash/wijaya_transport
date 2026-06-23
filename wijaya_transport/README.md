# Wijaya Transport — Starter Scaffold

Local dev with MAMP:

1. Put this folder inside MAMP's `htdocs` (already here).
2. Create a MySQL database named `wijaya_transport` and update `config/database.php` credentials.
3. Start MAMP and visit `http://localhost/wijaya_transport`.

What I scaffolded:
- `index.php` — simple entry loading `views/home.php`.
- `views/home.php` — static home with hero and CTAs.
- `assets/css/style.css` — design tokens + hero styles following DESIGN-lamborghini guideline.
- `assets/js/main.js` — placeholder for interactivity.
- `config/database.php` — PDO template connection.

Admin setup:

1. Create initial admin account using the helper script:

```bash
php create_admin.php "Admin Name" admin@example.test admin123
```

2. Then visit `http://localhost/wijaya_transport/admin.php` and login with the created credentials.

Payment / Midtrans notes:

- Set sandbox keys in `config/midtrans.php`:

```php
return [
	'server_key' => 'YOUR_SANDBOX_SERVER_KEY',
	'client_key' => 'YOUR_SANDBOX_CLIENT_KEY',
	'is_production' => false,
	'api_base' => 'https://api.sandbox.midtrans.com'
];
```

- To test webhook locally, compute `signature_key` as `sha512(order_id + status_code + gross_amount + server_key)` and POST JSON to `/webhook.php` (example in earlier notes).

- After a successful payment in the sandbox, the client returns a result and the checkout page will POST it to `controllers/payment_callback.php` to update records.

Finalization checklist:

- Place hero video at `assets/media/hero.mp4` (optional). The homepage will use it if present.
- Place sample car images under `assets/media/` and adjust `database/seed.sql` paths if needed.
- If you don't have `LamboType`, the site will fall back to Roboto/Helvetica. To use LamboType, add @font-face to `assets/css/style.css` and update `--base-font`.
- Configure Midtrans keys via environment or directly in `config/midtrans.php` (sandbox keys recommended for testing):

```bash
export MIDTRANS_SERVER_KEY=your_sandbox_server_key
export MIDTRANS_CLIENT_KEY=your_sandbox_client_key
```

- Create DB and seed (run the SQL in `database/seed.sql`). Then create admin user:

```bash
# import seed.sql using mysql client or phpMyAdmin
php create_admin.php "Admin" admin@example.test admin123
```

- Start MAMP and visit:
	- Public: `http://localhost/wijaya_transport`
	- Admin: `http://localhost/wijaya_transport/admin.php`

Optional: install PHPMailer for real SMTP email sending

1. Install Composer (if not installed): https://getcomposer.org/
2. From project root run:

```bash
composer install
```

3. Set SMTP env vars (example):

```bash
export SMTP_HOST=smtp.example.com
export SMTP_USER=username
export SMTP_PASS=secret
export SMTP_PORT=587
export MAIL_FROM=no-reply@yourdomain.com
```

PHPMailer will be used automatically by the project when available.

If you want, I can now:
- Run a webhook simulation (you provide sandbox `server_key`), or
- Style the site further to match `DESIGN-lamborghini.md` (font assets + exact spacing), or
- Add CSV/PDF export for reports.

Testing webhook example (replace keys and values accordingly):

```bash
php -r "echo hash('sha512', 'ORDER-123-1600000000' . '200' . '3500000' . 'YOUR_SANDBOX_SERVER_KEY') . PHP_EOL;"

curl -X POST http://localhost/wijaya_transport/webhook.php \
	-H "Content-Type: application/json" \
	-d '{"order_id":"ORDER-123-1600000000","status_code":"200","gross_amount":"3500000","signature_key":"<signature>","transaction_id":"abcd1234","transaction_status":"settlement","payment_type":"bank_transfer"}'
```

Next recommended steps:
- Provide hero video/image assets (place into `assets/media/`) and update `views/home.php`.
- Implement dynamic Car listing using `models`/`controllers` and DB tables from `plaining.md`.
- Integrate Midtrans on server-side and implement webhook endpoint.

Deployment Notes
----------------

- Apache (shared hosting): upload project to `public_html/wijaya_transport`, ensure `mod_rewrite` enabled and `.htaccess` allowed. Put sensitive keys into hosting environment variables or use provider settings — do NOT commit keys.
- Nginx: use `try_files $uri $uri/ /index.php?$query_string;` in the server block, and pass env vars via FastCGI environment (or use a proper `.env` loader).
- Secure production: set `MIDTRANS_IS_PRODUCTION=1` and ensure `config/midtrans.php` reads env vars. Use HTTPS and restrict webhook endpoints to Midtrans IPs where possible.

If you'd like, I can prepare a deploy checklist for cPanel, or a systemd/nginx deploy script for a Ubuntu VPS.

Docker Local Development
------------------------

You can run the app locally using the included `Dockerfile` and `docker-compose.yml` (recommended when you don't want to install PHP + Composer locally).

Quick start:

```bash
docker-compose build
docker-compose up -d
# install composer deps inside container
docker-compose run --rm app composer install
# import DB (on host):
# docker exec -i wijaya_db mysql -uwijaya -psecret wijaya < database/seed.sql
# run lint inside container
docker-compose exec app bash -lc "./scripts/lint.sh"
```

Notes:
- The MySQL root password and sample user are set in `docker-compose.yml` for local dev only; change before production.
- Place any media assets into `assets/media/` and ensure file permissions allow the webserver to read them.

Composer & Email
----------------

Run `composer install` inside the container or locally to install `PHPMailer` (already listed in `composer.json`). The app will use PHPMailer automatically when `vendor/autoload.php` exists; otherwise it falls back to `mail()` and logs emails to `storage/email.log`.

Webhook Testing
---------------

A webhook verification endpoint is available at `/webhook.php`. To simulate a Midtrans webhook locally, use the provided script:

```bash
# provide MIDTRANS_SERVER_KEY via env or set it in config/midtrans.php
php scripts/webhook_simulate.php <booking_id> <status_code> <transaction_status> <gross_amount> <endpoint>
# example:
php scripts/webhook_simulate.php 12 200 settlement 150000 http://localhost/wijaya_transport/webhook.php
```

The script computes `signature_key` using `sha512(order_id + status_code + gross_amount + server_key)` and POSTs JSON to the endpoint.


