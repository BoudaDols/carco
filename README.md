# CarCo API Documentation

## Overview

CarCo is a Laravel-based REST API for car dealership management. It provides comprehensive functionality for managing cars, brands, categories, clients, and user authentication with built-in security features and logging system.

### Features
- 🔐 User authentication with Laravel Sanctum
- 🚗 Complete car inventory management
- 🏷️ Brand and category management
- 👥 Client management system
- 📊 Comprehensive logging system
- 🛡️ Security fixes (XSS, SQL Injection protection)
- ✅ 37 comprehensive tests

## Quick Start

### Installation
```bash
# Clone the repository
git clone https://github.com/BoudaDols/carco.git
cd carco

# Install dependencies
composer install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed

# Start the server
php artisan serve
```

### Base URL
```
http://localhost:8000/api
```

## Authentication

All endpoints except registration and login require authentication using Bearer tokens.

### Headers
```
Authorization: Bearer {your-token}
Content-Type: application/json
Accept: application/json
```

### Register User
**POST** `/auth/register`

```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "active": true
}
```

**Response (201)**
```json
{
    "message": "Utilisateur créé avec succès."
}
```

### Login
**POST** `/auth/login`

```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response (200)**
```json
{
    "access_token": "1|abc123...",
    "token_type": "Bearer"
}
```

### Get User Profile
**GET** `/auth/me`

**Response (200)**
```json
{
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "active": true
}
```

### Logout
**POST** `/auth/logout`

**Response (200)**
```json
{
    "message": "Déconnexion réussie."
}
```

## Cars Management

### Create Car
**POST** `/auth/car/create`

```json
{
    "name": "Toyota Camry",
    "year": 2023,
    "color": "Blue",
    "price": 25000.00,
    "chassisNumber": "1HGBH41JXMN109186",
    "description": "Excellent condition sedan",
    "categorie_id": 1,
    "brand_id": 1
}
```

**Response (201)**
```json
{
    "message": "Car added successfully"
}
```

### Get All Cars
**GET** `/auth/cars`

**Response (200)**
```json
[
    {
        "id": 1,
        "name": "Toyota Camry",
        "year": 2023,
        "color": "Blue",
        "price": 25000.00,
        "chassisNumber": "1HGBH41JXMN109186",
        "description": "Excellent condition sedan",
        "category": "Sedan",
        "brand": "Toyota"
    }
]
```

### Get Car by ID
**GET** `/auth/car/{id}`

**Response (200)**
```json
{
    "id": 1,
    "name": "Toyota Camry",
    "year": 2023,
    "color": "Blue",
    "price": 25000.00,
    "chassisNumber": "1HGBH41JXMN109186",
    "description": "Excellent condition sedan",
    "category": "Sedan",
    "brand": "Toyota"
}
```

### Update Car
**PUT** `/auth/car/{id}`

```json
{
    "id": 1,
    "name": "Toyota Camry Updated",
    "year": 2023,
    "color": "Red",
    "price": 26000.00,
    "chassisNumber": "1HGBH41JXMN109186",
    "description": "Updated description",
    "categorie_id": 1,
    "brand_id": 1
}
```

**Response (200)**
```json
{
    "message": "Car updated successfully"
}
```

### Delete Car
**DELETE** `/auth/car/{id}`

**Response (200)**
```json
{
    "message": "Car deleted successfully"
}
```

### Search Cars by Name
**GET** `/auth/cars/search?name=toyota`

**Response (200)**
```json
[
    {
        "id": 1,
        "name": "Toyota Camry",
        "category": "Sedan",
        "brand": "Toyota"
    }
]
```

## Brands Management

### Create Brand
**POST** `/auth/brand/create`

```json
{
    "name": "Toyota",
    "origin": "Japan"
}
```

**Response (201)**
```json
{
    "id": 1,
    "name": "Toyota",
    "origin": "Japan"
}
```

### Get All Brands
**GET** `/auth/brands`

**Response (200)**
```json
[
    {
        "id": 1,
        "name": "Toyota",
        "origin": "Japan"
    }
]
```

### Update Brand
**PUT** `/auth/brand/{id}`

```json
{
    "name": "Toyota Motors",
    "origin": "Japan"
}
```

### Delete Brand
**DELETE** `/auth/brand/{id}`

### Get Cars by Brand
**GET** `/auth/brands/cars?name=Toyota`

## Categories Management

### Create Category
**POST** `/auth/categorie/create`

```json
{
    "name": "Sedan"
}
```

### Get All Categories
**GET** `/auth/categories`

### Get Category by ID
**GET** `/auth/categorie/{id}`

### Update Category
**PUT** `/auth/categorie/{id}`

### Delete Category
**DELETE** `/auth/categorie/{id}`

### Get Cars by Category
**GET** `/auth/categories/cars?name=Sedan`

## Client Management

### Create Client
**POST** `/auth/client/create`

```json
{
    "name": "Jane Smith",
    "dateNaissance": "1990-05-15",
    "sexe": "F",
    "domaineP": "Engineering"
}
```

### Get All Clients
**GET** `/auth/clients`

### Get Client by Name
**GET** `/auth/client/search?name=Jane`

### Update Client
**PUT** `/auth/client/update`

### Delete Client
**DELETE** `/auth/client/delete`

## Logging System

### View Logs
**GET** `/logs?type={log_type}&lines={number}`

**Parameters:**
- `type`: `auth`, `cars`, `api`, `laravel` (default: `laravel`)
- `lines`: Number of lines to display (default: `50`)

**Example:**
```
GET /logs?type=auth&lines=100
```

**Response (200)**
```json
{
    "log_type": "auth",
    "lines": [
        "[2024-01-15 10:30:00] local.INFO: User registered {\"user_id\":1,\"email\":\"john@example.com\"}",
        "[2024-01-15 10:35:00] local.INFO: User logged in {\"user_id\":1,\"email\":\"john@example.com\"}"
    ]
}
```

### Log Channels
- **`auth`**: Authentication events (login, logout, registration)
- **`cars`**: Car operations (CRUD operations)
- **`api`**: General API operations (brands, categories, clients)
- **`laravel`**: Default Laravel logs

## Data Models

### User
```json
{
    "id": "integer",
    "name": "string (max: 255)",
    "email": "string (unique)",
    "password": "string (hashed)",
    "active": "boolean"
}
```

### Car
```json
{
    "id": "integer",
    "name": "string (max: 255)",
    "year": "integer (1900-current year)",
    "color": "string (max: 255)",
    "price": "decimal",
    "chassisNumber": "string (unique, max: 32)",
    "description": "string (max: 255)",
    "categorie_id": "integer (foreign key)",
    "brand_id": "integer (foreign key)"
}
```

### Brand
```json
{
    "id": "integer",
    "name": "string (unique, max: 255)",
    "origin": "string (max: 255)"
}
```

### Category
```json
{
    "id": "integer",
    "name": "string (unique, max: 255)"
}
```

### Client
```json
{
    "id": "integer",
    "name": "string (max: 255)",
    "dateNaissance": "string (max: 10)",
    "sexe": "string (max: 1)",
    "domaineP": "string (max: 25)"
}
```

## Error Handling

### Validation Errors (422)
```json
{
    "errors": {
        "field_name": [
            "Error message"
        ]
    }
}
```

### Authentication Errors (401)
```json
{
    "message": "Unauthenticated."
}
```

### Not Found Errors (404)
```json
{
    "message": "Resource not found"
}
```

### Server Errors (500)
```json
{
    "error": "Internal server error message"
}
```

## Security Features

### Implemented Security Measures
- **XSS Protection**: All user inputs are properly escaped and validated
- **SQL Injection Prevention**: Using Eloquent ORM and parameterized queries
- **Input Validation**: Comprehensive validation rules for all endpoints
- **Authentication**: Laravel Sanctum token-based authentication
- **CSRF Protection**: Built-in Laravel CSRF protection
- **Rate Limiting**: API rate limiting (configurable)

### Security Headers
```
X-Content-Type-Options: nosniff
X-Frame-Options: DENY
X-XSS-Protection: 1; mode=block
```

## Testing

### Run Tests
```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Run with coverage
php artisan test --coverage
```

### Test Coverage
- **37 tests** with **71 assertions**
- **Unit Tests**: Model relationships and validations
- **Feature Tests**: API endpoints and authentication
- **Test Categories**:
  - Authentication (6 tests)
  - Car Management (7 tests)
  - Brand Management (6 tests)
  - Category Management (7 tests)
  - API General (2 tests)
  - Unit Tests (9 tests)

## Development

### Environment Variables
```env
APP_NAME=CarCo
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=carco
DB_USERNAME=root
DB_PASSWORD=

LOG_CHANNEL=stack
LOG_LEVEL=debug
```

### Database Migrations
```bash
# Create migration
php artisan make:migration create_table_name

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback
```

### Logging Configuration
Log files are stored in `storage/logs/` with daily rotation:
- `auth-YYYY-MM-DD.log`
- `cars-YYYY-MM-DD.log`
- `api-YYYY-MM-DD.log`
- `laravel-YYYY-MM-DD.log`

## API Rate Limiting

Default rate limits:
- **Authentication endpoints**: 60 requests per minute
- **General API endpoints**: 60 requests per minute
- **Authenticated endpoints**: 100 requests per minute

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Ensure all tests pass
6. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support and questions:
- Create an issue on GitHub
- Check the test files for usage examples
- Review the Laravel documentation for framework-specific questions

---

**Version**: 1.0.0  
**Last Updated**: January 2024  
**Laravel Version**: 10.x