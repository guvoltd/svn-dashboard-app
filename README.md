# SVN Web Dashboard (PHP Full-Stack)

A secure PHP application for managing user and admin access to SVN repositories with advanced features like group access, path-level exclusions, and analytics.

---

## ✅ Features

- Secure login with bcrypt
- User/Admin dashboards
- Dynamic generation of `authz` and `passwd` files
- Repository assignment via user or group
- Exclude specific users from paths
- SVN interactions (create branch, version diff)
- Analytics and audit logs
- Bootstrap + Chart.js frontend

---

## 🛠 Requirements

- PHP 8.0+
- MySQL
- Apache/Nginx
- Subversion (SVN) installed
- SVN repositories located at `/var/svn/` or configured in `config.php`

---

## 🚀 Setup Instructions

1. Clone the repository:
    ```bash
    git clone https://github.com/YOUR_USERNAME/svn-dashboard-app.git
    cd svn-dashboard-app
    ```

2. Set up the database:
    - Create a MySQL database: `svn_dashboard`
    - Import schema:
      ```bash
      mysql -u root -p svn_dashboard < sql/schema.sql
      ```

3. Configure your environment:
    - Copy `config/config.example.php` to `config/config.php`
    - Set database credentials and SVN paths

4. Seed an admin account:
    ```bash
    php scripts/create_admin.php
    ```

5. Set appropriate folder permissions:
    - Ensure `data/`, `logs/`, and SVN paths are writable

6. Run locally:
    ```bash
    http://localhost/svn-dashboard-app/public/
    ```

---

## 🔐 Notes

- `authz` and `passwd` files are updated by the admin through the UI
- All operations are logged for auditing
- Passwords are stored securely using `password_hash()`

---

## 📂 Folder Structure


