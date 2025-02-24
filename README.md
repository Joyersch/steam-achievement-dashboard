A Dashboard for tracking steam achievements


# Installation
For the installation copy the .env.example file to a new .env file.  
Fill in the `STEAM_APIKEY` variable with you steam api key.  
Update the `APP_URL`.  
Run the following commands:  
```
composer install
npm install
npm run build
php artisan migrate
```
Add a user using the following command:
```
php artisan app:create_user {steamUserId} {name} {color=#ffffff}
```
Pull data with the following command:
```
php artisan app:pull
```
 # Using Docker
Update the docker-compose.yml to your liking, afterwards run:
 ```
 docker compose build
 docker compose up -d
 ```