# Sanctum REST API

A Laravel-based REST API with authentication using Laravel Sanctum for token-based authentication.

## Features

- User Registration
- User Login with Token Generation
- User Profile Retrieval
- User Logout
- Token-based Authentication
- Request Validation
- Error Logging

## Installation

1. Clone the repository
```bash
git clone git@github.com:riadaman/sanctrum_rest_api.git
cd sanctrum-rest-api
```

2. Install dependencies
```bash
composer install
```

3. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database in `.env` file
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sanctrum_api
DB_USERNAME=root
DB_PASSWORD=
```

5. Run migrations
```bash
php artisan migrate
```

6. Start the server
```bash
php artisan serve
```

## API Endpoints

### Base URL
```
http://localhost:8000/api
```

### Authentication Endpoints

#### 1. Register User
**POST** `/register`

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "phone_number": "1234567890"
}
```

**Success Response (201):**
```json
{
    "status": "success",
    "message": "User registered successfully",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "phone_number": "1234567890",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

#### 2. Login User
**POST** `/login`

**Request Body:**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "User logged in successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "phone_number": "1234567890"
        },
        "token": "1|abc123def456ghi789..."
    }
}
```

#### 3. Get User Profile
**GET** `/user`

**Headers:**
```
Authorization: Bearer {token}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "User profile retrieved successfully",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "phone_number": "1234567890"
    }
}
```

#### 4. Logout User
**GET** `/logout`

**Headers:**
```
Authorization: Bearer {token}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "User logged out successfully"
}
```

## Test Cases

### Using cURL

#### 1. Register User Test
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "phone_number": "1234567890"
  }'
```

#### 2. Login User Test
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123"
  }'
```

#### 3. Get User Profile Test
```bash
curl -X GET http://localhost:8000/api/user \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

#### 4. Logout User Test
```bash
curl -X GET http://localhost:8000/api/logout \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Using Postman

1. **Register User**
   - Method: POST
   - URL: `http://localhost:8000/api/register`
   - Body: Raw JSON with user data

2. **Login User**
   - Method: POST
   - URL: `http://localhost:8000/api/login`
   - Body: Raw JSON with email and password

3. **Get User Profile**
   - Method: GET
   - URL: `http://localhost:8000/api/user`
   - Headers: Authorization: Bearer {token}

4. **Logout User**
   - Method: GET
   - URL: `http://localhost:8000/api/logout`
   - Headers: Authorization: Bearer {token}

## Error Responses

### Validation Errors (422)
```json
{
    "status": "error",
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The email field is required."]
    }
}
```

### Authentication Errors (401)
```json
{
    "status": "error",
    "message": "Invalid credentials"
}
```

### Server Errors (500)
```json
{
    "status": "error",
    "message": "User registration failed"
}
```

## Logging

The application logs important events and errors to help with debugging and monitoring.

### Log Locations
- **Laravel Logs**: `storage/logs/laravel.log`
- **Error Logs**: Captured in Laravel's default logging system

### Logged Events

#### Registration Errors
```
[2024-01-01 12:00:00] local.ERROR: User registration failed: Database connection error-Line: 25
```

#### Login Errors
```
[2024-01-01 12:00:00] local.ERROR: User login failed: Invalid credentials provided-Line: 45
```

### Log Levels
- **ERROR**: Critical errors that prevent functionality
- **INFO**: General information about application flow
- **DEBUG**: Detailed information for debugging

### Viewing Logs
```bash
# View latest logs
tail -f storage/logs/laravel.log

# View specific error logs
grep "ERROR" storage/logs/laravel.log
```

## Security Features

- Password hashing using Laravel's Hash facade
- Token-based authentication with Laravel Sanctum
- Request validation for all endpoints
- CSRF protection for web routes


## Database Schema

### Users Table
```sql
- id (bigint, primary key)
- name (varchar)
- email (varchar, unique)
- phone_number (varchar)
- password (varchar, hashed)
- email_verified_at (timestamp, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

### Personal Access Tokens Table
```sql
- id (bigint, primary key)
- tokenable_type (varchar)
- tokenable_id (bigint)
- name (varchar)
- token (varchar, hashed)
- abilities (text, nullable)
- last_used_at (timestamp, nullable)
- expires_at (timestamp, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

## Configuration

### Sanctum Configuration
The API uses Laravel Sanctum for authentication. Key configuration files:
- `config/sanctum.php` - Sanctum settings
- `config/auth.php` - Authentication guards including Sanctum guard

### Environment Variables
```env
SANCTUM_STATEFUL_DOMAINS=localhost,127.0.0.1
SANCTUM_TOKEN_PREFIX=
```

## Troubleshooting

### Common Issues

1. **Token not working**
   - Ensure Sanctum guard is configured in `config/auth.php`
   - Check if migrations are run
   - Verify token is passed in Authorization header

2. **CORS Issues**
   - Configure CORS in `config/cors.php`
   - Add frontend domain to stateful domains

3. **Database Connection**
   - Verify database credentials in `.env`
   - Ensure database exists
   - Run migrations

