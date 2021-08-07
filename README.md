# ToDo App API's

This is a simple ToDo App RESTful APIs with media support.

This application is build on Laravel Framework 8.12.

## Installation

Clone the repository-
```
git clone https://github.com/shahzadtahir123/todo-list.git
```

Then cd into the folder with this command-
```
cd todo-list
```

Then do a composer install
```
composer install
```

Then create a environment file using this command-
```
cp .env.example .env
```

Then edit `.env` file with appropriate credential for your database server. Just edit these two parameter(`DB_USERNAME`, `DB_PASSWORD`).

Then create a database named `todo_list_db` and then do a database migration using this command-
```
php artisan migrate
```

Generate application key, which will be used for password hashing, session and cookie encryption etc.
```
php artisan key:generate
```

In the end, create laravel storage link with public folder in order to get attached media
```
php artisan storage:link
```

## Run server

Run server using this command-
```
php artisan serve
```

Then go to `http://localhost:8000` from your browser and see the app.

## API Documentation URL

https://documenter.getpostman.com/view/3858581/TzskDhoM
