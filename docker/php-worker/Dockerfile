FROM php:7.4.10-alpine

RUN apk --update add wget \
    curl \
    git \
    build-base \
    libmemcached-dev \
    libmcrypt-dev \
    libxml2-dev \
    pcre-dev \
    zlib-dev \
    autoconf \
    cyrus-sasl-dev \
    libgsasl-dev \
    supervisor \
    oniguruma-dev \
    postgresql-dev && \
    docker-php-ext-install mbstring pdo pdo_mysql tokenizer xml pcntl bcmath pdo_pgsql pgsql && \
    pecl channel-update pecl.php.net && \
    pecl install mcrypt && \
    pecl install -o -f redis && \
    docker-php-ext-enable redis mcrypt && \
    rm /var/cache/apk/* && \
    rm -rf /tmp/pear && \
    mkdir -p /var/www

RUN addgroup -g 1000 society6 && \
    adduser -D -G society6 -u 1000 society6

COPY supervisord.conf /etc/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]

WORKDIR /etc/supervisor/conf.d/
