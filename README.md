# TemperaturesCrudApiMeteo
This is a mini application laravel CRUD app, that consumes data from api "meteo", and collect API data every 15 minutes.

## How to install and run on your local system
### Clone project
git clone https://github.com/mehdifox/TemperaturesCrudApiMeteo.git
### Install the necessary dependencies
cd TemperaturesCrudApiMeteo/
<br> composer install 
### Create file .env and generate a new Application Key in Laravel
cp .env.example .env
<br> php artisan key:generate
### Add your database
Add your database config in the .env file (ex: DB_DATABASE=temperatures)
### Cache all of your configuration files
php artisan config:cache
### Collect API data every 15 minutes
php artisan schedule:run 
<br> config your Task Scheduler : https://www.windowscentral.com/how-create-automated-task-using-task-scheduler-windows-10
### Open app in browser
php artisan serve
