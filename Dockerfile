FROM php:7.4-cli

COPY . /app
WORKDIR /app

RUN apt-get update && apt-get install -y \
    composer \
    file \
    php7.2-bcmath \
    php7.2-curl \
    php7.2-dom \
    php7.2-gettext \
    php7.2-json \
    php7.2-mbstring \
    php7.2-phar \
    php7.2-simplexml \
    php7.2-soap \
    php7.2-xml \
    php7.2-xmlreader \
    php7.2-xmlwriter \
    php7.2-zip

RUN composer update

CMD ["php"]
