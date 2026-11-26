# apiadult.online — deployment notes

## Accounts / API keys
- Schema: `install/schema.sql` (DB `apiadult`).
- DB credentials live **outside** the repo in `/home/apiadult/.config/apiadult/credentials.env`
  (mode 0644 so php-fpm's `www-data` can read it; contains `AA_DB_*` and optionally `AA_UPSTREAM_*`).
- Pages: `/register.php`, `/login.php`, `/logout.php`, `/account.php` (keys + usage).
- Keys are `aal_live_<48 hex>`; only sha256 hashes are stored in `api_keys.key_hash`.

## Gateway
- nginx already routes `/v1/*` to `v1/api.php`.
- `GET /v1/models` is public — mirrored from `https://api.hotapi.ai/v1/models` (5-min cache).
- All other endpoints require `Authorization: Bearer aal_live_…`, and are proxied to
  `AA_UPSTREAM_BASE` (default `https://api.hotapi.ai`) using server-side `AA_UPSTREAM_KEY`.
- Created tasks are mirrored into the local `tasks` table; upstream `request_id` is preserved on errors.
- Set `AA_UPSTREAM_KEY` in the credentials file once the upstream key is issued.

## Deploy (webroot is owned by www-data)
These files are a staging repo. To publish, as root:
```
rsync -a --exclude .git --exclude .gitignore /home/apiadult/repos/apiadult/ /var/www/apiadult.online/
```
Nginx/PHP-FPM need no config change for the account pages (standard `*.php` location).
