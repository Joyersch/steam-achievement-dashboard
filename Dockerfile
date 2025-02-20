FROM dwchiang/nginx-php-fpm:latest

RUN composer install --prefer-dist --no-scripts -o --optimize-autoloader

FROM dwchiang/nginx-php-fpm:latest
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get update
RUN apt-get -y install npm 

COPY . /var/www/html
WORKDIR /var/www/html
RUN rm -rf /usr/share/nginx/html/*
COPY public /usr/share/nginx/html

RUN chown -R www-data:www-data /usr/share/nginx/html
RUN chown -R www-data:www-data /var/www/html

RUN composer install
RUN npm install
RUN npm run build
RUN php artisan migrate
RUN php artisan route:cache
