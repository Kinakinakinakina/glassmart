# GlassMart

A 2010s-nostalgia e-commerce storefront built with **Laravel + MySQL**, styled in the
**Frutiger Aero** aesthetic (glossy glass panels over grass-and-sky, drifting bubbles,
wet aqua buttons). Submission for *Web Application Development* — case study
*Sistem E-Commerce UMKM Lokal*.

Full storefront: public catalog, session cart, checkout → orders, hand-written auth with
roles, and an admin panel (product/category CRUD + order management).

---

## Requirements

- **PHP 8.3+** (with the usual Laravel extensions: `pdo_mysql`, `mbstring`, `openssl`,
  `fileinfo`, `gd`)
- **Composer**
- **MySQL 8.x** (this project was developed with Laragon)
- **Node.js + npm** (Vite bundles the hand-written CSS/JS)

---

## Local setup

```bash
# 1. Install PHP dependencies
composer install

# 2. Create your environment file and generate the app key
cp .env.example .env
php artisan key:generate
```

Configure the database in `.env` (defaults match a stock Laragon install):

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=glassmart
DB_USERNAME=root
DB_PASSWORD=
```

Create the database, then build the schema and seed the demo data:

```bash
# 3. Create the database (adjust client path as needed)
mysql -u root -e "CREATE DATABASE IF NOT EXISTS glassmart;"

# 4. Run migrations + seeders (2 users, 4 categories, 20 products)
php artisan migrate:fresh --seed

# 5. Link the public storage dir (product image uploads; the symlink is gitignored)
php artisan storage:link

# 6. Build front-end assets (hand-written CSS/JS, bundled by Vite)
npm install
npm run build
```

Run it:

```bash
php artisan serve
# → http://localhost:8000
```

> **Importing the SQL dump instead of seeding?** If you prefer to load
> `database/glassmart.sql`, run `mysql -u root glassmart < database/glassmart.sql`
> after creating the database (skip step 4). You still need steps 5 and 6.

---

## Demo login credentials

Seeded by `php artisan migrate:fresh --seed`:

| Role     | Email                      | Password   |
|----------|----------------------------|------------|
| Admin    | `admin@glassmart.test`     | `password` |
| Customer | `customer@glassmart.test`  | `password` |

- **Admin** → the `/admin` panel (dashboard, product & category CRUD, order management).
  The admin account is admin-only and cannot shop.
- **Customer** → browse, add to cart, checkout, and view order history.
- Guests can browse the catalog; adding to cart redirects to login.

---

## Tech notes

- **Laravel 13**, PHP 8.3, MySQL, Blade + a little vanilla JS.
- Hand-written auth (no Breeze/Jetstream) with a `role` middleware guarding `/admin`.
- The **Frutiger Aero design system is hand-written** (the `.aero-*` glass panels,
  buttons, layout, product cards, animations and bubbles in `resources/css/app.css` +
  `resources/js/app.js`). The **Windows 7 window chrome** (title bars, `.window` frames)
  comes from the third-party **[`7.css`](https://khang-nd.github.io/7.css/)** stylesheet,
  imported into `app.css` — a pure CSS theme (no JS, no generator; all behaviour and the
  rest of the styling are hand-written).
- Session-based cart; checkout converts the cart into an `order` + `order_items` inside
  a DB transaction (with `lockForUpdate`) and decrements stock atomically.
- Security: `@csrf` on every form, `{{ }}` output escaping, Eloquent bindings only,
  server-side validation via Form Requests, custom `403/404/419/429/500/503` error pages.
