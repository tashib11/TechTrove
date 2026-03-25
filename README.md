# 🚀 TechTrove - Premium eCommerce Platform

> **A full-featured, production-ready eCommerce solution** designed for scalability, performance, and exceptional user experience.

TechTrove is a modern, sophisticated eCommerce platform that empowers businesses to sell tech products, electronics, and more with advanced features like real-time inventory management, secure payment processing, and a comprehensive admin dashboard.

---

## ✨ Key Highlights

🔥 **High Performance**: Optimized FCP (First Contentful Paint) delivers blazing-fast load times  
💳 **Secure Payments**: SSLCommerz integration for safe, encrypted transactions  
📱 **Mobile-First**: Fully responsive design optimized for all devices  
👤 **User Management**: Complete authentication, profiles, and order history  
📊 **Analytics Dashboard**: Real-time statistics and business insights  
🎯 **Admin Suite**: Powerful management tools for products, categories, brands, and policies

---

## 📸 Platform Showcase

### Home & Browsing

The homepage delivers an engaging shopping experience with dynamic hero sliders, featured products, and curated categories.

#### Hero Section

![Home Page - Hero Section](demo/demohome1.png)

#### Featured Products

![Home Page - Featured Products](demo/home2.png)

#### Categories Overview

![Categories & Brands](demo/home3.png)

#### Top Categories Grid

![Top Categories Grid](demo/home4.png)

#### Exclusive Products

![Exclusive Products Showcase](demo/home5.png)

#### Footer & Trust Signals

![Footer & Trust Signals](demo/home6.png)

### Product Experience

Rich product details with high-resolution images, reviews, ratings, and intelligent recommendations.

#### Product Details - Overview

![Product Details Page 1](demo/detail1.png)

#### Product Details - Specifications

![Product Details Page 2](demo/detail2.png)

#### Product Review and Rating Section

![Product Image Gallery](demo/detail3.png)

#### 4 sections of Products

![Product Recommendations](demo/home_product.png)

### Shopping Features

Seamless shopping cart, wishlists, and checkout experience with cash on hand payment option.

#### Shopping Cart

![Shopping Cart](demo/cart.png)

#### Wishlist Management

![Wishlist Management](demo/wish.png)

### User Accounts

Personalized profiles, order tracking, and purchase history.

#### User Profile

![User Profile](demo/profile.png)

#### Order History

![Order Tracking](demo/order1.png)

#### Order Tracking

![Order History](demo/order2.png)

### Secure Checkout

Multi-step checkout with OTP verification.

#### Payment Page

![Payment Gateway Integration](demo/payment1.png)

#### Payment Processing

![Payment Processing](demo/payment2.png)

#### Payment Confirmation

![Payment Verification](demo/payment3.png)

#### OTP Verification

![OTP Verification](demo/verify.png)

### Admin Dashboard

Comprehensive management interface for complete business control.

#### Dashboard Overview

![Dashboard Overview 1](demo/dashboard1.png)

#### Dashboard Analytics

![Dashboard Analytics 2](demo/dashboard2.png)

#### Business Statistics

![Business Statistics](demo/statistic.png)

#### Detailed Performance Metrics

![Detailed Statistics](demo/statistic2.png)

### Product Management

Powerful tools to manage inventory, pricing, and product details at scale.

#### Add Product - Basic Info

![Add Products](demo/add_Pro1.png)

#### Add Product - Details

![Add Product Details](demo/add_Pro2.png)

#### Product List View

![Product List View](demo/admin-prodList.png)

#### Edit Product Form

![Edit Product Details](demo/admin_details1.png)

#### Update Product Information

![Update Product Information](demo/admin_details2.png)

#### Manage Product Variations

![Manage Product Variations](demo/admin_upd_details.png)

### Catalog Management

Organize products with custom categories and brands.

#### Category Management - List

![Category Management 1](demo/Admin_category1.png)

#### Category Management - Form

![Category Management 2](demo/Admin_cat2.png)

#### Brand Management - List

![Brand Management 1](demo/admin_brand.png)

#### Brand Management - Edit

![Brand Management 2](demo/admin_brand2.png)

### Advanced Features

Hero slider management, user administration, and content policies.

#### Hero Slider Management - List

![Hero Slider Management 1](demo/admin_slider.png)

#### Hero Slider Management - Edit

![Hero Slider Management 2](demo/admin_slider2.png)

#### Invoice Management

![Invoice Management](demo/admin_invoice.png)

#### User Administration

![User Administration](demo/admin_users.png)

#### Policy Management

![Policy Management](demo/admin_policy.png)

### Authentication

Secure login system with JWT tokens and session management.

#### Login Page

![Login Page](demo/login.png)

---

## 🛠️ Tech Stack

**Backend:**

- **Framework**: Laravel 11 (PHP 8.1+)
- **Database**: MySQL
- **API**: RESTful with JWT Authentication
- **Email**: OTP-based verification system

