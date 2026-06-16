# GoGreen

GoGreen is a PHP/MySQL web application for sustainable waste management and reward tracking. It allows users to submit recyclable waste, schedule pickup, earn eco-points, and redeem rewards. Administrators can review submissions, approve or reject waste requests, and send notifications.

## 🌿 Project Overview

This project is designed to promote eco-friendly behavior by connecting users with a waste pickup and reward system. Users submit waste details, upload an image of the material, request pickup, and earn points after admin verification.

## 🚀 Core Features

- User registration and login
- Admin login and waste approval workflow
- Waste submission with image upload and pickup scheduling
- Eco-points calculation by waste type and weight
- Reward catalog for tree saplings, eco-friendly gifts, and vouchers
- User notification system
- User dashboard for tracking points and submissions
- Admin dashboard for managing waste requests

## 📁 Main Files

- `index.php` - Home page and landing content
- `login.php` - Role selection for user/admin login
- `signup.php` - Role selection for sign-up pages
- `user-login.php` - User login handling
- `user-signup.html` - User registration page
- `admin-login.php` - Admin login handling
- `dashBoard.php` - User dashboard view
- `SubmitWaste.php` - Waste submission form and upload logic
- `reward.php` - Rewards store page
- `notification.php` - User notification page
- `my-submissions.php` - View user waste submissions and status
- `admin-dashboard.php` - Admin waste review page
- `admin-assign.php` - Admin assignment and points awarding helper
- `config.php` - MySQL connection and schema helper
- `MySQL/gogreen.sql` - Database schema and seed data

## 🗂 Database Schema

The database schema includes the following tables:

- `admin` - Admin accounts
- `users` - Registered user accounts with point balances
- `waste_submissions` - Submitted waste requests and status tracking
- `notifications` - User notifications
- `reward_redemptions` - Records of redeemed rewards
- `contact` - Contact / message storage
- `posts` - Generic content/posts storage

## 🧩 Tech Stack

- PHP 8.x
- MySQL / MariaDB
- HTML, CSS, JavaScript
- Apache (XAMPP)

## ⚙️ Setup Instructions

1. Install XAMPP or a local PHP/MySQL server.
2. Place the project directory inside `htdocs` (for XAMPP) or your web server root.
3. Import `MySQL/gogreen.sql` into your MySQL server.
4. Update `config.php` if your database credentials are not `root` / no password.
5. Open the project in your browser, e.g. `http://localhost/Go-Green/`.

## ✅ Usage

1. Open `login.php` to choose user or admin login.
2. A new user should register using `user-signup.html`.
3. After login, access the dashboard, submit waste, and view points.
4. Admin users log in via `admin-login.php` to approve or reject submissions.
5. Approved submissions add eco-points to the user's account and generate notifications.

## ⚠️ Notes and Considerations

- Passwords are currently stored in plain text in the database. Use hashed passwords for production.
- Some sign-up flows are static HTML and may require backend wiring.
- The application uses session-based authentication and basic MySQL queries.
- Image uploads are stored in the `uploads/` folder.

## 💡 Recommended Improvements

- Add secure password hashing with `password_hash()` and `password_verify()`.
- Improve form validation and sanitization.
- Convert static sign-up pages into PHP-backed registration logic.
- Add a proper admin panel for managing users, rewards, and pickups.
- Implement CSRF protection and prepared statements consistently.

---

NGROK Link: https://decode-cadillac-dimly.ngrok-free.dev/Go-Green/

Thank you for exploring GoGreen! This repository is a starting point for building a greener waste collection and rewards experience.
