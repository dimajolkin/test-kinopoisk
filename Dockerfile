FROM php:7.1

RUN apt-get update
RUN apt-get install -y --no-install-recommends \
    libpq-dev git zip &&\
    docker-php-ext-install pdo pdo_pgsql zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sL https://deb.nodesource.com/setup_4.x | bash - && \
apt-get install -yq nodejs build-essential

RUN pecl install redis && docker-php-ext-enable redis
RUN nodejs -v
#RUN npm install -g npm@3
RUN rm -rf /var/lib/apt/lists/*