# ⚡ ValOS — Portfolio API

<p align="center">
  A Laravel 12 REST API powering the <a href="https://github.com/YOUR_USERNAME/val-portfolio">ValOS frontend portfolio</a>.
  <br/>
  Serves all portfolio content from MySQL and handles contact form submissions with branded email notifications.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/MySQL-8-4479A1?logo=mysql&logoColor=white" />
  <img src="https://img.shields.io/badge/PHPUnit-11-3775A9?logo=phpunit&logoColor=white" />
  <img src="https://img.shields.io/badge/License-MIT-green" />
</p>

---

## 📋 Overview

The API has two responsibilities:

1. **`GET /api/portfolio`** — Returns the entire portfolio payload in one request. The React frontend calls this once at boot and distributes data to all six window components.
2. **`POST /api/contact`** — Saves contact form submissions to the database and sends a branded HTML email notification to Val.

Everything is database-driven. To update portfolio content, edit the seeders and re-seed — no code changes required.

---

## 🗂️ Project Structure

```
portfolio-api/
├── app/
│   ├── Http/Controllers/Api/
│   │   ├── PortfolioController.php   # GET /api/portfolio
│   │   └── ContactController.php     # POST /api/contact + admin routes
│   ├── Mail/
│   │   └── ContactReceived.php       # Mailable class
│   ├── Models/
│   │   ├── Profile.php
│   │   ├── Experience.php
│   │   ├── ExperienceBullet.php
│   │   ├── ExperienceTag.php
│   │   ├── SkillSuite.php
│   │   ├── Skill.php
│   │   ├── Project.php
│   │   ├── ProjectMeta.php
│   │   ├── ProjectTag.php
│   │   ├── Education.php
│   │   ├── Award.php
│   │   └── Contact.php
│   └── Providers/AppServiceProvider.php
├── database/
│   ├── migrations/                   # 13 migration files
│   └── seeders/
│       ├── DatabaseSeeder.php        # Orchestrates all seeders
│       ├── ProfileSeeder.php
│       ├── ExperienceSeeder.php
│       ├── SkillSeeder.php
│       ├── ProjectSeeder.php
│       ├── EducationSeeder.php
│       └── AwardSeeder.php
├── resources/views/emails/
│   ├── contact-received.blade.php       # Branded HTML email
│   └── contact-received-text.blade.php  # Plain-text fallback
├── routes/
│   └── api.php
├── config/
│   ├── cors.php                      # CORS origins
│   └── mail.php                      # Mail config + portfolio recipient
└── bootstrap/app.php                 # CORS middleware registration
```

---

## 🚀 Getting Started

### Prerequisites

| Tool | Version |
|---|---|
| PHP | ≥ 8.2 |
| Composer | ≥ 2 |
| MySQL | ≥ 8 |
| XAMPP / Laragon / native MySQL | any |

### Install

```bash
# 1. Clone
git clone https://github.com/YOUR_USERNAME/portfolio-api.git
cd portfolio-api

# 2. Install PHP dependencies
composer install

# 3. Copy environment file
cp .env.example .env

# 4. Generate app key
php artisan key:generate
```

### Configure `.env`

```dotenv
APP_NAME=ValOS
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=val_portfolio
DB_USERNAME=root
DB_PASSWORD=

# Email notification settings
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=your@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_FROM_ADDRESS=noreply@val-portfolio.dev
MAIL_FROM_NAME="ValOS Portfolio"
MAIL_PORTFOLIO_RECIPIENT=abilovalkrystoper@gmail.com
```

> **Tip:** Use Mailtrap (`MAIL_MAILER=log`) during development to skip real email sending. Messages will be written to `storage/logs/laravel.log`.

### Set Up the Database

```bash
# Create the database (or use phpMyAdmin)
mysql -u root -e "CREATE DATABASE val_portfolio;"

# Run all migrations
php artisan migrate

# Seed all portfolio data
php artisan db:seed

# Start the API server
php artisan serve
# → http://localhost:8000
```

---

## 🌐 API Reference

Base URL: `http://localhost:8000/api`

### `GET /api/portfolio`

Returns the complete portfolio payload. Called once by the React frontend at boot.

**Response:**

```json
{
  "profile": {
    "name": "Val Krystoper Abilo",
    "role": "QA Engineer II",
    "bio": "...",
    "location": "Manggahan, Pasig City, PH",
    "email": "abilovalkrystoper@gmail.com",
    "phone": "+63 947 809 2197",
    "linkedin_url": "https://linkedin.com/in/...",
    "github_url": "https://github.com/...",
    "available": true
  },
  "education": [
    { "type": "degree", "title": "BS Computer Engineering", "institution": "ICCT Colleges Inc.", "year": "2013" }
  ],
  "awards": [
    { "title": "Top 1 · KodeGo Best Capstone", "issuer": "KodeGo Bootcamp", "year": "2023" }
  ],
  "experiences": [
    {
      "key": "VK-003",
      "title": "Quality Assurance Engineer II · Thurston Software Solutions Inc.",
      "sub": "📍 5F F. Blumentrit, San Juan, Metro Manila",
      "status": "progress",
      "type": "FULL-TIME",
      "date": "Apr 14, 2025 → Present",
      "bullets": ["..."],
      "tags": ["Test Plans", "Regression", "..."]
    }
  ],
  "skillSuites": [
    {
      "id": "qa",
      "label": "Testing · QA & Manual",
      "countText": "6 passed",
      "tests": [
        { "name": "Manual Testing", "pct": 100, "tag": "pass" }
      ]
    }
  ],
  "projects": [
    {
      "id": "p1",
      "icon": "🌐",
      "name": "opencart-test-suite",
      "label": "opencart-suite",
      "type": "WEB APPLICATION TESTING · MANUAL",
      "desc": "...",
      "github": "https://github.com/...",
      "meta": [["Status", "● Active", true], ["Coverage", "92%", true]],
      "tags": ["Manual Testing", "Excel", "Bug Reports"]
    }
  ]
}
```

