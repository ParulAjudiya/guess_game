Please follow below steps to setup project.
 
1. Clone GitHub repo using the below url.
git clone https://github.com/ParulAjudiya/guess_game.git
-> As result, guess_game named directory downloaded in your local.

2. cd guess_game

3. Install Composer Dependencies please run below command.
composer install

4. create empty database named "guess_game" in mysql. Set database credential in .env file which is you can find on root place.
This file have secure env variables which is different for each white-lable. but I commited here for your convience.

5. Migrate the database - Run below command - It will create table inside the database.
php artisan migrate

5. Use below url to see the project
http://localhost/guess_game/
