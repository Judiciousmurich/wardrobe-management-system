# Wardrobe Management System

## Introduction
The **Wardrobe Management System** is a full-stack web application designed to help users organize and manage their wardrobe efficiently. The backend is built using **Laravel (PHP)**, and the frontend is developed with **Vue 3**. Users can register, log in, add clothing items, categorize them, and even upload images for easy management.

## Features
- User authentication (register, login, logout)
- Add, update, and delete clothing items
- Upload and manage clothing images
- API-based communication between frontend and backend
- Responsive UI built with Vue 3

## Tech Stack
### Backend (Laravel)
- PHP 8+
- Laravel 10+
- MySQL / PostgreSQL
- JWT Authentication
- Laravel Migrations & Seeders

### Frontend (Vue 3)
- Vue.js 3
- Vite
- Vue Router
- Tailwind CSS

## Folder Structure
```
wardrobe-management-system/
│
├── backend/                     # Laravel backend
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── AuthController.php
│   │   │   │   └── ClothingItemController.php
│   │   │   └── Middleware/
│   │   ├── Models/
│   │   │   ├── User.php
│   │   │   └── ClothingItem.php
│   ├── routes/
│   │   ├── api.php  # API routes
│   │   ├── web.php  # Web routes
│   ├── database/
│   │   ├── migrations/
│   │   │   ├── 2014_10_12_000000_create_users_table.php
│   │   │   └── 2023_xx_xx_create_clothing_items_table.php
│   ├── public/
│   ├── storage/
│   ├── .env
│   ├── artisan
│   └── composer.json
│
├── frontend/                    # Vue 3 frontend
│   ├── src/
│   │   ├── components/
│   │   │   ├── LoginRegister.vue
│   │   │   └── WardrobeManager.vue
│   │   ├── App.vue
│   │   ├── main.js
│   ├── package.json
│   ├── vite.config.js
│
├── .gitignore
└── README.md
```

## Installation & Setup

### Prerequisites
Ensure you have the following installed:
- PHP 8+
- Composer
- Node.js & npm
- MySQL/PostgreSQL
- Laravel CLI

### Backend Setup
1. Navigate to the backend directory:
   ```sh
   cd backend
   ```
2. Install dependencies:
   ```sh
   composer install
   ```
3. Copy environment variables:
   ```sh
   cp .env.example .env
   ```
4. Generate an application key:
   ```sh
   php artisan key:generate
   ```
5. Configure database in `.env` and run migrations:
   ```sh
   php artisan migrate --seed
   ```
6. Start Laravel development server:
   ```sh
   php artisan serve
   ```

### Frontend Setup
1. Navigate to the frontend directory:
   ```sh
   cd frontend
   ```
2. Install dependencies:
   ```sh
   npm install
   ```
3. Start the Vue development server:
   ```sh
   npm run dev
   ```

### Running the Project
Once both servers are running:
- **Backend API**: `http://127.0.0.1:8000`
- **Frontend**: `http://localhost:5173`

## API Endpoints
| Method | Endpoint | Description |
|--------|---------|-------------|
| POST   | /api/register | Register a new user |
| POST   | /api/login | User login |
| GET    | /api/clothing-items | Get all clothing items |
| POST   | /api/clothing-items | Add a new clothing item |
| PUT    | /api/clothing-items/{id} | Update clothing item |
| DELETE | /api/clothing-items/{id} | Delete clothing item |

## Contributing
Feel free to fork this repository and contribute to improving the Wardrobe Management System. You can open issues for bug reports, feature requests, or discussions.

## License
This project is open-source and available under the [MIT License](LICENSE).

---

### Happy Coding! 🚀

