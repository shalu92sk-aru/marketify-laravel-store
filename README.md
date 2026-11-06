# Marketify — Shopify-inspired Laravel Ecommerce Store

A full-stack demo ecommerce project with a polished storefront and a publisher-style store admin. Built with Laravel 12, PHP 8.2+, Blade, MySQL, CSS and vanilla JavaScript.

## Storefront features
- Responsive Shopify-inspired home page and product collection pages
- Product detail pages with price, compare-at price, discount and stock display
- Category navigation, search and sorting
- Session-based shopping cart with quantity updates and remove actions
- Checkout form with address validation
- Cash on Delivery demo checkout
- Order confirmation page
- Shipping fee demo rule: ₹99 below ₹1,500; free shipping at or above ₹1,500

## Admin features
- Admin sign-in
- Dashboard with product, category, order and paid revenue summaries
- Product CRUD, SKU, price, compare-at price, stock, image, featured and visibility fields
- Category CRUD
- Order list and order detail pages
- Order status and payment status management
- Image upload to Laravel public storage

## Requirements
- PHP 8.2+
- Composer 2
- MySQL or MariaDB
- XAMPP (Apache + MySQL)

## Run locally with XAMPP (Windows)

1. Start Apache and MySQL in XAMPP Control Panel.
2. Create a database called `marketify_store` in phpMyAdmin.
3. Extract this folder into `C:\\xampp\\htdocs\\marketify-store`.
4. Open Command Prompt in the project folder:

   ```bash
   composer install
   copy .env.example .env
   php artisan key:generate
   ```

5. Check the database values in `.env`:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=marketify_store
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. Create database tables and demo data:

   ```bash
   php artisan migrate --seed
   ```

7. Create the public image storage link:

   ```bash
   php artisan storage:link
   ```

8. Start the local Laravel server:

   ```bash
   php artisan serve
   ```

9. Open `http://127.0.0.1:8000`.

You can store the project under `htdocs` and still use `php artisan serve`. For Apache virtual hosts, set the document root to the project's `public` directory, never the project root.

## Demo admin credentials

- Admin URL: `http://127.0.0.1:8000/admin/login`
- Email: `admin@marketify.test`
- Password: `ChangeMe123!`

Change this demo password before exposing the project to a network or deploying it.

## Test the shopping flow

1. Browse products and categories on the storefront.
2. Open a product and add it to the bag.
3. Update quantity or remove an item in the cart.
4. Continue to checkout and submit a Cash on Delivery order.
5. Sign in to the admin dashboard and open **Orders** to manage the new order.
6. Add your own products and upload product images under **Products**.

## GitHub upload

The `.env`, `vendor`, `node_modules` and generated public storage link are excluded.

```bash
git init
git add .
git commit -m "Initial Marketify Laravel ecommerce store"
git branch -M main
git remote add origin https://github.com/YOUR-USERNAME/marketify-laravel-store.git
git push -u origin main
```

## Project structure

```text
app/
  Http/Controllers/
    Admin/
    CartController.php
    CheckoutController.php
    StoreController.php
  Models/
bootstrap/
database/
  migrations/
  seeders/
public/
  css/marketify.css
  js/marketify.js
resources/views/
  admin/
  layouts/
  partials/
  store/
routes/web.php
```

## Important demo limitations

- Checkout currently supports Cash on Delivery only. Razorpay, Stripe or another gateway must be integrated and verified before accepting online payments.
- No customer account/registration, coupon engine, tax engine, shipping carrier integration, refunds workflow, product variants, multi-image gallery or email notifications are included.
- The demo does not collect card details. Do not add raw card collection; use a PCI-compliant payment gateway.
- Before production, add automated tests, rate limiting, authorization policies/roles, image replacement cleanup, order cancellation/refund stock handling, privacy/terms pages, backups, HTTPS and deployment hardening.
- This is an original Shopify-inspired portfolio design; it is not Shopify software and does not copy Shopify branding.
