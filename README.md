## Requirements

- PHP 8.2
- Composer
- Vue
- Postgres

## Laravel Installation

Follow the steps in order to install the project:

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
    
9. Run server

    ```bash
    php artisan serve
    ```
10. The main page to access dashboard could be accessed through

    ```bash
    http://127.0.0.1:8000/user
    ```

## Vue + Vite Installation

Follow the steps in order to install the project:

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
| __Controllers__      | Used default controller provide by laravel, putting all crud operations in one file. tried to keep as clean as possible, splitting common methods in another file extending by inheritance.     |
| __Services__      | Added services modules to allow controller request actions from api but not allowing them access directly Repositories and Models. This keep code maintanable and easy to create tests as features are splitted among methods.     |
| __Repositories__      | Created repositories to being a layer between Models and Services, usually doing tasks such as queries and data filtering before sending them to database.     |
| __Models__ | Kept models clean as possible, avoiding put logic or business rules on them.|
| __Resources__ | Used resources to treat data before sending back to API request. This is useful to hide fields that are sensitive or to add more treated information back to requester. |
| __Request validation__ | Separated validation rules on specific files to allow usability in other parts if necessary, and keeping controller more clean. |

# Vue + Vite
| Feature  | Description |
| ------------- |:-------------:|
| __Components__ | Created parent components to hold a page or feature and child components with more complex data or rules. There are components created to support common usages such as Text Input or Select Input, allowing them be spreaded through code for flexibility. |
| __Requests__ | Used DOM fetch request to keep simplicity, but if necessary we can use axios as support to requests. |
| __Organization__ | Tried to put files inside folders representing domains, helping in code organization and indexing them in a manner of areas. |
| __Fields Persistance__ | Put field information on local storage to allow data being available between pages. |
| __User Form__ | Default user form with validation on all fields, enabling proceeding only when all criterias are met. |
| __User Form Preview__ | Form to allow user check all information before proceeding to save registry. You could check if all criteria met by backend through "Validate with Backend" button. |