**Frontend:**

- **Framework**: Bootstrap 5.3
- **Build Tool**: Vite
- **Real-time**: JavaScript with Fetch API & IndexedDB
- **Lazy Loading**: Intersection Observer API
- **Icons**: Bootstrap Icons

**Additional Features:**

- IndexedDB for offline caching
- Middleware-based authentication
- CORS support
- Responsive image optimization
- Accessibility (WCAG 2.1)

---

## 🚀 Getting Started

### Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js 16+ & NPM
- MySQL 5.7+ or MariaDB 10.3+

### Installation

1. **Clone the repository**

2. **Install PHP dependencies**

    ```bash
    composer install
    ```

3. **Install Node dependencies**

    ```bash
    npm install
    ```

4. **Setup environment file**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Configure database**

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=techtove
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6. **Run migrations**

    ```bash
    php artisan migrate
    php artisan db:seed
    ```

7. **Build frontend assets**

    ```bash
    npm run build
    ```

8. **Start the application**
    ```bash
    php artisan serve
    ```

Visit `http://localhost:8000` in your browser.

---

## 📊 Performance Metrics

| Metric                         | Score  | Status        |
| ------------------------------ | ------ | ------------- |
| First Contentful Paint (FCP)   | < 1.2s | ✅ Optimized  |
| Largest Contentful Paint (LCP) | < 2.5s | ✅ Target     |
| Cumulative Layout Shift (CLS)  | 0      | ✅ Stable     |
| Time to Interactive (TTI)      | < 3.5s | ✅ Fast       |
| Mobile Friendly                | 100%   | ✅ Responsive |

---

## 🎯 Core Features

### For Customers

✅ Easy product discovery with search & filters  
✅ Detailed product pages with reviews & ratings  
✅ Wishlist & cart management  
✅ Secure multi-step checkout  
✅ OTP-based verification  
✅ Order tracking & history  
✅ User profile management  
✅ Invoice generation

### For Administrators

✅ Complete product management (CRUD)  
✅ Inventory tracking  
✅ Category & brand management  
✅ Hero slider customization  
✅ User management  
✅ Invoice & order tracking  
✅ Sales analytics dashboard  
✅ Policy management  
✅ Real-time statistics

---

## 🔐 Security Features

- **JWT Authentication**: Secure token-based authentication
- **Password Hashing**: Bcrypt hashing for password storage
- **CSRF Protection**: Laravel's built-in CSRF middleware
- **SQL Injection Prevention**: Parameterized queries & ORM
- **XSS Protection**: Blade template escaping
- **Secure Headers**: Security-focused HTTP headers

---

## 📦 Project Structure

```
TechTrove/
├── app/
│   ├── Http/Controllers/       # Request handlers
│   ├── Models/                 # Database models
│   ├── Helpers/                # Utility functions
│   └── Mail/                   # Email classes
├── resources/
│   ├── views/                  # Blade templates
│   ├── css/                    # Stylesheets
│   └── js/                     # JavaScript files
├── routes/
│   ├── api.php                 # API routes
│   ├── web.php                 # Web routes
├── database/
│   ├── migrations/             # Database migrations
│   └── seeders/                # Data seeders
├── public/
│   └── assets/                 # Images, CSS, JS
└── config/                     # Configuration files
```

---

## 🤝 Perfect For

**E-Commerce Businesses:**

- Electronics & tech retailers
- Gadget stores
- Tech accessory shops
- Online marketplaces

**Development Teams:**

- Freelancers & agencies
- Startups building B2C platforms
- Enterprises needing custom solutions
- Teams requiring scalable codebases

**Learning & Development:**

- PHP/Laravel learning projects
- Full-stack web development courses
- Portfolio building
- Internship projects

---

## 🚀 Deployment Ready

TechTrove is production-ready and can be deployed to:

- **Shared Hosting** with cPanel/Plesk
- **VPS/Dedicated Servers** (Ubuntu, CentOS, etc.)
- **Cloud Platforms**: AWS, DigitalOcean, Heroku, Vercel
- **Docker Containers**: Docker & Docker Compose support

---

## 📞 Support & Hire

**Looking to hire skilled developers** experienced with this platform?

✉️ **Email**: contact@techtove.local  
🌐 **Website**: www.techtove.local  
💼 **LinkedIn**: [Your LinkedIn Profile]  
📱 **Phone**: +1-XXX-XXX-XXXX

**Services Available:**

- Custom feature development
- Performance optimization
- Security audits
- E-commerce consulting
- Team augmentation
- Full product management

---

## 📄 License

This project is licensed under the MIT License - see the license file for details.

---

## 👨‍💻 Author

**Md Tashibul Islam**

- Portfolio: [ \[Portfolio URL\]](https://tashib11.github.io/portfolio-website/)
- GitHub: tashib11
- Email: tashibul.is@gmail.com

---

<div align="center">

### Built with ❤️ for modern e-commerce experiences

</div>
