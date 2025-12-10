# CS331-Group-28
This project is a web-based airline reservation system built for NJIT CS331.  
It includes:
- **User Management** (register/login/profile)
- **User Features** (search flights + book/cancel tickets)
- **Admin Management** (view all users + view all reservations/tickets)

> Note: Passwords are stored as plain text for class/demo simplicity.

---

## Tech Stack
- PHP (XAMPP)
- Apache (XAMPP)
- MySQL (XAMPP / phpMyAdmin)
- CSS

---

## Setup Instructions (Local)

### Prerequisites
- XAMPP installed
- Apache + MySQL running in XAMPP Control Panel

### Step-by-step
1. Start **Apache** and **MySQL** in XAMPP.
2. Open phpMyAdmin:
   - http://localhost/phpmyadmin
3. Create a database named:
   - `airline_db`
4. Import the database schema/data:
   - In phpMyAdmin → airline_db → **Import**
   - Select `schema.sql` and click **Go**
5. Place the project in:
   - `C:\xampp\htdocs\airline_project`
6. Open the app:
   - http://localhost/airline_project/

---

## Default Admin Account
- **Username:** admin
- **Password:** admin123

---

## Application Pages

### User Pages
- `register.php` — user registration
- `login.php` — login
- `user_home.php` — user dashboard
- `profile.php` — user profile display
- `search_flights.php` — flight search
- `book_flight.php` — booking/reservation creation
- `my_tickets.php` — view user reservations
- `cancel_ticket.php` — cancel reservation

### Admin Pages
- `admin_dashboard.php` — admin dashboard
- `admin_users.php` — list of registered users
- `admin_reservations.php` — list of all reservations/tickets

### Utility
- `logout.php` — logout
- `connection.php` — database connection
- `auth_user.php` — protects user pages
- `auth_admin.php` — protects admin pages

---

## Troubleshooting
- If you see “Not Found”, confirm the file exists inside:
  `C:\xampp\htdocs\airline_project\`
- If MySQL connection fails, confirm MySQL is running in XAMPP and that `connection.php`
  points to database `airline_db`.
