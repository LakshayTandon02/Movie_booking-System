🎬 Movie Booking System

A full-stack web application built with HTML, CSS, JavaScript (AJAX) for the frontend and PHP + MySQL for the backend.
It allows users to browse movies, view details, book tickets, and see their booking history.

📌 Features<img width="1920" height="1080" alt="Screenshot (104)" src="https://github.com/user-attachments/assets/66de7de1-3eaa-4e44-9301-6fa8062ea711" />
<img width="1920" height="1080" alt="Screenshot (105)" src="https://github.com/user-attachments/assets/4c506aae-8641-4512-9c38-0214f3a0c93a" />
<img width="1920" height="1080" alt="Screenshot (106)" src="https://github.com/user-attachments/assets/bd00ed31-d2cc-41a8-8a35-57a48698b974" />


✅ User Authentication

Sign up and log in with email verification.

Secure password storage using hashing.

✅ Movie Listing

Movies dynamically fetched and displayed with posters, details, and ratings.

Supports multiple theaters, timings, and locations.

✅ Booking System

Users can select showtime, seats, and confirm booking.

Calculates total ticket price.

Stores booking data securely in the database.

✅ Booking History

Users can view all past bookings in a clean table.

Uses AJAX for dynamic refresh without reloading the page.

Shows details like name, movie, theater, seats, amount, and date.

✅ Admin Ready (extendable)

Movies can be managed from the database (add/update/delete).

Future scope: admin panel for better management.

🛠️ Tech Stack

Frontend

HTML5, CSS3, JavaScript (AJAX, Fetch API)

Responsive layout (works on desktop & mobile)

Backend

PHP (procedural + MySQLi)

REST-style API endpoints (e.g., get_bookings.php)

Database

MySQL

Tables:

users (id, name, email, phone, password)

movies (id, title, poster, genre, rating)

bookings (id, user_id, movie_id, seats, amount, booking_date, theater_name, theater_location, showtime)

