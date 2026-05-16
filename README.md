<p align="center">
  <h1 align="center">🛍️ Elekoo E-Commerce</h1>
</p>

<p align="center">
  A modern, responsive, and full-featured e-commerce web application built with <strong>Laravel</strong> and <strong>Tailwind CSS</strong>.
</p>

---

## 🌟 About Elekoo

Elekoo (formerly TechNova) is a comprehensive e-commerce platform designed to provide a seamless shopping experience for customers and an efficient management system for administrators. It handles the entire shopping lifecycle—from product discovery and cart management to checkout and admin order fulfillment.

## ✨ Features

### For Customers (Front-end)
- **User Authentication:** Registration, login, password reset, and profile management.
- **Product Discovery:** Browse products, view detailed descriptions, and explore categories.
- **Shopping Cart & Wishlist:** Add products to cart or save them for later in a wishlist.
- **Secure Checkout:** Streamlined checkout process and order placement.
- **Order Tracking:** View order history and status.

### For Administrators (Back-end)
- **Dashboard:** Overview of store metrics and recent activities.
- **Product Management:** Add, edit, delete, and categorize products.
- **Category Management:** Organize products into distinct categories.
- **Order Management:** View, update order statuses, and fulfill customer orders.
- **User Management:** Monitor registered customers.

## 💻 Technology Stack

- **Framework:** [Laravel 11](https://laravel.com/) (PHP)
- **Styling:** [Tailwind CSS](https://tailwindcss.com/)
- **Frontend Build Tool:** [Vite](https://vitejs.dev/)
- **Database:** MySQL / SQLite

## 🚀 Getting Started

Follow these instructions to set up the project locally on your machine.

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & npm
- Database Server (MySQL, SQLite, etc.)

### Installation Steps

1. **Clone the repository:**
   ```bash
   git clone https://github.com/RaihanAryoWicaksono/Elekoo.git
   cd Elekoo
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install NPM dependencies:**
   ```bash
   npm install
   ```

4. **Environment Setup:**
   Copy the example `.env` file and configure your database credentials.
   ```bash
   cp .env.example .env
   ```
   *Note: Open `.env` and update the `DB_*` variables according to your local database setup.*

5. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

6. **Run Database Migrations and Seeders:**
   This will create the necessary tables and populate the database with initial sample data (termasuk akun admin).
   ```bash
   php artisan migrate --seed
   ```

7. **Link Storage (Jika menggunakan gambar lokal):**
   ```bash
   php artisan storage:link
   ```

8. **Start the Development Servers:**
   Jalankan server backend Laravel:
   ```bash
   php artisan serve
   ```
   Di terminal terpisah, jalankan Vite untuk aset frontend:
   ```bash
   npm run dev
   ```

9. **Access the Application:**
   Buka browser Anda dan kunjungi `http://localhost:8000`.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
