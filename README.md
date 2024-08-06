# Laravel Task Management Application

This is a simple Laravel web application for task management. It allows users to create, edit, delete, and reorder tasks within projects.

## Features

- Create Task (with task name, priority, timestamps)
- Edit Task
- Delete Task
- Reorder tasks with drag-and-drop in the browser. Priority is automatically updated.
- Tasks are saved to a MySQL database.
- Project functionality: Users can select a project from a dropdown and only view tasks associated with that project.

## Requirements

- PHP 7.3 or higher
- Composer
- MySQL
- Node.js and npm (for frontend dependencies)

## Installation

Follow these steps to set up the project:

1. **Clone the repository:**

    ```bash
    git clone https://github.com/your-username/laravel-task-manager.git
    cd laravel-task-manager
    ```

2. **Install PHP dependencies:**

    ```bash
    composer install
    ```

3. **Install Node.js dependencies:**

    ```bash
    npm install
    ```

4. **Create a `.env` file:**

    Copy the example environment file and edit it to match your database configuration:

    ```bash
    cp .env.example .env
    ```

    Update the following lines in your `.env` file with your database credentials:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    ```

5. **Generate an application key:**

    ```bash
    php artisan key:generate
    ```

6. **Run database migrations:**

    ```bash
    php artisan migrate
    ```

7. **Serve the application:**

    ```bash
    php artisan serve
    ```

    The application will be accessible at `http://127.0.0.1:8000`.

## Deployment

To deploy the application, follow these steps:

1. **Set up a production server with a web server (e.g., Nginx or Apache), PHP, and MySQL.**

2. **Clone the repository to the server:**

    ```bash
    git clone https://github.com/your-username/laravel-task-manager.git
    cd laravel-task-manager
    ```

3. **Install dependencies:**

    ```bash
    composer install --optimize-autoloader --no-dev
    npm install
    npm run prod
    ```

4. **Set up the environment file:**

    ```bash
    cp .env.example .env
    ```

    Update the `.env` file with your production database credentials and other configurations.

5. **Generate the application key:**

    ```bash
    php artisan key:generate
    ```

6. **Run database migrations:**

    ```bash
    php artisan migrate --force
    ```

7. **Set the correct permissions for storage and cache directories:**

    ```bash
    chown -R www-data:www-data storage bootstrap/cache
    chmod -R 775 storage bootstrap/cache
    ```

8. **Set up a web server to serve the application:**

    - For Nginx, you might use a configuration similar to:

        ```nginx
        server {
            listen 80;
            server_name your_domain.com;
            root /path/to/laravel-task-manager/public;

            add_header X-Frame-Options "SAMEORIGIN";
            add_header X-XSS-Protection "1; mode=block";
            add_header X-Content-Type-Options "nosniff";

            index index.php;

            charset utf-8;

            location / {
                try_files $uri $uri/ /index.php?$query_string;
            }

            location = /favicon.ico { access_log off; log_not_found off; }
            location = /robots.txt  { access_log off; log_not_found off; }

            error_page 404 /index.php;

            location ~ \.php$ {
                fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
                fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
                include fastcgi_params;
            }

            location ~ /\.(?!well-known).* {
                deny all;
            }
        }
        ```

9. **Restart the web server:**

    ```bash
    sudo service nginx restart
    ```

Your Laravel Task Management application should now be deployed and accessible via your domain.

## License

This project is open-source and available under the [MIT License](LICENSE).
