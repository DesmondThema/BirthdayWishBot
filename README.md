# About BirthdayBot

BirthdayBot is a basic system powered by [Laravel](https://laravel.com/) at the back engine, which sends birthday wishes to company XYZ employees

## Local Installation
1. Clone this repo  
`git clone git@github.com:DesmondThema/BirthdayWishBot.git`
2. cd into project  
`cd BirthdayBot`
3. Install composer  
`composer install`
4. Install NPM Dependencies  
`npm install`
5. Copy the .env.example file and rename it into the .env file  
`cp .env.example .env` 
6. Generate application key  
`php artisan key:generate`
7. Boot up the server
`php artisan serve`


## Important files.
1. The bot uses laravel commands to send birthday wishes
2. The command is in this file `SendBirthdayWishes.php`
3. Run the command to send birthday wishes
 `php artisan php artisan realm-digital:send-birthday-wishes`
4. If all the conditions pass, the email will be dispatched to mailtrap
5. If there are no birthdays or exclusions, the email won't be dispatched  
