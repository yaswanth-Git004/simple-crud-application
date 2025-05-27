
# Simple PHP CRUD Application

A simple blog-style CRUD (Create, Read, Update, Delete) web application built with **PHP**, **MySQL**, and **HTML/CSS**.




## Features

- ✅ User Registration & Login (Session-based)
- ✅ Create Posts
- ✅ Edit Posts
- ✅ Delete Posts
- ✅ View All Posts


## 🚀 Getting Started


## Tech Stack

**Client:** Html, CSS

**Server:** PHP 8.0.30, Xampp, MySQL


## 🗄️ Database Schema
**Database Name :- blog**

**Table :- users**
| Column     | Type          | Constraints                 | Description            |
|------------|---------------|-----------------------------|------------------------|
| id         | INT(10)       | PRIMARY KEY, AUTO_INCREMENT | Unique user ID         |
| username   | VARCHAR(30)   | UNIQUE, NOT NULL            | User's username        |
| password   | VARCHAR(255)  | NOT NULL                    | Hashed password        |

**Table :- posts**
| Column     | Type          | Constraints                 | Description            |
|------------|---------------|-----------------------------|------------------------|
| id         | INT(10)       | PRIMARY KEY, AUTO_INCREMENT | Unique post ID         |
| title      | VARCHAR(100)  | NOT NULL                    | Post title             |
| content    | VARCHAR(500)  | NOT NULL                    | Post content           |
| created_at | DATETIME      | DEFAULT CURRENT_TIMESTAMP   | Post creation time     |




## 📂 Folder Structure
```
CRUD_Application/
│
├── backend/
│   ├── dbConnection.php
│   ├── logout.php
│   └── blog.sql
│
├── styles/
│   └── style.css
│
├── createPost.php
├── edit.php
├── delete.php
├── index.php
├── login.php
├── register.php
├── nav.php
└── ...
```

## Installation


1. **Clone the repo**
   ```bash
   git clone https://github.com/Manishankar-Mandapati/simple-crud-application.git

2. **Download and Start your local server** (e.g., using XAMPP or WAMP)
In my case i'm using xampp here is the link for xampp
https://www.apachefriends.org/download.html

- Open XAMPP or WAMP

- Start Apache and MySQL
  

3. **Import the Database**

- Open http://localhost/phpmyadmin

- Create a database named blog

- Import the SQL file from:
    ```bash
    /backend/blog.sql
    ```
    
4. **Set Up the Database Connection**
```php
$dsn = 'mysql:host=localhost;dbname=blog';
$user = 'root'; // your MySQL username
$pass = '';
```

5. **Run the Application**
```
http://localhost/CRUD_Application/index.php
```
    
