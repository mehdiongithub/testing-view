# Full Stack Application

A full-stack web application built with:

- Backend: Laravel REST API
- Frontend: React.js + Vite
- Database: MySQL
- Authentication: API based authentication
- Communication: Axios


## Project Structure
project-root/

├── backend/
│ ├── app/
│ │ ├── Http/
│ │ │ ├── Controllers/
│ │ │ │ ├── Auth/
│ │ │ │ │ └── AuthController.php
│ │ │ │ ├── User/
│ │ │ │ │ └── UserController.php
│ │ │ │ ├── Product/
│ │ │ │ │ └── ProductController.php
│ │ │ │ └── Order/
│ │ │ │ └── OrderController.php
│ │ │ ├── Middleware/
│ │ │ │ └── AuthMiddleware.php
│ │ │ └── Requests/
│ │ │ ├── LoginRequest.php
│ │ │ └── ProductRequest.php
│ │ │
│ │ ├── Models/
│ │ │ ├── User.php
│ │ │ ├── Product.php
│ │ │ └── Order.php
│ │ │
│ │ └── Services/
│ │ ├── AuthService.php
│ │ └── ProductService.php
│ │
│ ├── routes/
│ │ └── api.php
│ │
│ ├── database/
│ │ └── migrations/
│ │
│ └── .env

├── frontend/
│ ├── src/
│ │ ├── api/
│ │ │ ├── axiosInstance.js
│ │ │ ├── authApi.js
│ │ │ ├── userApi.js
│ │ │ ├── productApi.js
│ │ │ └── orderApi.js
│ │ │
│ │ ├── modules/
│ │ │ ├── auth/
│ │ │ │ ├── Login.jsx
│ │ │ │ ├── Register.jsx
│ │ │ │ └── useAuth.js
│ │ │ │
│ │ │ ├── user/
│ │ │ │ ├── UserList.jsx
│ │ │ │ ├── UserForm.jsx
│ │ │ │ └── useUser.js
│ │ │ │
│ │ │ ├── product/
│ │ │ │ ├── ProductList.jsx
│ │ │ │ ├── ProductForm.jsx
│ │ │ │ └── useProduct.js
│ │ │ │
│ │ │ └── order/
│ │ │ ├── OrderList.jsx
│ │ │ ├── OrderDetail.jsx
│ │ │ └── useOrder.js
│ │ │
│ │ ├── components/
│ │ │ ├── Navbar.jsx
│ │ │ ├── Sidebar.jsx
│ │ │ ├── Button.jsx
│ │ │ ├── Modal.jsx
│ │ │ └── Table.jsx
│ │ │
│ │ ├── context/
│ │ │ └── AuthContext.jsx
│ │ │
│ │ ├── routes/
│ │ │ ├── AppRoutes.jsx
│ │ │ └── PrivateRoute.jsx
│ │ │
│ │ ├── utils/
│ │ │ ├── helpers.js
│ │ │ └── constants.js
│ │ │
│ │ └── main.jsx
│ │
│ ├── .env
│ └── vite.config.js


# Requirements
## Backend Requirements
- PHP >= 8.1
- Composer
- MySQL
- Laravel 10+
- Node.js & NPM


## Frontend Requirements
- Node.js >= 18
- NPM


```bash
php -v

composer -v

node -v

npm -v

# git clone YOUR_REPOSITORY_URL

# Backend Setup
cd backend
composer install
cp .env.example .env
php artisan key:generate

# backend/.env

# Setup Database Configuration

# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=your_database
# DB_USERNAME=root
# DB_PASSWORD=

# Create database in MySQL:

# CREATE DATABASE your_database;

php artisan migrate

# (Optional) Run seeders:
php artisan db:seed

# Start Laravel server:

php artisan serve

# Backend will run on:

http://127.0.0.1:8000



# Frontend Setup (React)

cd frontend
npm install

# Create environment file:

cp .env.example .env
VITE_API_URL=http://127.0.0.1:8000/api

# Start frontend:

npm run dev

http://localhost:5173

# API Configuration

src/api/axiosInstance.js# testing-view
