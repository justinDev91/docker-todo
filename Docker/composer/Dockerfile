# Use Alpine Linux as the base image
FROM alpine:latest AS php

# Set metadata for the image
LABEL maintainer="Justin Katasi <justinkatasi.dev@gmail.com>"

# Set environment variables
ARG USER=root
ARG PASSWORD=root
ENV PHP_VERSION=81

# Set the working directory
WORKDIR /app

# Install system dependencies
RUN apk add --no-cache \
  acl \
  fcgi \
  file \
  bash \
  git \
  linux-headers \
  npm \
  ;

# Install additional dependencies from different repositories
RUN apk --no-cache --repository https://dl-cdn.alpinelinux.org/alpine/edge/main add \
  icu-libs \
  && apk --no-cache --repository https://dl-cdn.alpinelinux.org/alpine/edge/community add \
  libavif \
  && apk add --no-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/testing/ --allow-untrusted gnu-libiconv \
  tini \
  php${PHP_VERSION} \
  php${PHP_VERSION}-common \
  php${PHP_VERSION}-iconv \
  php${PHP_VERSION}-mbstring \
  php${PHP_VERSION}-openssl \
  php${PHP_VERSION}-phar \
  php${PHP_VERSION}-pecl-apcu \
  php${PHP_VERSION}-tokenizer \
  php${PHP_VERSION}-dom \
  php${PHP_VERSION}-gd \
  php${PHP_VERSION}-xmlreader \
  php${PHP_VERSION}-bcmath \
  php${PHP_VERSION}-ctype \
  php${PHP_VERSION}-curl \
  php${PHP_VERSION}-exif \
  php${PHP_VERSION}-intl \
  php${PHP_VERSION}-opcache \
  php${PHP_VERSION}-pcntl \
  php${PHP_VERSION}-session \
  php${PHP_VERSION}-xml \
  php${PHP_VERSION}-xsl \
  php${PHP_VERSION}-zip \
  php${PHP_VERSION}-zlib \
  php${PHP_VERSION}-sodium \
  ;

# Installer Composer depuis php
FROM php AS composer

# Install necessary packages for Composer setup
RUN apk add -U --no-cache php${PHP_VERSION}-pear \
  php${PHP_VERSION}-pear \
  openssh \
  supervisor \
  autoconf \
  curl \
  make \
  zip \
  php${PHP_VERSION}-xdebug \
  && rm -rf /var/cache/apk/* \
  # Permit root login via SSH and set the default password
  && sed -i s/#PermitRootLogin.*/PermitRootLogin\ yes/ /etc/ssh/sshd_config \
  && echo "${USER}:${PASSWORD}" | chpasswd \
  # Generate SSH keys
  && ssh-keygen -A \
  && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Make a symbolic link for PHP 8.1
RUN ln -sf /usr/bin/php${PHP_VERSION} /usr/bin/php