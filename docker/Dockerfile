FROM dwchiang/nginx-php-fpm:8.3.0-fpm-alpine3.17-nginx-1.24.0
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk update
RUN apk add npm busybox-openrc

COPY . /var/www/html
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY ./docker/install.sh /docker-entrypoint.d/install.sh
COPY ./docker/crontab /etc/crontabs/root

WORKDIR /var/www/html

RUN rm -rf /usr/share/nginx/html/*

COPY public /usr/share/nginx/html

RUN chown -R www-data:www-data /usr/share/nginx/html
RUN chown -R www-data:www-data /var/www/html