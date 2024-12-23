# Bookstore API

Welcome to the **Bookstore API**, a RESTful service built with Symfony and API Platform. This API provides functionalities for managing authors, books, and reviews.

## Features

- **Authors**
  - Create, read, update, and delete authors.
  - View a list of all authors.
- **Books**
  - Manage books and associate them with authors.
  - Retrieve details about specific books.
- **Reviews**
  - Add, view, and delete reviews for books.

## Installation

### Prerequisites

- PHP >= 8.1
- Composer
- Symfony CLI (optional, for local development)
- A database server (e.g., MySQL, PostgreSQL)

### Steps

1. Clone the repository:
   ```bash
   git clone https://github.com/0meeee0/Leadz-Coding-Challenge.git
   ```
2. Navigate to the project directory:
   ```bash
   cd Leadz-Coding-Challenge
   ```
3. Install dependencies:
   ```bash
   composer install
   ```
4. Configure your `.env` file with database credentials:
   ```env
   DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"
   ```
5. Run database migrations:
   ```bash
   php bin/console doctrine:migrations:migrate
   ```
6. Start the server:
   ```bash
   symfony server:start
   ```

## Usage

### Endpoints

#### Authors

- `GET /api/authors`  
  Retrieve a list of all authors.

- `POST /api/authors`  
  Create a new author.

- `GET /api/authors/{id}`  
  Retrieve details of a specific author.

- `DELETE /api/authors/{id}`  
  Delete an author.

#### Books

- `GET /api/books`  
  Retrieve a list of all books.

- `POST /api/books`  
  Add a new book.

- `GET /api/books/{id}`  
  Retrieve details of a specific book.

- `DELETE /api/books/{id}`  
  Delete a book.

#### Reviews

- `GET /api/reviews`  
  Retrieve a list of all reviews.

- `POST /api/reviews`  
  Add a review for a book.

- `GET /api/reviews/{id}`  
  Retrieve details of a specific review.

- `DELETE /api/reviews/{id}`  
  Delete a review.

## Testing

Run tests with PHPUnit:
```bash
vendor/bin/phpunit --testdox
```

Ensure that the application behaves as expected by using the test suite.

## Documentation

API documentation is auto-generated and available at:
```
http://localhost:8000/api/docs
```

This includes a Swagger UI for testing the endpoints interactively.

## Special Thanks

I would like to thank Mr. Redouane Bouabana from Leadz for this opportunity to learn and grow more

