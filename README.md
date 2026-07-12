# 📅 Booking & Event Management API Platform

[![Laravel Framework](https://img.shields.io/badge/Laravel-v11/13-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com/)
[![PHP Runtime](https://img.shields.io/badge/PHP-v8.2/8.4-777BB4?style=for-the-badge&logo=php)](https://www.php.net/)
[![Database Architecture](https://img.shields.io/badge/Database-MySQL-4479A1?style=for-the-badge&logo=mysql)](https://www.mysql.com/)
[![Authentication Engine](https://img.shields.io/badge/Auth-Sanctum-red?style=for-the-badge)](https://laravel.com/docs/sanctum)

A production-ready, high-performance RESTful API designed to manage synchronized event scheduling and transactional bookings. Built with **Laravel** and **PHP**, this platform focuses heavily on strict data integrity, robust backend architecture patterns, race-condition prevention, and clean decoupling of business logic from the HTTP routing layer.

---

## 🚀 Key Architectural Highlights

### 1. Concurrency Safety & Race-Condition Prevention
* **Pessimistic Database Locking:** Integrates `lockForUpdate()` during the booking validation lifecycle to freeze room/event capacity, completely eliminating double-booking flaws or ticket overselling in high-concurrency environments.
* **Atomic Financial Integrity:** Wraps database transactions dynamically using standard ACID-compliant `DB::transaction()` wrappers, rolling back entirely on any structural payload failure.
* **Server-Side Calculations:** Computes transactional pricing variables natively at the service level to eliminate any front-end price injection vulnerabilities.

### 2. Service-Oriented Domain Layer (`app/Services/`)
* **Decoupled Architectural Isolation:** Features a dedicated, injection-ready domain service design (`BookingServices`, `EventServices`, `CategoryServices`), isolating complex entity state mutations entirely away from REST controllers.
* **Reusable Polymorphic Asset Handlers:** Implements a wrapper `MediaService` leveraging the Spatie MediaLibrary engine to process multi-tier file uploads natively across polymorphic models without database or orphaning leaks.
* **Domain State Machine Tracking:** Guides booking records dynamically through a tri-state machine framework (*pending*, *confirmed*, *cancelled*) utilizing centralized database query scopes.

### 3. Enterprise Access Control & Validation Guards
* **Granular RBAC Middlwares:** Deploys explicit custom routing middleware structures (`checkRole:admin`) built on top of Laravel Sanctum token validation layers to implement secure API endpoint access limits.
* **Centralized FormRequest Validation:** Outsources input validation tasks into type-safe, dedicated request layers (`StoreBookingRequest`), preventing invalid execution logic execution while serving standard `422 Unprocessable Entity` JSON schemas.
* **Consistent API Serialization Contracts:** Processes database model records inside Eloquent API Resources to guarantee strict JSON type definitions and fully filter internal operational variables (e.g., hash keys, internal states).

---

## 📁 Core Repository Directory Blueprint

```text
app/
├── Http/Controllers/         # Resource controllers injecting domain services
├── Http/Middleware/          # Custom RBAC guards (CheckRole middleware)
├── Http/Requests/            # Form requests handling centralized HTTP validation
├── Http/Resources/           # Eloquent API resources transforming JSON contracts
├── Models/                   # Domain models leveraging modern PHP 8 attributes
└── Services/                 # Domain Service layer isolates heavy business logic

```

## ⚙️ Installation & Setup Instructions

Follow these layout instructions to spin up the RESTful API platform environment locally:

1. **Clone the repository:**
`git clone [https://github.com/Mina-Magdy-mores/booking.git](https://github.com/Mina-Magdy-mores/booking.git)`
`cd booking`

2. **Install Composer dependencies:**
`composer install`

3. **Configure Environment Variables:**
`cp .env.example .env`
`php artisan key:generate`
*(Configure your local MySQL DB variables inside the generated .env file)*

4. **Execute Core Database Migrations & Seeds:**
`php artisan migrate --seed`

5. **Boot up the localized development API server:**
`php artisan serve`

---

## 👤 Author
* **Mina Magdy Mores** – Full-Stack Engineer / Back-End Developer
* **LinkedIn:** [https://www.linkedin.com/in/mina-magdy-mores](https://www.linkedin.com/in/mina-magdy-mores)
* **GitHub:** @Mina-Magdy-mores
