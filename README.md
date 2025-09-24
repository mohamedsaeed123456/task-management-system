# 📋 Task Management System

A Laravel-based Task Management System with role-based access control, task dependencies, and a RESTful API. Users can create, assign, and track tasks depending on their roles.

---

## 🛠️ Tech Stack

-   **Backend:** Laravel 12
-   **Database:** MySQL 8.0
-   **Authentication:** Laravel Sanctum
-   **Containerization (optional):** Laravel Sail (Docker)

---

## 🚀 Quick Setup

You can run the project using XAMPP (recommended for Windows) or Laravel Sail (Docker).

> **Windows users:** before cloning, run:

```bash
git config --global core.longpaths true
```

1. Clone the repository:

```bash
git clone <repository-url>
cd <repository-folder>
```

### Method 1 — XAMPP (recommended)

1. Start Apache and MySQL from XAMPP control panel.
2. Install PHP dependencies:

```bash
composer install
```

3. Copy environment file and set application key:

```bash
cp .env.example .env
php artisan key:generate
```

4. Configure the database in `.env` (example):

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management
DB_USERNAME=root
DB_PASSWORD=
```

> **Note:** Create the database (e.g. `task_management`) in phpMyAdmin or MySQL before running migrations.

5. Run migrations and seeders:

```bash
php artisan migrate --force
php artisan db:seed --force
```

6. Start the local server:

```bash
php artisan serve
```

7. Access the app:

-   Web: `http://localhost:8000`
-   API: `http://localhost:8000/api`

### Method 2 — Laravel Sail (Docker)

1. Install Composer dependencies:

```bash
composer install
```

2. Start Sail (requires Docker & WSL2 on Windows):

```bash
./vendor/bin/sail up -d
```

3. Run migrations and seeders inside Sail:

```bash
./vendor/bin/sail artisan migrate --force
./vendor/bin/sail artisan db:seed --force
```

4. Access the app:

-   Web: `http://localhost`
-   API: `http://localhost/api`

---

## 🔐 Authentication

This project uses Laravel Sanctum. Include the token in protected API requests:

```
Authorization: Bearer {token}
```

> The `/api/login` endpoint is public and does not require authentication.

---

## 📚 API Endpoints (main)

| Method | Endpoint                       | Description           | Access     |
| ------ | ------------------------------ | --------------------- | ---------- |
| POST   | `/api/login`                   | Login (returns token) | Public     |
| GET    | `/api/me`                      | Current user info     | Auth       |
| POST   | `/api/logout`                  | Logout                | Auth       |
| GET    | `/api/tasks`                   | List tasks            | Auth       |
| GET    | `/api/tasks/{task_id}`         | Task details          | Auth       |
| POST   | `/api/tasks`                   | Create task           | Manager    |
| PUT    | `/api/tasks/{id}`              | Update task           | Role-based |
| POST   | `/api/tasks/{id}/assign-user`  | Assign user to task   | Manager    |
| POST   | `/api/tasks/{id}/dependencies` | Add task dependencies | Manager    |

---

## 👥 Roles & Permissions

### Manager

-   Full access to create, update and assign tasks
-   Can manage dependencies
-   Can view all tasks

### User

-   Can view tasks assigned to them
-   Can update task status

---

## 📋 Key Features

-   Role-based access control
-   Task dependencies (tasks cannot be completed until dependencies are finished)
-   Filtering by status, due date range, and assigned user
-   RESTful API with proper HTTP status codes
-   Token-based authentication (Sanctum)
-   Input validation and error handling

---

**Happy task managing! 🎉**
