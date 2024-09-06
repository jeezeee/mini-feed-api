# Mini Feed API

This is a simple API built with Laravel 11 that allows users to create, like, and delete posts.

## Features

-   Create and delete posts
-   Like and unlike posts (toggle functionality)
-   Email notification when a post is liked (viewable in **Mailpit**)
-   Fully tested with PHPUnit
-   Pagination support for post listings
-   Seeders for users and passport client

## Requirements

-   Docker (Laravel Sail is used)
-   PHP 8.3+
-   MySQL (as per `.env` configuration)

## Installation

Follow these steps to set up the project locally:

1. **Clone the repository**:

    ```bash
    git clone https://github.com/jeezeee/mini-feed-api
    cd mini-feed-api
    ```

2. **Set up environment variables: Copy the example environment file and adjust settings as needed.**:

    ```bash
    cp .env.example .env
    ```

3. **Install dependencies**: Install the necessary dependencies via Composer.

    ```bash
    composer install
    ```

4. **Set up the database**:

    - Make sure you have the correct database credentials in your `.env` file:

        ```bash
        DB_CONNECTION=mysql
        DB_HOST=mysql
        DB_PORT=3306
        DB_DATABASE=laravel
        DB_USERNAME=sail
        DB_PASSWORD=password
        ```

## Running the Application

1. **Start Laravel Sail**: (optional [-d] flag for detached mode )

    ```bash
    sail up [-d]
    ```

2. **Generate application key**: (Sail needs to be running for this step)

    **Note**: When using sail make sure you have a alias setup for the sail command, otherwise use you can use `./vendor/bin/sail`

    ```bash
    sail artisan key:generate
    ```

3. **Generate Passport keys**: (Sail needs to be running for this step)

    ```bash
    sail artisan passport:keys
    ```

4. **Run the migrations and seed the database**: (Sail needs to be running for this step)

    ```bash
    sail artisan migrate --seed
    ```

#### You can now use the application!

**Access the application**: The API will be available at `http://localhost`.
**Mailpit Setup**: Mailpit is used to capture outgoing emails. You can view the emails sent by the application at `http://localhost:8025`.

## Testing

To run the tests, you can use the following command:

```bash
sail artisan test
```

This will execute the full test suite, including unit and feature tests for authentication, posts, and likes.

### Testing Emails

Emails are sent when a post is liked. These emails can be viewed using **Mailpit** at `http://localhost:8025`. No real emails are sent, making it easier to verify email notifications during development.

## Seeders

The project includes seeders for generating test data:

1. **UsersSeeder**: Creates test users.
2. **PassportSeeder**: Creates passport personal client for Auth

You can run the seeders manually with:

```bash
sail artisan db:seed
```

## API Routes

| Method | URI                    | Action                         | Auth Required |
| ------ | ---------------------- | ------------------------------ | ------------- |
| POST   | /api/posts             | Create a new post              | Yes           |
| GET    | /api/posts             | Retrieve paginated posts       | No            |
| POST   | /api/posts/{post}/like | Like/unlike a post (toggle)    | Yes           |
| DELETE | /api/posts/{post}      | Delete a post                  | Yes           |
| GET    | /api/user              | Get authenticated user details | Yes           |
