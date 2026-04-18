# Course Hub

> [!IMPORTANT]
>
> - **Filament Admin Authentication** — Uses a dedicated **`admins`** table and **`admin`** guard. See **[`docs/FILAMENT_ADMIN_AUTH.md`](docs/FILAMENT_ADMIN_AUTH.md)**.
> - **Navigation Badges** — Cached model counts in the sidebar. See **[`docs/FILAMENT_NAVIGATION_BADGE.md`](docs/FILAMENT_NAVIGATION_BADGE.md)**.
> - **Guarded Deletes** — Prevents deleting records with active relations. See **[`docs/DELETE_ACTIVE_RELATIONS.md`](docs/DELETE_ACTIVE_RELATIONS.md)**.

A Laravel-based Learning Management System featuring a **student-facing course experience** and a **Filament-powered admin panel**.

- 🎓 Browse courses, enroll, and track lesson progress  
- ⚡ Livewire-driven interactive UI  
- 🛠 Admin panel for managing courses, lessons, and instructors  

Admin panel is available at `/admin`.

---

## 🚀 Getting Started

Follow these steps to get the project running locally.

### 1. Clone the repository

```bash
git clone https://github.com/mahmoudmohamedramadan/course-hub course-hub

cd course-hub
```

---

### 2. Setup environment

```bash
cp .env.example .env

php artisan key:generate
```

---

### 3. Configure database (SQLite)

This project uses SQLite by default.

```env
DB_CONNECTION=sqlite
```

Create the database file:

```bash
touch database/database.sqlite
```

---

### 4. Install dependencies

**Backend:**

```bash
composer install
```

**Frontend:**

```bash
npm install
```

---

### 5. Run migrations & seed data

```bash
php artisan migrate --seed
```

This will:

- Create an admin user for Filament
- Seed demo LMS data (courses, lessons, etc.)
- Create a test student with pre-filled progress

---

### 6. Run the development servers

For local development you need **two processes**: Laravel (HTTP) and Vite (asset bundling / hot reload).

**1. Start Laravel** (from the project root):

```bash
php artisan serve
```

By default the app is available at **<http://127.0.0.1:8000>** (use the URL shown in the terminal if it differs).

**2. Start Vite** (in a second terminal, same directory):

```bash
npm run dev
```

Keep both terminals open while you work. For a production-style asset build instead of the dev server, use `npm run build`.

---

## 🔐 Demo Credentials

|  Role       |  URL     |  Email             |  Password  |
|-------------|----------|--------------------|------------|
| **Admin**   | `/admin` | `admin@admin.com`  | `password` |
| **Student** | `/login` | `student@lms.test` | `password` |

### Seeded Student Details

The test student is:

- Enrolled in **3 courses**
- Has completed **2 lessons per course**

This helps you immediately verify:

- Progress tracking
- Lesson player behavior
- Dashboard state

---

## 🧱 Tech Stack

- **Laravel 13** — application backend  
- **Livewire** — interactive UI without a separate SPA  
- **Filament** — admin panel  
- **Tailwind CSS** — styling  
- **Vite** — frontend build tool and dev server  

---

## 📄 License

This project is open-sourced under the MIT license.
