
# Blog Platform API with User Management and Roles

This is a RESTful API for a Blog Platform built with **Laravel 11**, providing user authentication, role management ( Author), and CRUD functionality for blog posts. The API includes features such as post creation, listing, updating, deleting, commenting, filtering, and caching.

## Features

- **User Authentication** with JWT
- **Role-Based Access Control** ( Author role)
- **CRUD Operations** for blog posts
- **Pagination** and **Filtering** for listing posts
- **Commenting System**
- **Caching** for faster post retrieval
- **API Documentation** via Postman

---

## Requirements

- PHP 8.3+
- Composer
- Laravel 11.x
- MySQL or any SQL-based database
- Node.js (for Swagger UI and frontend integration)

---

## Setup Instructions

### 1. Clone the Repository

Clone this project to your local machine:

```bash
git clone https://github.com/ramo772/devotrack-task.git

cd blog-api
```
Install Dependencies
Install the required dependencies using Composer:

```bash
composer install
```
Configure Environment Variables
Copy the .env.example file to .env:

```bash

cp .env.example .env
```

Update your .env file with the correct database credentials and JWT settings:
```bash

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog_db
DB_USERNAME=root
DB_PASSWORD=

```
Generate JWT Secret

Run the following command to generate the JWT secret:

```bash
php artisan jwt:secret
```

Run Migrations

Migrate the database to create the necessary tables:

```bash
php artisan migrate
```
API Endpoints

Authentication

POST /api/register: Register a new user

POST /api/login: Login and get a JWT token

Blog Post Endpoints

GET /api/posts: List all blog posts with pagination and filtering by category, author, and date range

POST /api/posts: Create a new post (authenticated users with appropriate roles)

GET /api/posts/{id}: View a single post with author details

PUT /api/posts/{id}: Update a post (only the post's author or admin)

DELETE /api/posts/{id}: Delete a post (only the post's author or admin)

Comment Endpoints

POST /api/posts/{id}/comments: Add a comment to a post (authenticated users)

Caching

The list of blog posts is cached to improve performance. The cache is refreshed every 10 minutes.

Cache Key: A unique cache key is generated based on the query parameters (category, author, date range).

Running the Application

Serve the application:
```bash
php artisan serve
```

The application will be available at http://localhost:8000.

Role-Based Access Control

The project uses one role:

Author: Can only create, update, or delete their own posts.
Authentication with JWT
To authenticate and gain access to protected routes, you need to include the Authorization header with a Bearer token:

Authorization: Bearer {JWT_TOKEN}
Technologies Used
Laravel 11.x
JWT Authentication (tymon/jwt-auth)
MySQL database

