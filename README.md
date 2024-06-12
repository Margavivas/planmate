<img width="100%" alt="planmate" src="https://github.com/Margavivas/planmate/assets/108183207/82ccbf83-d3e5-4131-ae38-75244c3b9de1">

# Planmate

![Vue.js](https://img.shields.io/badge/Vue.js-green)
![Javascript](https://img.shields.io/badge/Javascript-blue)
![HTML5](https://img.shields.io/badge/HTML5-orange)
![CSS3](https://img.shields.io/badge/CSS3-blue)
![Laravel](https://img.shields.io/badge/Laravel-red)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-blue)
![Figma](https://img.shields.io/badge/Figma-purple)

## Description

Planmate is an application designed to help users organize and plan their daily tasks efficiently. It offers an intuitive interface and various features that facilitate time and task management.

## Features

- **Task Management**: Easily create, edit, and delete tasks.
- **Reminders**: Set reminders so you don't forget any important tasks.
- **Categories**: Organize your tasks into different categories for better clarity.
- **Intuitive Interface**: Enjoy a user-friendly and visually appealing interface.

## Installation

### Frontend

1. **Clone the repository**:
    ```bash
    git clone https://github.com/yourusername/planmate.git
    ```

2. **Navigate to the project directory**:
    ```bash
    cd planmate/frontend
    ```

3. **Install dependencies**:
    ```bash
    npm install
    ```

4. **Run the application**:
    ```bash
    npm run serve
    ```

### Backend

1. **Navigate to the backend directory**:
    ```bash
    cd ../backend
    ```

2. **Install dependencies**:
    ```bash
    composer install
    ```

3. **Configure environment variables**:
    Create a `.env` file in the `backend` directory with the following variables:
    ```
    APP_NAME=Planmate
    APP_ENV=local
    APP_KEY=base64:your_app_key
    APP_DEBUG=true
    APP_URL=http://localhost

    LOG_CHANNEL=stack

    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=planmate
    DB_USERNAME=your_db_username
    DB_PASSWORD=your_db_password

    BROADCAST_DRIVER=log
    CACHE_DRIVER=file
    QUEUE_CONNECTION=sync
    SESSION_DRIVER=file
    SESSION_LIFETIME=120

    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379

    MAIL_MAILER=smtp
    MAIL_HOST=smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS=null
    MAIL_FROM_NAME="${APP_NAME}"

    AWS_ACCESS_KEY_ID=
    AWS_SECRET_ACCESS_KEY=
    AWS_DEFAULT_REGION=us-east-1
    AWS_BUCKET=

    PUSHER_APP_ID=
    PUSHER_APP_KEY=
    PUSHER_APP_SECRET=
    PUSHER_APP_CLUSTER=mt1

    MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
    MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
    ```

4. **Generate the application key**:
    ```bash
    php artisan key:generate
    ```

5. **Run migrations**:
    ```bash
    php artisan migrate
    ```

6. **Start the server**:
    ```bash
    php artisan serve
    ```


## Technologies Used

### Frontend

- **Vue.js**: The main framework for building the user interface.
- **Javascript**: Used to add static typing to the project.

### Backend

- **Laravel**: PHP framework for building the backend.
- **PostgreSQL**: Relational database used for data storage.


## Contact

For more information or inquiries, you can contact me at:

- **Instagram**: [@margasprojects](https://www.instagram.com/margasprojects/)
