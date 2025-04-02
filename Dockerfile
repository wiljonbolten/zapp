FROM ubuntu:22.04

LABEL maintainer="Wiljon Bolten"
LABEL site="https://github.com/wiljonbolten/zapp"

ENV LANG="C.UTF-8"
ENV DEBIAN_FRONTEND=noninteractive
ENV CONTAINER_ROLE=${CONTAINER_ROLE:-ALL}

ENV TZ=UTC
ENV USER_ID=1000
ENV USER_GROUP_ID=1000

WORKDIR /var/www/app

RUN apt update \
    # Add PHP 8.2 repository
    && apt install -y software-properties-common \
    && add-apt-repository ppa:ondrej/php \
    # PHP extensions
    && apt install -y \
    php8.2-bcmath\
    php8.2-cli\
    php8.2-common\
    php8.2-curl\
    php8.2-fpm\
    php8.2-gd\
    php8.2-mbstring\
    php8.2-pdo\
    php8.2-sqlite3\
    php8.2-xml\
    php8.2-zip\
    # Extra
    curl \
    git \
    htop \
    nano \
    # nginx \ # KEEP FOR FUTURE USE
    supervisor \
    unzip \
    zsh

# Composer
RUN curl -sS https://getcomposer.org/installer  | php -- --install-dir=/usr/bin --filename=composer

# Node, NPM, Yarn
# RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - && apt install -y nodejs && npm -g install yarn --unsafe-perm

# Create user/group with id/uid (1000/100)
RUN groupadd -g ${USER_GROUP_ID} appuser
RUN useradd -u ${USER_ID} -m -d /home/appuser -g appuser appuser

# Config files
COPY --chown=appuser:appuser . /var/www/app
COPY --chown=appuser:appuser docker/start.sh /usr/local/bin/start
COPY --chown=appuser:appuser docker/config/etc /etc
COPY --chown=appuser:appuser docker/config/etc/php/8.2/cli/conf.d/y-php.ini /etc/php/8.2/fpm/conf.d/y-php.ini

# Permissions for start script
RUN chmod a+x /usr/local/bin/start

# Required for php-fpm and nginx as non-root user
RUN mkdir -p /run/php
RUN chown -R appuser:appuser /var/www/app /var/log /var/lib /run
RUN chmod -R 777 /var/log /var/lib /run

# Switch to non-root user
USER appuser

# Laravel Installer
# RUN composer global require laravel/installer && composer clear-cache

# OhMyZsh (better than "bash")
RUN sh -c "$(curl -fsSL https://raw.github.com/ohmyzsh/ohmyzsh/master/tools/install.sh)"

# Add composer to PATH
RUN echo 'export PATH="$PATH:$HOME/.config/composer/vendor/bin"' >> ~/.zshrc

# Nginx (8080), Node (3000/3001), Laravel Dusk (9515/9773)
# EXPOSE 8080 8000 3000 3001 9515 9773 # KEEP FOR FUTURE USE

RUN composer install
# Start services through "supervisor" based on "CONTAINER_ROLE". See "start.sh".
CMD /usr/local/bin/start
