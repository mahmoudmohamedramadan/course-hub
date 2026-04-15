# Course Hub

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

### 5. Build assets

Choose your workflow:

```bash
npm run dev
```

```bash
# Production build
npm run build
```

---

### 6. Run migrations & seed data

```bash
php artisan migrate --seed
```

This will:

- Create an admin user for Filament
- Seed demo LMS data (courses, lessons, etc.)
- Create a test student with pre-filled progress

---

### 7. Serve the application

```bash
php artisan serve
```

Visit: <http://127.0.0.1:8000>

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

## ➕ Creating an Admin User

If you skip seeding or need another admin:

```bash
php artisan make:filament-user
```

---

## 🧱 Tech Stack

- **Laravel** — backend framework  
- **Livewire** — dynamic UI without SPA complexity  
- **Filament** — admin panel  
- **Tailwind CSS** — styling  

---

## 📌 Notes

- Keep `npm run dev` running during development for Vite assets  
- SQLite is used for simplicity; switch to MySQL/PostgreSQL if needed  
- YouTube videos are embedded via iframe (no direct video streaming)

---

## 📄 License

This project is open-sourced under the MIT license.
