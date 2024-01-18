# Install PHP
FROM alpine AS main_php

LABEL maintainer="Justin Katasi <justinkatasi.dev@gmail.com>"

# persistent / runtime deps
RUN apk add --no-cache \
  acl \
  fcgi \
  file \
  bash \
  git \
  linux-headers \
  npm \
  ;

#PHP and lib
RUN apk --no-cache --repository https://dl-cdn.alpinelinux.org/alpine/edge/main add \
  icu-libs \
  && apk --no-cache --repository https://dl-cdn.alpinelinux.org/alpine/edge/community add \
  libavif \
  && apk add --no-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/testing/ --allow-untrusted gnu-libiconv \
  tini \
  php81 \
  php81-dev \
  php81-common \
  php81-gd \
  php81-xmlreader \
  php81-bcmath \
  php81-ctype \
  php81-curl \
  php81-exif \
  php81-iconv \
  php81-intl \
  php81-mbstring \
  php81-opcache \
  php81-openssl \
  php81-pcntl \
  php81-phar \
  php81-session \
  php81-xml \
  php81-xsl \
  php81-zip \
  php81-zlib \
  php81-dom \
  php81-fpm \
  php81-sodium \
  php81-tokenizer \
  php81-pecl-apcu \
  && ln -sf /usr/bin/php81 /usr/bin/php

ADD rootfs /

RUN echo "PHP installed successfully"

ENTRYPOINT ["/sbin/tini", "--"]

CMD ["/usr/sbin/php-fpm81", "-R", "--nodaemonize"]

EXPOSE 9000

WORKDIR /app

# Install Composer
FROM main_php AS dev_composer

ARG USER=root
ARG PASSWORD=root

RUN apk add -U --no-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/testing/   \
  php81-pear \
  openssh \
  supervisor \
  autoconf \
  git \
  curl \
  wget \
  make \
  zip \
  php81-xdebug \
  && rm -rf /var/cache/apk/* \
  && sed -i s/#PermitRootLogin.*/PermitRootLogin\ yes/ /etc/ssh/sshd_config \
  && echo "${USER}:${PASSWORD}" | chpasswd \
  && ssh-keygen -A \
  && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

ADD devfs /

RUN echo "Composer installed successfully"

CMD ["supervisord", "--nodaemon", "--configuration", "/etc/supervisord.conf"]

EXPOSE 22 9003


# Install Symfony
FROM dev_composer AS symfony_installer

# Symfony project dir path
WORKDIR /symfony-todo

# Creat symfony project
RUN composer create-project symfony/skeleton .

# Install required bundles
RUN composer require symfony/debug-bundle --dev

# Installer symfony cli
RUN apk add --no-cache \
  bash \
  curl \
  && curl -sS https://get.symfony.com/cli/installer | bash \
  && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Install PDO and necessary dependencies
# RUN apk --no-cache add \
#   $PHPIZE_DEPS \
#   libxml2-dev \
#   && docker-php-ext-install pdo_mysql \
#   && docker-php-ext-install simplexml

RUN php bin/console cache:clear

# Expose the Symfony application port
EXPOSE 8000

# Run Symfony
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]