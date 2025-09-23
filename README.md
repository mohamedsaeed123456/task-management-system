# 📋 Task Management System

A Laravel-based Task Management System with role-based access control, task dependencies, and a RESTful API. Users can manage, assign, and track tasks depending on their roles.

## 🛠️ Tech Stack

-   **Backend:** Laravel 12
-   **Database:** MySQL 8.0
-   **Authentication:** Laravel Sanctum
-   **Containerization (Optional):** Laravel Sail

## 🚀 Quick Setup

You can run the project using XAMPP or Laravel Sail (Docker).

### Method 1: XAMPP Server (Recommended)

1. **Start XAMPP**

    - Start Apache and MySQL services

2. **Install dependencies:**

    ```bash
    composer install
    ```

3. **Environment setup:**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Configure database:**
   Update `.env`:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=task_management
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5. **Run migrations and seeders:**

    ```bash
    php artisan migrate --force
    php artisan db:seed --force
    ```

6. **Start the server:**

    ```bash
    php artisan serve
    ```

7. **Access the application:**
    - **Web App:** `http://localhost:8000`
    - **API:** `http://localhost:8000/api`

### Method 2: Laravel Sail (Optional - Docker Containerization)

1. **Install dependencies:**

    ```bash
    composer install
    ```

2. **Start Sail containers:**

    ```bash
    ./vendor/bin/sail up -d
    ```

3. **Setup database:**

    ```bash
    ./vendor/bin/sail artisan migrate --force
    ./vendor/bin/sail artisan db:seed --force
    ```

4. **Access the application:**
    - **Web App:** `http://localhost`
    - **API:** `http://localhost/api`

> ⚠️ **Note:** Make sure Docker and WSL2 are installed for Sail to work.

## 📚 API Endpoints

| Method | Endpoint                       | Description              | Access     |
| ------ | ------------------------------ | ------------------------ | ---------- |
| POST   | `/api/login`                   | Login                    | Public     |
| GET    | `/api/me`                      | Current user info        | Auth       |
| POST   | `/api/logout`                  | Logout                   | Auth       |
| GET    | `/api/tasks`                   | List tasks               | Auth       |
| GET    | `/api/tasks/{task_id}`         | Details of specific task | Auth       |
| POST   | `/api/tasks`                   | Create task              | Manager    |
| PUT    | `/api/tasks/{id}`              | Update task              | Role-based |
| POST   | `/api/tasks/{id}/assign-user`  | Assign user to task      | Manager    |
| POST   | `/api/tasks/{id}/dependencies` | Add task dependencies    | Manager    |

### Authentication

All protected API requests require Sanctum authentication with header:

```http
Authorization: Bearer {token}
```

> ⚠️ **Exception:** The login API does not require authentication.

## 🔐 User Roles & Permissions

### Manager Role

-   ✅ Full access: create, update, assign tasks
-   ✅ Manage dependencies
-   ✅ View all tasks

### User Role

-   ✅ Limited access: view assigned tasks only
-   ✅ Update task status only

## 🌐 Access URLs

-   **XAMPP:** `http://localhost:8000` (using php artisan serve)
-   **Laravel Sail:** `http://localhost` (port 80)

## 📋 Features

-   **Role-Based Access Control** - Different permissions for managers and users
-   **Task Dependencies** - Tasks cannot be completed until dependencies are finished
-   **Advanced Filtering** - Filter by status, due date range, and assigned user
-   **RESTful API** - Clean API endpoints with proper HTTP status codes
-   **Stateless Authentication** - Secure token-based authentication
-   **Data Validation** - Comprehensive input validation and error handling

## 🚀 Getting Started

1. Clone the repository
2. Choose your preferred setup method (XAMPP or Sail)
3. Follow the setup instructions above
4. Access the application and start managing tasks!

---

**Happy Task Managing! 🎉**
