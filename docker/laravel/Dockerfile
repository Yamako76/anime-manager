FROM php:8.0-fpm

ENV TZ Asia/Tokyo

RUN apt update && \
	apt install -y git unzip libzip-dev libicu-dev libonig-dev && \
	docker-php-ext-install intl pdo_mysql zip bcmath

COPY ./docker/laravel/php.ini /usr/local/etc/php/php.ini

COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

WORKDIR /app

RUN apt update && \
	apt install -y curl && \
	curl -sL https://deb.nodesource.com/setup_18.x | bash - && \
	apt install -y nodejs && \
	npm install typescript -g