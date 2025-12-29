# 📁 Simple E-Commerce Shopping Cart — Project Overview

Simple e-commerce shopping cart aplication with Low Stock notification to Admin and with scheduled daily sales report notification.

---

## 👤 Contact Information

| Detail | Value |
|--------|--------|
| **Name** | Aleksandar Veljković |
| **Email** | aleksandar.veljkovic@gmail.com |

---

## 📝 2. Project Overview
 
This project is a simple e-commerce shopping cart application built with Laravel and one of Laravel’s official starter kits (Vue.js). It demonstrates core e-commerce functionality while following Laravel best practices and clean architecture principles.

---

## ⚙️ 3. Features

- Browse a list of products
- View single product details
- Add products to a shopping cart
- Update product quantities in the cart
- Remove items from the cart
- Shopping cart is persisted per authenticated user (database-driven, no sessions or local storage)
- Checkout flow that creates orders from the cart
- Low Stock notification job dispacthed when product stock is bellow treshhold
- Scheduled command for generating daily sales report and send it to the Admin

---

## 🛠️ Technical Stack

- **PHP** 8.2
- **Backend:** Laravel 12 with Sail  
- **Frontend:** Vue.js 3, TailwindCSS  
- **SPA Handling:** Inertia.js  
- **Database:** MySQL (via Sail) 

---

## 📦 Installation & Setup

Follow these steps to set up the project locally:

### 1. **Clone the repository:**
   ```bash
   git clone <repository_url>
   cd <project_folder>
   ```

### 2. **Build docker containers**
   ```bash
   docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/opt" \
    -w /opt \
    laravelsail/php[XX]-composer:latest \
    composer install --ignore-platform-reqs
   ```
   - IMPORTANT: change XX with PHP local version

### 3. Start Laravel Sail
- `./vendor/bin/sail up -d`

### 4. Install dependencies
```bash
./vendor/bin/sail composer install
```

### 5. Install NPM packages
```bash
./vendor/bin/sail npm install
```

### 6. Generate App key
```bash
./vendor/bin/sail php artisan key:generate
```

### 7. Run migrations
```bash
./vendor/bin/sail php artisan migrate
```

### 8. Run seeder
```bash
./vendor/bin/sail php artisan db:seed
```
Seeder will seed the DB with:
- 1 user
- 30 products

### 9. Build assets
```bash
./vendor/bin/sail npm run build
```

### 10. Set ENVs
- Make sure to set `MAIL_MAILER=log`

### 11. Start queue worker
```bash
./vendor/bin/sail artisan queue:work
```

### 12. Run the scheduled command:
```bash
./vendor/bin/sail artisan schedule:test
```
or use command directly

```bash
./vendor/bin/sail artisan report:daily-sales
```

### 13. Have fun

---

## 🧪 Tests 

Currently, there are no tests implemented. Tests should be added at a later stage.
