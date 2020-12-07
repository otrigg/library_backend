# Library Backend API

Provides API endpoints for a sample library management system.

## Installation
1. Clone this repository.
2. ```cd``` into cloned repository.
3. Install dependencies
```
composer install
```
4. Copy environment file
```
cp .env.example .env
```
5. Create database file
```
touch database/database.sqlite
```
6. Run migrations
```
php artisan migrate
```
7. Install passport client
```
php artisan passport:install
```
8. Take note of the generated client ID and client secret
9. Seed database
```
php artisan db:seed
```
10. Serve app
```
php artisan serve
```

## Usage

Use Postman or cURL to use the API endpoints.

### Public endpoints
1. Get all books with a GET request:
```
http://localhost:8000/api/books
```
2. Get a specific book together with its author with a GET request:
```
http://localhost:8000/api/book/{id}
```
3. Get all authors with a GET request
```
http://localhost:8000/api/authors
```
4. Get a specific author together with her/his books with a GET request
```
http://localhost:8000/api/author/{id}
```

## Authentication
Before performing CUD operations you must authenticate to the app.

### Authentication with username/password
1. Make a POST request to:
```
http://localhost:8000/api/login
```
Attach the following BODY to the request:
```
{
    "username": "Admin",
    "password": "Admin"
}
```
2. Copy the ```token``` field within the response. **You should attach this token to all of the admin protected requests.**

### Authentication with Oauth
1. Make a POST request to:
```
http://localhost:8000/oauth/token
```
Attach the following BODY to the request:
```
{
    "username": "admin@example.com",
    "password": "Admin",
    "grant_type": "password",
    "scope": "",
    "client_id": "{the client ID copied when installed passport}",
    "client_secret": "{the client secret copied when installed passport}"
}
```
2. Copy the ```access_token``` field within the response. **You should attach this token to all of the admin protected requests.**

## Admin endpoints

### Add author
1. Make a POST request to:
```
http://localhost:8000/api/author
```
Request body:
```
{
    "name": string,
    "surname": string,
    "country": string
}
```
All fields are mandatory.

**Attach the copied token to the "Authorization" header in your request**

### Edit author
1. Make a PATCH request to:
```
http://localhost:8000/api/author/{author_id}
```
Request body:
```
{
    "name": string,
    "surname": string,
    "country": string
}
```
All fields are mandatory.

**Attach the copied token to the "Authorization" header in your request**

### Delete author
1. Make a DELETE request to:
```
http://localhost:8000/api/author/{author_id}
```

**Attach the copied token to the "Authorization" header in your request**

### Add book
1. Make a POST request to:
```
http://localhost:8000/api/book
```
Request body:
```
{
    "title": string,
    "year": numeric,
    "isbn": string,
    "author_id": numeric
}
```
All fields are mandatory.

**Attach the copied token to the "Authorization" header in your request**

### Edit book
1. Make a PATCH request to:
```
http://localhost:8000/api/book/{book_id}
```
Request body:
```
{
    "title": string,
    "year": numeric,
    "isbn": string,
    "author_id": numeric
}
```
All fields are mandatory.

**Attach the copied token to the "Authorization" header in your request**

### Delete book
1. Make a DELETE request to:
```
http://localhost:8000/api/book/{book_id}
```

**Attach the copied token to the "Authorization" header in your request**
