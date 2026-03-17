# Full Stack Internship Project: User Management System

A robust user registration, login, and profile management system built with a modern Full-Stack architecture.

## 🚀 Overview
This project demonstrates the integration of multiple database technologies and backend logic to create a secure and performant user management experience.

### Key Features
- **Secure Registration**: PHP-based backend with password hashing and MySQL storage.
- **Persistent Login**: Session management using **Redis** for high-performance session lookups.
- **Dynamic Profiles**: User profile details (Age, DOB, Contact, etc.) stored in **MongoDB** for flexible data modeling.
- **Admin Dashboard**: A unified view to monitor data across both MySQL and MongoDB in real-time.
- **Modern UI**: Built with **Bootstrap 5** and **jQuery AJAX** for a seamless, no-reload experience.

## 🛠 Tech Stack
- **Frontend**: HTML5, CSS3, Bootstrap 5, jQuery (AJAX)
- **Backend**: PHP 8.3
- **Primary Database**: MySQL (User credentials)
- **NoSQL Database**: MongoDB (Extended profile data)
- **Caching/Session**: Redis (Session tokens)

## 📋 Installation & Setup

### Prerequisites
- PHP 8.3+ with `mysqli`, `mongodb`, and `redis` extensions enabled.
- MySQL Server, MongoDB Server, and Redis (or Memurai) installed and running.

### Configuration
1. Clone the repository:
   ```bash
   git clone <your-repo-url>
   ```
2. Configure database credentials in `php/db.php`:
   ```php
   $user = 'root';
   $pass = ''; // Your MySQL password
   ```

### Running the App
1. Start your local MySQL, MongoDB, and Redis services.
2. Start the PHP built-in server in the project root:
   ```bash
   php -S localhost:8000
   ```
3. Access the app at `http://localhost:8000`.

## 🖥 Admin Dashboard
Access the data overview at `http://localhost:8000/admin.html`.
or using railway github deployment register -
https://internship-project-production-8080.up.railway.app/register.html 
login -
https://internship-project-production-8080.up.railway.app/login.html


---
*Created as part of an Internship Technical Task.*
