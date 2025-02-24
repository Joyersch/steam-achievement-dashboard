composer install
npm install
npm run build
php artisan migrate
php artisan route:cache
chown www-data:www-data database/database.sqlite
chmod 775 database/database.sqlite
crond &