FROM php:7.4-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    build-essential \
    zip \
    vim \
    curl

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY . /app

CMD ["php-fpm"]
