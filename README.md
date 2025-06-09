## Requirements

- PHP 8.2
- Laravel 12
- Composer
- Vue
- Pinia 3
- Postgres

## Laravel Installation

Follow these steps in order to install the project:

1. Clone repository:

    ```bash
    git clone https://github.com/rcarreirao/vue-laravel-development
    ```
   
 2. Install dependencies
 
    ```bash
    composer install
    ```
    
3. Setup .env file according to your local settings

4. Generate app key

    ```bash
    php artisan key:generate
    ```
5. Configure .env file with Database access information before proceeding this step.
    
6. Run migrations

    ```bash
    php artisan migrate
    ```
7. Run database seed

    ```bash
    php artisan db:seed
    ```
    
8. Run command to clear route cache

    ```bash
    php artisan route:cache
    ```

9. Create default cache directories

    ```bash
    mkdir storage/framework storage/framework/cache storage/framework/sessions storage/framework/testing storage/framework/views
    ```
10. Run server

    ```bash
    php artisan serve
    ```
11. The main page to access dashboard could be accessed through

    ```bash
    http://127.0.0.1:8000/user
    ```

## Vue + Vite Installation

Follow these steps in order to install the project:

1. Run npm install

    ```bash
    npm install
    ```
2. Execute npm server to access vue application

    ```bash
    npm run dev
    ```

## Tests - Pest
1. There are tests for laravel crud operations and you can run with

    ```bash
    pest tests/Feature/User/UserCrudTest.php
    ```
2. Or a full test with
    
    ```bash
    pest
    ```

## Architecture Implementation

# Laravel
| Feature  | Description |
| ------------- |:-------------:|
| __Controllers__      | Used the default controller provided by Laravel, placing all CRUD operations in a single file. Tried to keep it as clean as possible by splitting common methods into another file through inheritance.     |
| __Services__      | Added service modules to allow controllers to request actions from the API without direct access to Repositories or Models. This keeps the code maintainable and makes it easier to write tests, as features are split across methods.     |
| __Repositories__      | Created repositories to serve as a layer between Models and Services, typically handling tasks like queries and data filtering before interacting with the database.    |
| __Models__ | Kept models as clean as possible, avoiding the inclusion of logic or business rules in them.|
| __Resources__ | Used resources to format data before sending it back to the API request. This is useful for hiding sensitive fields or adding processed information for the requester. |
| __Request validation__ | Separated validation rules into specific files to allow reuse in other parts of the application and to keep controllers cleaner. |
| __Tests__ | Tests were written using Pest for the entire feature, but they can easily be split into unit tests to better validate business rules. |

# Vue + Vite
| Feature  | Description |
| ------------- |:-------------:|
| __Components__ | Created parent components to represent pages or features, and child components for more complex data or logic. Also created reusable components like text inputs or select inputs to promote flexibility and consistency across the codebase.|
| __Requests__ | Used native DOM fetch requests for simplicity, with the option to use Axios if needed. |
| __Organization__ | Structured files inside domain-based folders to improve organization and make code easier to navigate. |
| __Fields Persistance__ | Stored field information in local storage to keep data available between page transitions. |
| __User Form__ | Implemented a default user form with validation for all fields, allowing progression only when all criteria are met. |
| __User Form Preview__ | Created a form that lets users review all information before saving a record. A "Validate with Backend" button allows confirmation that all criteria are met server-side. |
