# Installation:

1. Clone the project from git repository

`git clone ...`
   
2. Install dependencies

`composer install`

3. Copy ".env.example" to ".env" file

`cp .env.example .env`

5. Add api url `API_VEHICLE_URL` in ".env" file

`https://random-data-api.com/api/vehicle/random_vehicle?size=100&is_xml=true`

5. Create a database named `DB_DATABASE` in ".env" file

`create database mogo_api`

6. Run database migrations

`php artisan migrate`

7. Run console command to parse api

`php artisan vh:parse`