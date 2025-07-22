# Tenamart Waiting List API

A Laravel-based API that collects and manages user signups to a waiting list. It provides signup stats, trends, and a weekly report email.
used Sanctum for Auth and Eloquent queries combined with query builder to genereate stats API
---

## 📦 Features

- User signup (public)
- Authenticated management (CRUD)
- Signup source tracking
- Stats & insights API (also cotain daily and weekly)
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
### 4. Set Up Database and Update .env then

```bash
php artisan migrate
```
### 5. Install Laravel Sanctum
```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan tinker
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password'.  => bcrypt('password'),
]);
```
## Use these or Your own desired credentials to create admin user and generate token


## For users signup use this format
```bash
{
    "name": "Jane",
    "email": "jane@example.com",
    "signup_source": "organic"
}
```
## For admin login and get Token use this format
```bash
{
  "email": "admin@example.com",
  "password": "password"
}
```


### 6. Total API Requests


| Method | Endpoint                   | Auth Required | Description                             |
| ------ | -------------------------- | ------------- | --------------------------------------- |
| POST   | `/api/login`               | ❌ No          | Login as admin and receive a bearer token |
| POST   | `/api/waiting-list`        | ❌ No          | Add a new signup to the waiting list    |
| GET    | `/api/waiting-list`        | ✅ Yes         | Retrieve all signups (with pagination)  |
| PUT    | `/api/waiting-list/{id}`   | ✅ Yes         | Update a signup by ID                   |
| DELETE | `/api/waiting-list/{id}`   | ✅ Yes         | Delete a signup by ID                   |
| GET    | `/api/waiting-list/stats`  | ✅ Yes         | Show signup stats (daily/weekly trends) |
| GET    | `/api/waiting-list/export` | ✅ Yes         | Export signup stats as a CSV file       |
| GET    | `/preview-weekly-report`   | ✅ Yes         | Preview the weekly email report (HTML)  |

✅ Daily Stats (default)
```bash
GET /api/waiting-list/stats
GET /api/waiting-list/stats?view=daily
Returns number of signups per day for the last 30 days.
```

📅 Weekly Stats
```bash
GET /api/waiting-list/stats?view=weekly
```
Returns number of signups per week for the last 30 days.

### Dont forget to Include your Bearer token in the request header

### 7. Weekly Report CRON job

```bash
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```


### 🔌 Postman Collection

You can test the API using this Postman collection:

[📥 Download Tenamart API Postman Collection](./postman/tenamart-api.postman_collection.json)
