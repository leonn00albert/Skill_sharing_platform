# Skill_sharing_platform


## Getting Started

1. Clone the repository:

   ```bash
   git clone https://github.com/your-username/myapp.git

    Navigate to the project directory:

    ```


Install dependencies using Composer:

```

composer install
```
Migrate database tables using Symfony Doctrine:

```
php bin/console doctrine:migrations:migrate
```
This command will apply any pending migrations and set up the database tables.

Start the application:

```
    composer start

    Visit http://localhost:8000 in your browser.

```
## Admin Panel

Access the admin panel at /admin from your application's URL. For example, if running locally, visit http://localhost:8000/admin.

Use the provided credentials to log in and manage the administrative functionalities.
## Running Codeception Tests

MyApp uses Codeception for testing. To run tests, execute:

bash

vendor/bin/codecept run
