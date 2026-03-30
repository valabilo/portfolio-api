# ⚡ ValOS — Interactive Developer Portfolio

<p align="center">
  <img src="public/favicon.svg" width="60" alt="ValOS Logo" />
</p>

<p align="center">
  A macOS-inspired, fully interactive portfolio OS built with <strong>React + Vite</strong> on the frontend and <strong>Laravel 12</strong> on the backend — 100% database-driven, zero hardcoded content.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/React-19-61DAFB?logo=react&logoColor=black" />
  <img src="https://img.shields.io/badge/Vite-8-646CFF?logo=vite&logoColor=white" />
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/MySQL-8-4479A1?logo=mysql&logoColor=white" />
  <img src="https://img.shields.io/badge/TailwindCSS-4-38BDF8?logo=tailwindcss&logoColor=white" />
  <img src="https://img.shields.io/badge/License-MIT-green" />
</p>

---

## 📸 Overview

ValOS is a desktop-OS–themed portfolio for **Val Krystoper Abilo**, QA Engineer II. Visitors experience a full boot sequence, draggable windows, a taskbar, desktop icons, a right-click context menu, and a live clock — all running in the browser.

Every piece of portfolio content — profile, experience, skills, projects, education, and awards — is fetched from a single `GET /api/portfolio` endpoint backed by MySQL. Update the database; the site reflects it instantly.

---

## ✨ Features

| Feature | Details |
|---|---|
| 🖥️ **OS Desktop UX** | Draggable, resizable-feel windows; taskbar; desktop icons; boot animation |
| ⚡ **Boot Screen** | Animated log-line boot sequence before the desktop appears |
| 🗂️ **6 Window Apps** | Welcome · About (terminal) · Skills (test runner) · Experience (Jira board) · Projects (file explorer) · Contact (mail client) |
| 📋 **Jira-Style Experience** | Work history displayed as expandable Jira issues with tags and bullets |
| 🧪 **Jest-Style Skills** | Skills rendered as an animated test-runner with PASS/LEARN badges and progress bars |
| 📁 **File Explorer Projects** | Project sidebar + detail panel with metadata, tags, and GitHub links |
| 📧 **Mail Compose Contact** | Contact form posts to Laravel API; sends a branded HTML email notification |
| 💻 **Terminal About** | Animated typewriter terminal with education, awards, and bio from the DB |
| 📱 **Mobile Fallback** | Fully responsive non-JS fallback for screens ≤ 800px — all data from API |
| 🔔 **Notification Toast** | Auto-dismissing "open to opportunities" notification |
| 🖱️ **Context Menu** | Right-click desktop menu with quick links |
| 🕐 **Live Clock** | PH locale time/date in the taskbar |
| 🌐 **CORS-Ready** | Configured for local dev and Vercel prod origins |

---

## 🏗️ Architecture

```
┌──────────────────────────────────────────────────────────┐
│                     Browser (Vite + React)                │
│  BootScreen → Desktop → Windows (6 apps) + Taskbar       │
│             ↕ GET /api/portfolio (once at boot)           │
└───────────────────────┬──────────────────────────────────┘
                        │
┌───────────────────────▼──────────────────────────────────┐
│               Laravel 12 REST API                         │
│  PortfolioController  │  ContactController                │
│         ↕                      ↕                          │
│              MySQL Database                               │
│  profile · experiences · skill_suites · skills            │
│  projects · project_meta · project_tags                   │
│  education · awards · contacts                            │
└──────────────────────────────────────────────────────────┘
```

### Data Flow

1. On mount, `usePortfolioData` fires a single `GET /api/portfolio` request.
2. The response is cached at module level — no duplicate fetches across navigation.
3. All six window components receive their data via props from `Desktop.jsx`.
4. The `ContactContent` window posts to `POST /api/contact`, which saves the message and sends a branded HTML email to Val.

---

## 🗂️ Project Structure

