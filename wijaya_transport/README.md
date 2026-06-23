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
