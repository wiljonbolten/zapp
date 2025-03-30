FROM ubuntu:22.04 AS base

ENV DEBIAN_FRONTEND=noninteractive

# Install dependencies
RUN apt update
RUN apt install -y software-properties-common
RUN add-apt-repository -y ppa:ondrej/php
RUN apt update
RUN apt install -y php8.2\
    php8.2-cli\
    php8.2-common\
    php8.2-fpm\
    # php8.2-mysql\
    php8.2-zip\
    php8.2-gd\
    php8.2-mbstring\
    php8.2-curl\
    # php8.2-xml\
    # php8.2-bcmath\
    php8.2-pdo\
    php8.2-sqlite3

# RUN apt install -y php8.2\
#     php8.2-cli\
#     php8.2-common\
#     php8.2-fpm\
#     php8.2-mysql\
#     php8.2-zip\
#     php8.2-gd\
#     php8.2-mbstring\
#     php8.2-curl\
#     php8.2-xml\
#     php8.2-bcmath\
#     php8.2-pdo\
#     php8.2-sqlite3

# Install composer
RUN apt install -y curl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN echo "\
    #!/bin/sh\n\
    echo \"Starting services...\"\n\
    service php8.2-fpm start\n\
    echo \"Ready.\"\n\
    " > /start.sh

COPY . /zapp
WORKDIR /zapp

RUN composer install

CMD ["sh", "/start.sh"]
