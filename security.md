
---

## ✅ `SECURITY.md`

## Overview

This project implements multiple security measures to ensure a safe and controlled environment for both users and administrators.

---

## ✅ Authentication & Sessions

- Secure user login with `password_hash()` and `password_verify()`.
- PHP sessions are used to manage user state securely.
- Sessions are destroyed during logout to prevent reuse.

---

## ✅ Role-Based Access Control

| Role    | Access Level                                                                 |
|---------|------------------------------------------------------------------------------|
| Admin   | Full access to admin dashboard, user management, and all post controls      |
| Editor  | Access to admin dashboard and can manage (create/edit/delete) all posts     |
| User    | Cannot access admin dashboard; can only manage their own posts              |

- Role is stored in the `users.role` column.
- Access checks are enforced in PHP scripts before executing sensitive operations.

---

## ✅ Input Validation

### Server-side:
- All form inputs are validated before executing SQL queries.
- PDO prepared statements are used to prevent SQL injection.
- Username is limited to max **20 characters**, and must not contain special characters or digits.
- Password is limited to max **12 characters**, and must meet complexity rules.

### Client-side (JavaScript):
- Username and password fields are checked using regular expressions.
- Custom warning messages are displayed to guide users.

---

## ✅ Password Handling

- Passwords are hashed using `password_hash()` before storing.
- On login, `password_verify()` is used to compare input against the stored hash.

---

## ✅ Database Security

- Uses **PDO with prepared statements** (no raw SQL queries).
- Foreign key relationships are enforced (`posts.user_id → users.id`).
- Inputs are sanitized before database operations.

---

## 🚫 Known Limitations

- DB credentials are hard-coded (recommended: use `.env` or external config).
- No HTTPS (ensure production deployment uses secure transport).
- No CSRF tokens implemented (recommended for production).

---

## 🔄 Future Improvements

- Implement CSRF protection
- Use `.env` for configuration
- Enable HTTPS in production
- Log login attempts and failed actions for monitoring

---

## 🛡️ Summary

This CRUD app uses:
- Strong password handling
- Role-based access control
- Proper input validation (client & server)
- Secure DB operations with PDO

> These practices make the app safe for learning and small-scale deployments.

