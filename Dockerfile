FROM php:8.5-apache


RUN apt-get update \
	&& apt-get install -y libpq-dev unzip \
	&& docker-php-ext-install pdo_pgsql \
	&& rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . /var/www/html/

WORKDIR /var/www/html

EXPOSE 80

