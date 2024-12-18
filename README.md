# Laravel Blog API Backend

## Environments

-   **Testing Environment**: `env.testing`
-   **Development Environment**: `env`
-   **Development Database**: `blog_project`

-   **Please Make sure that MySQL is running.**

-   It's not a good practice to push env files in git for security reasons, but I have pushed to so it
    will be easy to test the API.

## Commands

> Laravel Framework version 10.48.25

-   **Install Composer Dependencies**:

    ```bash
    composer install
    ```

-   **Migrate the Database**:

    ```sh
    php artisan migrate
    ```

-   **To Seed the Development Database**:

    ```sh
    php artisan db:seed
    ```

-   **To Run the Feature Test**:

    ```sh
    php artisan test
    ```

-   **To start the Development Server**:

    ```sh
    php artisan serve
    ```

## User Login Credentials

-   **Admin User Login**:

    > **Email**: mainaliashish@outlook.com  
    > **Password**: password123

-   **Normal User Login**:

    > **Email**: ram@gmail.com  
    > **Password**: password123

## ER Diagram for simple_blog database

![ER Diagram for Simple Blog App](er-diagram.png)
