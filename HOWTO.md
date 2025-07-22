# Tenamart Waiting List API

A Laravel-based API that collects and manages user signups to a waiting list. It provides signup stats, trends, and a weekly report email.

---

## 📦 Features

- User signup (public)
- Authenticated management (CRUD)
- Signup source tracking
- Stats & insights API
- Export stats as CSV
- Weekly email report (Mailtrap)

---

## 🚀 Getting Started

### 1. Clone the Project

```bash
git clone https://github.com/Nebiyou-x/tenamart-api.git
cd tenamart-api
```

### 2. Install Dependencies
```bash
composer install
```

### 3.  Copy .env and Set Up App Key
```bash
cp .env.example .env
php artisan key:generate
```
### 4. Set Up Database and Update .env

```bash
php artisan migrate
```
