FROM alpine:latest

# Set metadata for the image
LABEL maintainer="Lucie GODARD <lucie.godard1704@gmail.com>"

# Set environment variables
ENV PHP_VERSION=81
ENV ADMINER_VERSION=4.8.1
ENV ADMINER_DOWNLOAD_URL=https://www.adminer.org/static/download/$%7BADMINER_VERSION%7D/adminer-$%7BADMINER_VERSION%7D.php

# Install PHP and necessary extensions for Adminer
RUN apk add --no-cache \
  php${PHP_VERSION} \
  php${PHP_VERSION}-session \
  php${PHP_VERSION}-mysqli \
  php${PHP_VERSION}-pgsql \
  php${PHP_VERSION}-pdo_pgsql \
  php${PHP_VERSION}-json \
  php${PHP_VERSION}-openssl \
  php${PHP_VERSION}-curl \
  php${PHP_VERSION}-dom \
  php${PHP_VERSION}-pdo_mysql \
  php${PHP_VERSION}-simplexml \
  php${PHP_VERSION}-tokenizer \
  php${PHP_VERSION}-xmlwriter \
  php${PHP_VERSION}-xml \
  php${PHP_VERSION}-phar \
  php${PHP_VERSION}-zip \
  curl

RUN ln -sf /usr/bin/php81 /usr/bin/php

# Download Adminer
RUN mkdir -p /var/www/html \
  && curl -L ${ADMINER_DOWNLOAD_URL} -o /var/www/html/adminer.php

# Make a symbolic link for PHP
RUN ln -sf /usr/bin/php${PHP_VERSION} /usr/bin/php

# Expose port
EXPOSE 8080

# Command to run Adminer
CMD ["php", "-S", "0.0.0.0:8080", "/var/www/html/adminer.php"]
