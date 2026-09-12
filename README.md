# SaaS POS — Multi-Tenant Point of Sale Platform

A full-stack, multi-tenant Point of Sale (POS) SaaS built with **Laravel** and **Filament-style Blade UI**, designed for small retail businesses (boutiques, cafés, pharmacies, grocery stores, salons, and more). Each business signs up as an isolated **tenant** with its own staff, inventory, customers, and billing — all running on a single codebase.

> 🎓 This is a personal portfolio project built to demonstrate full-stack Laravel development, multi-tenant architecture, and SaaS billing integration. Roman Urdu is used throughout the interface to make it accessible to Pakistani small-business owners and staff who are more comfortable with it than English.

---

## ✨ Features

### Point of Sale
- Fast, keyboard-shortcut-friendly checkout screen (search by name, SKU, or barcode)
- Cart with live stock validation, loyalty-point redemption, and multiple payment methods (Cash, Card, JazzCash, Credit/Udhaar)
- Auto-generated, printable/downloadable PDF receipts

### Inventory & Catalog
- Product catalog with categories, SKU/barcode, stock levels, and low-stock alerts
- CSV export of visible inventory
- Plan-based product limits (Starter / Business / Enterprise)

### Sales & Customers
- Order history with role-gated refunds (only Admin/Manager can issue a refund — cashiers cannot self-refund)
- Full refund audit log with a "mark reviewed" workflow
- Customer directory with loyalty points, visit count, and credit (Udhaar) balance tracking

### Multi-Tenancy & Staff
- Strict tenant data isolation via a `BelongsToTenant` global scope trait applied across all tenant-owned models
- Role-based access control: **Admin**, **Manager**, **Cashier** — each with a different slice of the UI and routes
- Staff management with activate/deactivate and safe self-protection (you can't deactivate yourself or another admin)

### Billing & Subscriptions
- Stripe Checkout integration for paid plans (Business / Enterprise), with a 14-day trial
- Signature-verified Stripe webhook handling for subscription lifecycle events (created, updated, cancelled, payment failed)
- Super Admin panel to manage all tenants: view billing status, plan, usage stats, and manually activate/deactivate/edit/delete a tenant

### Reports
- Revenue trend chart (last 7 days), best-selling products, and daily/weekly/monthly revenue breakdowns

---

## 🏗️ Architecture Notes

- **Tenant isolation** — every tenant-scoped model (`Product`, `Order`, `Customer`, `Category`, `Expense`, …) uses a shared `BelongsToTenant` trait that applies a global query scope and auto-fills `tenant_id` on create. This means a stray query anywhere in the app can't accidentally leak another business's data.
- **Route-level role gating** — `routes/web.php` groups routes under `not.cashier` (Admin + Manager) and `tenant.admin` (Admin only) middleware, so authorization is enforced before a request even reaches a controller, not just hidden in the UI.
- **Checkout consistency** — the POS checkout (`ProductController@checkout`) runs inside a single DB transaction with `lockForUpdate()` on the customer row, so concurrent sales can't corrupt stock counts or loyalty-point balances.
- **Signed webhooks** — `StripeWebhookController` verifies the Stripe signature header before processing any event, and fails closed on an invalid payload.

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel (PHP) |
| Frontend | Blade, Tailwind CSS, vanilla JS, GSAP (landing page animations) |
| Database | MySQL / SQLite |
| Payments | Stripe (Checkout + Webhooks) |
| Charts | Chart.js |

---

## 🚀 Getting Started

### Requirements
- PHP 8.2+
- Composer
- MySQL or SQLite
- A Stripe account (test mode) if you want to exercise the billing flow

### Setup

```bash
git clone <your-repo-url>
cd saas-pos

composer install

cp .env.example .env
php artisan key:generate

# Configure your database in .env, then:
php artisan migrate --seed

php artisan serve
```

### Environment variables to set

```env
DB_CONNECTION=mysql
DB_DATABASE=saas_pos
DB_USERNAME=root
DB_PASSWORD=

STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...
STRIPE_PRICE_BUSINESS=price_...
STRIPE_PRICE_ENTERPRISE=price_...
```

### Default accounts (after `--seed`)
- **Super Admin** — see `database/seeders/SuperAdminSeeder.php` for credentials
- New businesses can self-register at `/register-business`

---

## 📁 Project Structure (high level)

```
app/
├── Http/Controllers/
│   ├── Auth/              # Login, registration, password reset
│   ├── Tenant/            # POS, products, orders, customers, staff, settings...
│   ├── SuperAdmin/        # Platform-level tenant management
│   └── StripeWebhookController.php
├── Models/
│   ├── Concerns/BelongsToTenant.php   # Shared multi-tenancy scope
│   └── ...
resources/views/
├── tenant/                # Business-facing app (POS, dashboard, etc.)
├── super-admin/           # Platform owner's admin panel
├── auth/
└── welcome.blade.php      # Public marketing landing page
```

---

## 🗺️ Roadmap / Known Limitations

This project is under active iteration. Some things intentionally left for a future pass before any real production deployment:

- [ ] Automated test coverage (checkout, tenant isolation, refund authorization)
- [ ] Email verification enforcement
- [ ] Local payment gateway support (JazzCash/Easypaisa direct integration, since Stripe doesn't support direct payouts to Pakistan)
- [ ] Rate limiting on the checkout endpoint
- [ ] Production hardening: error monitoring, automated backups, staging environment

---

## 📄 License

This is a personal portfolio project. Feel free to explore the code for learning purposes.

---

## 👤 Author

**Muhammad Saifullah**
Full Stack Developer (PHP / Laravel) — Karachi, Pakistan
