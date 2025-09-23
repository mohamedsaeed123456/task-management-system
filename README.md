📋 Task Management System

A Laravel-based task management system with role-based access control, task dependencies, and a RESTful API. Users can manage, assign, and track tasks depending on their roles.

🛠️ Tech Stack

Backend: Laravel 12

Database: MySQL 8.0

Authentication: Laravel Sanctum

Containerization (Optional): Laravel Sail

🚀 Quick Setup

You can run the project using XAMPP or Laravel Sail (Docker).

Method 1: XAMPP Server (Recommended)

Start XAMPP

Start Apache and MySQL services.

Install dependencies:

composer install

Environment setup:

cp .env.example .env
php artisan key:generate

Configure database:

Update .env file:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management
DB_USERNAME=root
DB_PASSWORD=

Run migrations and seeders:

php artisan migrate --force
php artisan db:seed --force

Start the server:

php artisan serve

Access the application:

Web App: http://localhost:8000

API: http://localhost:8000/api

Method 2: Laravel Sail (Optional - Docker Containerization)

Install dependencies:

composer install

Start Sail containers:

./vendor/bin/sail up -d

Setup database:

./vendor/bin/sail artisan migrate --force
./vendor/bin/sail artisan db:seed --force

Access the application:

Web App: http://localhost

API: http://localhost/api

⚠️ Make sure you have Docker and WSL2 installed for Sail to work.

📚 API Endpoints
Method Endpoint Description Access
POST /api/login Login Public
GET /api/me Current user info Auth
POST /api/logout Logout Auth
GET /api/tasks List tasks Auth
GET /api/tasks/{task_id} Details of specific task Auth
POST /api/tasks Create task Manager
PUT /api/tasks/{id} Update task Role-based
POST /api/tasks/{id}/assign-user Assign user to task Manager
POST /api/tasks/{id}/dependencies Add task dependencies Manager

✅ All API requests require Sanctum authentication for protected routes.
Include the header: Authorization: Bearer {token}
⚠️ Exception: The login API does not require authentication.

🔐 User Roles & Permissions
Role Permissions
Manager Full access: create, update, assign tasks, manage dependencies, view all tasks
User Limited access: view assigned tasks and update task status only

🌐 Access URLs
XAMPP: http://localhost:8000 (using php artisan serve)

Laravel Sail: http://localhost (port 80)
