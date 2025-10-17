What you need to run this:

- PHP
- MySQL
- Or just use xampp

Steps:

1. Clone the repo.
2. Create an .env file in the root directory.
3. Make sure you have mysql running, you can use xampp.
4. Open terminal inside the project folder.
5. In the terminal run `php database/migrate.php` to create the database and user table.
6. Still in terminal run `php -S localhost:8000 -t public` to run the php dev server.
7. Open browser and go to `localhost:8000`.
