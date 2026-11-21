# Uniform Manufacturing Co. — B2B Quotation Platform (Laravel)

**Complete through all 12 phases.**

## Setup
```
composer install
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

**Logins (seeded):**
- Admin: `admin@company.com` / `admin12345`
- (Register a customer account at `/register`)

## What's built
- **Public site**: Home (hero, why-choose-us), About (animated stat counters, mission,
  process), Uniforms (8 categories + search/filter + product grid), Product detail
  (gallery, customization badges), Customization (alternating image/text sections),
  Our Work (portfolio grid + lightbox + category filters), Clients (auto-scrolling
  logo slider, seeded with real client names), Track Order (public, by order# + email),
  Contact (form + business info)
- **Auth**: company registration/login, role-protected admin area
- **Request-a-Quote**: sizes per size, logo upload (png/jpg/jpeg/pdf), customization
  checkboxes, delivery info → generates `Q-2026-XXXXX`
- **Customer Dashboard**: summary cards, My Quotations (pricing view, approve/reject),
  My Orders (status timeline), My Profile
- **Admin panel**: Dashboard (stats + 7-day chart), Quotations (live pricing
  calculator, convert approved quote → order), Orders (9-step status pipeline +
  history log), **full CRUD** for Products (multi-photo gallery, customization
  checkboxes), Categories, Clients (logo upload), Portfolio (image + category),
  Messages, Settings (WhatsApp number, contact info)
- **Animations**: scroll-reveal (fade-up/left/right/zoom) via IntersectionObserver,
  animated counters, sticky navbar with scroll-transition, card hover effects,
  image gallery/lightbox, button hover states
- **Responsive**: Bootstrap grid throughout, mobile nav collapse, all admin/customer
  tables wrapped in `.table-responsive`

## Notes
- Uploaded photos live in `storage/app/public/{products,categories,clients,portfolio,quote-logos}`
  — don't skip `storage:link`.
- Order/quote numbers: `Q-2026-XXXXX` / `ORD-2026-XXXXX`, auto-incrementing per year.
- Change admin password via `php artisan tinker`.
