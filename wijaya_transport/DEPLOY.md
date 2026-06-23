**cPanel / Shared hosting Checklist**

- Upload project files to `public_html/wijaya_transport` (or a subfolder).
- Ensure `.htaccess` is present and `AllowOverride All` is enabled in Apache config.
- Create a MySQL database and user; import `database/seed.sql` via phpMyAdmin or CLI.
- Update `config/database.php` with DB credentials or use a simple `.env` loader if you prefer.
- Set `config/midtrans.php` server/client keys (use sandbox keys for testing).
- Protect `config` files and `storage/` with proper permissions (600 for secrets, 755 for folders readable by webserver).
- Use HTTPS (Let's Encrypt) and point Midtrans webhook URL to `https://yourdomain.tld/wijaya_transport/webhook.php`.
- Add `MAIL_FROM` and SMTP env vars in cPanel's "Email" or environment settings for PHPMailer.


**Ubuntu (Nginx + PHP-FPM) Checklist**

- Create a system user for the app and clone the repo into `/var/www/wijaya_transport`.
- Install PHP 8.1/8.2 with required extensions (`pdo_mysql`, `gd`, `zip`, `mbstring`, `xml`).
- Create Nginx site with `root /var/www/wijaya_transport;` and `try_files $uri $uri/ /index.php?$query_string;`.
- Configure PHP-FPM pool to run as the site user and restart `php-fpm` and `nginx`.
- Import `database/seed.sql` into MySQL and set env variables in `/etc/systemd/system/php-fpm.service.d/env.conf` or use `php-environment` file loaded by your deploy process.
- Set proper permissions: `chown -R www-data:www-data /var/www/wijaya_transport` (or site user), ensure `storage/` is writable by webserver.
- Use `certbot` to obtain TLS certs and renew automatically.
- For webhooks: ensure the webhook endpoint is reachable and secure (HTTPS). Consider restricting access by source IPs or adding a webhook secret.

**General Security Notes**

- Never commit real API keys or passwords. Use environment variables or server config to store secrets.
- Ensure `display_errors` is off in production and logs are rotated regularly.
- Apply file permission best practices (no 777), and keep backups of `database/` and `storage/`.
