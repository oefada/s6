FROM php:7.4.10-fpm

ENV DEBIAN_FRONTEND noninteractive

RUN set -xe; \
    apt-get update -yqq && \
    apt-get upgrade -y && \
    apt-get install -y gnupg2 && \
    apt-get install -y --no-install-recommends \
      curl \
      libmemcached-dev \
      libz-dev \
      libpq-dev \
      libjpeg-dev \
      libpng-dev \
      libfreetype6-dev \
      libssl-dev \
      libmcrypt-dev \
      apt-utils \
      build-essential \
      zlib1g-dev \
      libzip-dev zip unzip && \
    pecl channel-update pecl.php.net && \
    pecl install -o -f redis && \
    docker-php-ext-enable redis && \
    docker-php-ext-install zip pdo_mysql pcntl opcache bcmath pdo_pgsql && \
    rm -rf /tmp/pear && \
    rm -rf /var/lib/apt/lists/*

###########################################################################
# xDebug:
###########################################################################

ARG INSTALL_XDEBUG=false

RUN if [ ${INSTALL_XDEBUG} = true ]; then \
  pecl install xdebug && \
  docker-php-ext-enable xdebug && \
  echo "xdebug.remote_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
  echo "xdebug.remote_autostart=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
  echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
;fi

###########################################################################

COPY ./opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY ./laravel.ini /usr/local/etc/php/conf.d
COPY ./xlaravel.pool.conf /usr/local/etc/php-fpm.d/

USER root

RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog

RUN groupmod -o -g 1000 www-data && \
    usermod -o -u 1000 -g www-data www-data

ADD app-root.tar.gz /var/www

WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000
