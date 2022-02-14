Please follow below steps to setup project.
 
1. Clone GitHub repo using the below url.
git clone https://github.com/ParulAjudiya/guess_game.git
-> As result, guess_game named directory downloaded in your local.

2. cd into your project
cd projectName
-> for example: cd guess_game


3. Install Composer Dependencies please run below command.
composer install

4. Create a copy of your .env file
.env files are not committed to source control for security reasons. But there is a .env.example which is a template of the .env file that the project have. So we will make a copy of the .env.example file and create a .env file from it.
cp .env.example .env

OR

.env file is attached with email. Please find it from there.

5. Create an empty database for our application
	After created empty database, please configure db connection in .env file as below detail.
	DB_CONNECTION=mysql
	DB_HOST=localhost
	DB_PORT=3306
	DB_DATABASE=guess_game
	DB_USERNAME=root
	DB_PASSWORD=

6. Migrate the database - run below command - It will create table inside the database.
php artisan migrate


7. To start laravel server 
php artisan serve