```
val-portfolio/          ← React + Vite frontend
├── src/
│   ├── App.jsx                  # Root: boot gate + data fetch
│   ├── components/
│   │   ├── Desktop.jsx          # Window manager + icons + taskbar
│   │   ├── Window.jsx           # Draggable OS window shell
│   │   ├── Taskbar.jsx          # Bottom bar with clock
│   │   ├── BootScreen.jsx       # Animated boot log
│   │   ├── ContextMenu.jsx      # Right-click menu
│   │   ├── MobileFallback.jsx   # Mobile-only view
│   │   └── windows/
│   │       └── index.jsx        # All 6 window content components
│   ├── data/
│   │   └── index.js             # UI config only (boot msgs, icon labels, window sizes)
│   ├── hooks/
│   │   ├── useWindowManager.js  # Open/close/minimize/z-index state
│   │   ├── useDraggable.js      # Mouse + touch drag logic
│   │   └── usePortfolioData.js  # Single API fetch with cancel on unmount
│   └── index.css                # Full ValOS design system (CSS vars + component classes)
│
portfolio-api/          ← Laravel 12 backend (same repo)
├── app/
│   ├── Http/Controllers/Api/
│   │   ├── PortfolioController.php   # GET /api/portfolio
│   │   └── ContactController.php     # POST /api/contact
│   ├── Mail/ContactReceived.php      # Mailable
│   └── Models/                       # 12 Eloquent models
├── database/
│   ├── migrations/              # Full schema (13 migration files)
│   └── seeders/                 # 6 seeders — all real portfolio data
├── resources/views/emails/      # Branded HTML + plain-text email templates
├── routes/api.php               # All API routes
└── config/cors.php              # CORS origins config
```

---

## 🚀 Getting Started

### Prerequisites

| Tool | Version |
|---|---|
| Node.js | ≥ 20 |
| PHP | ≥ 8.2 |
| Composer | ≥ 2 |
| MySQL | ≥ 8 (via XAMPP or native) |

---

### 1 · Clone the Repository

```bash
git clone https://github.com/YOUR_USERNAME/val-portfolio.git
cd val-portfolio
```

---

### 2 · Backend Setup (Laravel API)

```bash
# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate
```

**Configure `.env`** — update these values:

```dotenv
APP_NAME=ValOS
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=val_portfolio
DB_USERNAME=root
DB_PASSWORD=

# Email — use Gmail App Password or Mailtrap for dev
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

**Create the database, run migrations and seed:**

```bash
# Create the MySQL database first (or use XAMPP phpMyAdmin)
mysql -u root -e "CREATE DATABASE val_portfolio;"

# Run all migrations
php artisan migrate

# Seed all portfolio data
php artisan db:seed

# Start the API server
php artisan serve
# → Running at http://localhost:8000
```

---

### 3 · Frontend Setup (React + Vite)

```bash
# Install JS dependencies
npm install

# Start the dev server
npm run dev
# → Running at http://localhost:5173
```

The frontend reads `VITE_API_URL` from `.env` (already set to `http://localhost:8000`).

---

### 4 · Visit the Portfolio

Open **http://localhost:5173** — you'll see the ValOS boot screen, then the interactive desktop.

---

## 🗄️ Database Schema

| Table | Purpose |
|---|---|
| `profile` | Name, role, bio, contact info, availability flag |
| `experiences` | Work history (issue key, title, location, status, date range) |
| `experience_bullets` | Bullet points per experience |
| `experience_tags` | Skill tags per experience |
| `skill_suites` | Skill category groups (QA, API, Tools, Dev Stack) |
| `skills` | Individual skills with percentage and pass/warn tag |
| `projects` | Project cards (key, icon, name, type, description, GitHub URL) |
| `project_meta` | Key-value metadata per project (status, coverage, etc.) |
| `project_tags` | Technology tags per project |
| `education` | Degree, certifications, training entries |
| `awards` | Awards and recognition |
| `contacts` | Contact form submissions |

---

## 🌐 API Reference

Base URL: `http://localhost:8000/api`

| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/portfolio` | Returns complete portfolio payload (profile, education, awards, experiences, skillSuites, projects) |
| `POST` | `/contact` | Saves contact form submission and sends email notification |
| `GET` | `/contacts` | List all contact submissions |
| `PATCH` | `/contacts/{id}/read` | Mark a message as read |
| `GET` | `/health` | API health check |

### `/api/portfolio` Response Shape

```json
{
  "profile": { "name": "...", "role": "...", "bio": "...", "location": "...", "email": "...", "phone": "...", "linkedin_url": "...", "github_url": "...", "available": true },
  "education": [ { "type": "degree|certification|training", "title": "...", "institution": "...", "year": "..." } ],
  "awards": [ { "title": "...", "issuer": "...", "year": "..." } ],
  "experiences": [ { "key": "VK-003", "title": "...", "sub": "...", "status": "progress|done", "type": "FULL-TIME", "date": "...", "bullets": [], "tags": [] } ],
  "skillSuites": [ { "id": "qa", "label": "...", "countText": "...", "tests": [ { "name": "...", "pct": 100, "tag": "pass|warn" } ] } ],
  "projects": [ { "id": "p1", "icon": "🌐", "name": "...", "label": "...", "type": "...", "desc": "...", "github": "...", "meta": [], "tags": [] } ]
}
```

---

## 🎨 Design System

All styles live in `src/index.css` using CSS custom properties:

```css
--os-bg:       #05050F    /* Desktop background */
--win-bg:      rgba(9,9,22,0.97)  /* Window background */
--border:      rgba(255,255,255,0.07)
--border-act:  rgba(0,229,255,0.25)  /* Active window border */
--cyan:        #00E5FF    /* Primary accent */
--green:       #00FF88    /* Success / available */
--red:         #FF4466    /* Error / close button */
--amber:       #FFB800    /* Warning / minimize */
--text:        #C8D8F0
--text-dim:    #4A6080
--text-bright: #E8F4FF
--mono:        'JetBrains Mono', monospace
```

---

## 📦 Building for Production

### Frontend

```bash
npm run build
# Output → dist/
```

### Backend

```bash
php artisan config:cache
php artisan route:cache
php artisan optimize
```

**Update CORS for production** in `config/cors.php`:

```php
'allowed_origins' => [
    'https://YOUR-APP.vercel.app',
],
```

---

## 🔧 Customization

All portfolio content lives in the **database seeders**. To update:

| What to change | File |
|---|---|
| Name, bio, contact info | `database/seeders/ProfileSeeder.php` |
| Work experience | `database/seeders/ExperienceSeeder.php` |
| Skills | `database/seeders/SkillSeeder.php` |
| Projects | `database/seeders/ProjectSeeder.php` |
| Education | `database/seeders/EducationSeeder.php` |
| Awards | `database/seeders/AwardSeeder.php` |

After editing, re-seed:

```bash
php artisan db:seed --class=ProfileSeeder
# or re-seed everything:
php artisan migrate:fresh --seed
```

---

## 🧪 Testing

### Backend (PHPUnit)

```bash
php artisan test
```

### Frontend (Playwright — E2E)

```bash
npx playwright test
```

---

## 🚢 Deployment

### Frontend → Vercel

1. Push to GitHub
2. Import repo in Vercel
3. Set environment variable: `VITE_API_URL=https://your-api-domain.com`
4. Build command: `npm run build` · Output: `dist`

### Backend → Any PHP Host (Hostinger, Railway, etc.)

1. Upload files, run `composer install --no-dev`
2. Set `.env` production values
3. `php artisan migrate --force && php artisan db:seed --force`
4. Point document root to `/public`

---

## 📁 Tech Stack

**Frontend**
- React 19 + Vite 8
- Tailwind CSS 4
- Axios
- JetBrains Mono (Google Fonts)

**Backend**
- Laravel 12
- MySQL 8
- Laravel Mail (SMTP)
- PHPUnit 11

---

## 🤝 Contributing

This is a personal portfolio project. Feel free to fork it and adapt it for your own use — just update the seeder data with your own information.

---

## 📄 License

MIT License — see [LICENSE](LICENSE) for details.

---

<p align="center">
  Built by <strong>Val Krystoper Abilo</strong> · QA Engineer II · Manggahan, Pasig City, PH
  <br/>
  <a href="https://linkedin.com/in/valkrystoper-abilo-a5b88a236">LinkedIn</a> ·
  <a href="mailto:abilovalkrystoper@gmail.com">Email</a>
</p>
