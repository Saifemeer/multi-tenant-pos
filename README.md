# Flash POS — Multi-Tenant Point of Sale SaaS

A full-stack, multi-tenant Point of Sale (POS) platform built with Laravel. Businesses can register, choose a subscription plan, and manage their own isolated store — including inventory, sales, staff, and customers — all from a single codebase serving multiple tenants.



## 🔗 Links
- GitHub: [github.com/Saifemeer/multi-tenant-pos](https://github.com/Saifemeer/multi-tenant-pos)
- LinkedIn: [linkedin.com/in/muhammad-saifullah11](https://www.linkedin.com/in/muhammad-saifullah11/)

---

## ✨ Key Features

### Multi-Tenancy
- Single-database, shared-schema architecture using `tenant_id` scoping
- Global Eloquent scopes (`BelongsToTenant` trait) automatically isolate every tenant's data — no query can accidentally leak data across businesses
- Tenant-scoped order numbering, product catalogs, and reporting

### Subscription Billing (Stripe)
- Three-tier pricing (Starter / Business / Enterprise) with Stripe Checkout
- 14-day free trial on paid plans
- Stripe Webhooks handle payment success, failure, and cancellation events — the app doesn't rely solely on redirect URLs, since payment confirmation comes directly from Stripe
- Plan-based feature gating: product limits, staff limits, and analytics access are enforced server-side based on the tenant's active plan

### Role-Based Access Control
- Three roles per tenant: **Admin**, **Manager**, **Cashier**
- Cashiers are restricted to the POS checkout screen only — no access to inventory, reports, or settings
- Route-level middleware (`not.cashier`) and controller-level checks enforce permissions on both the backend and the UI

### Point of Sale
- Fast product search and cart-based checkout
- Real-time stock validation and deduction on sale
- Multiple payment methods (Cash, Card, JazzCash, Easypaisa, Bank Transfer)
- Automatic tenant-scoped, race-condition-safe order number generation

### Inventory & Business Management
- Product catalog with categories, SKU/barcode, low-stock alerts, and profit margin calculations
- Customer database with visit and spend tracking
- Sales reports with revenue breakdowns (daily/weekly/monthly) and top-selling products, visualized with Chart.js

### Staff Management
- Admins/Managers can invite staff (Manager or Cashier roles)
- Staff limits enforced per subscription plan

### Super Admin Panel
- Platform-wide dashboard separate from tenant dashboards
- View all tenants, activate/deactivate accounts, monitor trial expirations and platform revenue

### Security
- Mid-session account/tenant deactivation checks (a deactivated user or tenant is signed out immediately, not just blocked at login)
- CSRF protection with a scoped exception for the Stripe webhook endpoint
- Registration wrapped in a DB transaction — if Stripe setup fails, no orphaned tenant/user records are left behind

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 12 (PHP 8.2) |
| Database | MySQL |
| Frontend | Blade, Tailwind CSS |
| Payments | Stripe (Checkout, Subscriptions, Webhooks) |
| Charts | Chart.js |
| Auth | Laravel's built-in authentication |

---

## 🏗️ Architecture Highlights

**Tenant Isolation** — Every tenant-owned model uses a shared `BelongsToTenant` trait that applies a global Eloquent scope, automatically filtering all queries by the authenticated user's `tenant_id`, and auto-fills `tenant_id` on creation.

**Plan-Based Gating** — Subscription limits (`config/plans.php`) are checked at the model level (`Tenant::hasReachedProductLimit()`, `hasReachedUserLimit()`, `canAccessReports()`) rather than hardcoded in controllers, making it easy to add or adjust plans.

**Webhook-Driven Billing State** — Rather than trusting the browser redirect after checkout, subscription status (`trialing`, `active`, `past_due`, `canceled`) is updated via Stripe webhook events, matching how production billing systems behave.

---

## ⚙️ Local Setup

```bash
git clone https://github.com/Saifemeer/multi-tenant-pos.git
cd multi-tenant-pos

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Configure your `.env`:
```
DB_DATABASE=multi_tenant_pos
DB_USERNAME=root
DB_PASSWORD=

STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...
STRIPE_PRICE_BUSINESS=price_...
STRIPE_PRICE_ENTERPRISE=price_...
```

```bash
php artisan migrate
php artisan serve
npm run dev
```

For local Stripe webhook testing:
```bash
stripe listen --forward-to localhost:8000/stripe/webhook
```

---

## 📌 Roadmap
- [ ] Automated test coverage (PHPUnit/Pest)
- [ ] Email notifications (staff invites, receipts)
- [ ] Multi-store support for Enterprise tenants
- [ ] Production deployment

---

## 👤 Author
**Muhammad Saifullah** — Full Stack Developer (Laravel/PHP)
[LinkedIn](https://www.linkedin.com/in/muhammad-saifullah11/) · [GitHub](https://github.com/Saifemeer/)
