FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
      cron \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      zip unzip \
      git && \
      docker-php-ext-install pdo_mysql && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install gd && \
      docker-php-ext-install zip

RUN pecl install redis \
&& rm -rf /tmp/pear \
&& docker-php-ext-enable redis

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

COPY ../app/cron/crontab /tmp/crontab
RUN crontab /tmp/crontab
COPY ../docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

#CMD crond && php-fpm
CMD cron && docker-php-entrypoint php-fpm

WORKDIR /var/www