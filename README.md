# Constructify

Constructify is a construction company website with a public-facing frontend and a Filament-powered admin panel for managing site content (sections, services, projects, counters, navigation, footer links, social links, and site settings).

## Tech Stack

**Backend**
- PHP 8.3+
- Laravel 13
- Filament 5 (admin panel)
- Eloquent ORM
- MySQL 8+

**Frontend**
- Vite 8
- Tailwind CSS 4
- Bootstrap 5
- Bootstrap Icons
- Blade templates

**Tooling & Testing**
- Composer 2
- Node.js 20+ / npm
- Pest 5 + pest-plugin-laravel
- Laravel Pint, Laravel Pail, Laravel Boost
- Faker

## Requirements

Before installing, make sure your environment has:

- **PHP** >= 8.3 (with extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML)
- **Composer** 2.x
- **Node.js** 20.x or newer (with npm)
- **MySQL** 8.0+ (or compatible MariaDB)
- **Git**
- A web server (Apache/Nginx) or use Laravel's built-in server / Laravel Herd

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/hsendeeb/Constructify.git
cd Constructify
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Configure environment

```bash
cp .env.example .env
```

Edit `.env` and set your database credentials and site details:

```env
APP_NAME="Constructify"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=constructify
DB_USERNAME=root
DB_PASSWORD=

# Admin credentials are defined in .env.example (ADMIN_NAME, ADMIN_EMAIL, ADMIN_PASSWORD)
```

Generate the application key:

```bash
php artisan key:generate
```

### 4. Create the database

Create an empty MySQL database matching `DB_DATABASE` (e.g. `constructify`):

```sql
CREATE DATABASE constructify CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Run migrations and seeders

For a fresh install, run migrations with the seeders to populate demo content and the admin account:

```bash
php artisan migrate --seed
```

> Seeders are intended for a brand-new database only. Running them on a database with real content will overwrite it.

### 6. Install frontend dependencies and build assets

```bash
npm install
npm run build
```

For development with hot module replacement:

```bash
npm run dev
```

### 7. (Optional) Link storage

```bash
php artisan storage:link
```

### 8. Start the application

Using Laravel's built-in server:

```bash
php artisan serve
```

Or run the full development stack (server, queue worker, logs, Vite):

```bash
composer run dev
```

The site will be available at `APP_URL` (default `http://localhost:8000`).

## Admin Panel

The Filament admin panel is available at `/admin`. The initial administrator account is created by the seeder using the `ADMIN_NAME`, `ADMIN_EMAIL`, and `ADMIN_PASSWORD` values from `.env` (see `.env.example` for the defaults). Change these values before deploying to production.

## Development

```bash
# Run all dev processes (server, queue, pail, vite)
composer run dev

# Run tests
php artisan test

# Format code
vendor/bin/pint
```

## Testing

This project uses Pest. Run the test suite with:

```bash
php artisan test
# or
vendor/bin/pest
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).