---

### `POST /api/contact`

Saves a contact form submission and sends an email notification to Val.

**Request body:**

```json
{
  "name":    "Jane Doe",
  "email":   "jane@example.com",
  "subject": "Job opportunity",
  "message": "Hi Val, I'd like to discuss..."
}
```

**Validation rules:**

| Field | Rules |
|---|---|
| `name` | required, string, max:100 |
| `email` | required, valid email, max:255 |
| `subject` | required, string, max:200 |
| `message` | required, string |

**Success response `201`:**

```json
{ "message": "Message received!" }
```

---

### Other Endpoints

| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/api/contacts` | List all contact submissions |
| `PATCH` | `/api/contacts/{id}/read` | Mark a message as read |
| `GET` | `/api/health` | Health check — returns status, service name, timestamp |

---

## 🗄️ Database Schema

### Tables

| Table | Description |
|---|---|
| `profile` | Single row — name, role, bio, contact info, availability |
| `experiences` | Work history entries (issue key, title, location, status, dates) |
| `experience_bullets` | Bullet points per experience (FK → experiences) |
| `experience_tags` | Skill tags per experience (FK → experiences) |
| `skill_suites` | Skill category groups (QA, API, Tools, Dev Stack) |
| `skills` | Individual skills with percentage and pass/warn tag (FK → skill_suites) |
| `projects` | Project cards with icon, name, type, description, GitHub URL |
| `project_meta` | Key-value metadata rows per project (FK → projects) |
| `project_tags` | Technology tags per project (FK → projects) |
| `education` | Degrees, certifications, and training entries |
| `awards` | Awards and recognition |
| `contacts` | Contact form submissions with `read_at` timestamp |

### Entity Relationships

```
profile           (1 row)

experiences 1──* experience_bullets
            1──* experience_tags

skill_suites 1──* skills

projects 1──* project_meta
         1──* project_tags
```

---

## 📝 Updating Portfolio Content

All content is managed through seeders. No code changes needed — just edit the seeder and re-run.

| Content | Seeder File |
|---|---|
| Name, bio, contact info, availability | `database/seeders/ProfileSeeder.php` |
| Work experience, bullets, tags | `database/seeders/ExperienceSeeder.php` |
| Skill suites and individual skills | `database/seeders/SkillSeeder.php` |
| Projects, metadata, tags | `database/seeders/ProjectSeeder.php` |
| Education entries | `database/seeders/EducationSeeder.php` |
| Awards | `database/seeders/AwardSeeder.php` |

**Re-seed a single seeder:**

```bash
php artisan db:seed --class=ProfileSeeder
```

**Full re-seed (wipes and re-creates all data):**

```bash
php artisan migrate:fresh --seed
```

---

## 📧 Email Notifications

When a contact form is submitted, `ContactController` saves the record first, then attempts to send via `ContactReceived` mailable.

- **To:** `MAIL_PORTFOLIO_RECIPIENT` in `.env`
- **Reply-To:** Set to the sender's email — just hit reply to respond
- **Template:** `resources/views/emails/contact-received.blade.php` (dark-themed HTML)
- **Fallback:** Plain-text version at `contact-received-text.blade.php`
- **Failure handling:** If email sending fails, the contact is still saved and the API returns `201`. The error is logged to `storage/logs/laravel.log`.

**Test with Mailtrap (dev):**

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_user
MAIL_PASSWORD=your_mailtrap_pass
```

---

## 🔒 CORS Configuration

Managed in `config/cors.php`. Update `allowed_origins` before deploying:

```php
'allowed_origins' => [
    'http://localhost:5173',       // Local Vite dev server
    'https://YOUR-APP.vercel.app', // Production frontend
],
```

CORS middleware is registered in `bootstrap/app.php`:

```php
$middleware->api(prepend: [
    \Illuminate\Http\Middleware\HandleCors::class,
]);
```

---

## 🧪 Testing

```bash
# Run the PHPUnit test suite
php artisan test

# Run with coverage (requires Xdebug or PCOV)
php artisan test --coverage
```

Tests live in `tests/Feature/` and `tests/Unit/`. The test environment uses an in-memory SQLite database (configured in `phpunit.xml`).

---

## 🚢 Deployment

### Production `.env` checklist

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-api-domain.com

DB_CONNECTION=mysql
# ... production DB credentials

MAIL_MAILER=smtp
# ... production SMTP credentials
```

### Optimize for production

```bash
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan optimize
```

### Document root

Point your web server to the `/public` directory.

---

## 📦 Key Dependencies

```json
"require": {
  "php":              "^8.2",
  "laravel/framework": "^12.0",
  "laravel/tinker":   "^2.10"
},
"require-dev": {
  "fakerphp/faker":       "^1.23",
  "laravel/pail":         "^1.2",
  "laravel/pint":         "^1.24",
  "laravel/sail":         "^1.41",
  "mockery/mockery":      "^1.6",
  "nunomaduro/collision": "^8.6",
  "phpunit/phpunit":      "^11.5"
}
```

---

## 🔗 Related

- **Frontend:** [val-portfolio](https://github.com/YOUR_USERNAME/val-portfolio) — React + Vite OS-themed portfolio

---

<p align="center">
  Built by <strong>Val Krystoper Abilo</strong> · QA Engineer II · Manggahan, Pasig City, PH
  <br/>
  <a href="https://linkedin.com/in/valkrystoper-abilo-a5b88a236">LinkedIn</a> ·
  <a href="mailto:abilovalkrystoper@gmail.com">Email</a>
</p>
