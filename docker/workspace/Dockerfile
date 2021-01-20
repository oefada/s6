FROM phusion/baseimage:18.04-1.0.0

RUN locale-gen en_US.UTF-8

ENV LANGUAGE=en_US.UTF-8
ENV LC_ALL=en_US.UTF-8
ENV LC_CTYPE=en_US.UTF-8
ENV LANG=en_US.UTF-8
ENV TERM xterm

RUN DEBIAN_FRONTEND=noninteractive && \
    add-apt-repository -y ppa:ondrej/php && \
    apt-get update && \
    apt-get -o Dpkg::Options::=--force-confdef -o Dpkg::Options::=--force-confold upgrade -yq && \
    apt-get install -y --allow-downgrades --allow-remove-essential --allow-change-held-packages \
        apt-utils \
        curl \
        git \
        inetutils-ping \
        php7.4-cli \
        php7.4-common \
        php7.4-curl \
        php7.4-intl \
        php7.4-json \
        php7.4-xml \
        php7.4-mbstring \
        php7.4-mysql \
        php7.4-zip \
        php7.4-bcmath \
        php7.4-gd \
        php7.4-dev \
        php7.4-xdebug \
        php7.4-pgsql \
        php7.4-redis \
        php7.4-zip \
        php7.4-dev \
        pkg-config \
        postgresql-client \
        software-properties-common \
        libcurl4-openssl-dev \
        libedit-dev \
        libonig-dev \
        libssl-dev \
        libxml2-dev \
        libzip-dev \
        mysql-client \
        unzip \
        vim \
        mysql-client \
        postgresql-client \
        apt-utils \
        build-essential \
        zlib1g-dev \
        nasm \
        libpng-dev \
        rsync \
        zip \
        zsh && \
    apt-get clean && \
    sh -c "$(curl -fsSL https://raw.githubusercontent.com/robbyrussell/oh-my-zsh/master/tools/install.sh)" "" --unattended && \
    curl -s http://getcomposer.org/installer | php && \
    echo "export PATH=${PATH}:/var/www/vendor/bin" >> ~/.bashrc && \
    mv composer.phar /usr/local/bin/composer

COPY ./xdebug.ini /etc/php/7.4/cli/conf.d/xdebug.ini

RUN sed -i 's/^;//g' /etc/php/7.4/cli/conf.d/20-xdebug.ini

USER root

RUN set -xe; \
    groupadd -g 1000 society6 && \
    useradd -u 1000 -g society6 -m society6 -G docker_env && \
    usermod -p "*" society6 -s /bin/zsh

RUN echo "society6 ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers

USER society6

RUN sh -c "$(curl -fsSL https://raw.githubusercontent.com/robbyrussell/oh-my-zsh/master/tools/install.sh)" "" --unattended

USER root

COPY ./.zshrc /home/society6/.zshrc
COPY ./.zshrc /root/.zshrc
COPY ./wait-for-it.sh /usr/local/bin/wait-for-it.sh
RUN chmod +x /usr/local/bin/wait-for-it.sh

# Fixes bug with PEAR where notices are thrown if this tmp directory does not exist
RUN mkdir -p /tmp/pear/cache

WORKDIR /var/www
