# Use Alpine Linux as the base image
FROM alpine AS main_php

# Set metadata for the image
LABEL maintainer="Justin Katasi <justinkatasi.dev@gmail.com>"

# Install persistent/runtime dependencies
RUN apk add --no-cache \
  acl \
  fcgi \
  file \
  bash \
  git \
  linux-headers \
  npm \
  ;
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
  php81-soap \
  ;

RUN ln -sf /usr/bin/php81 /usr/bin/php

ADD rootfs /

RUN echo "PHP installed successfully"

ENTRYPOINT ["/sbin/tini", "--"]

CMD ["/usr/sbin/php-fpm81", "-R", "--nodaemonize"]

# Set the working directory
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

# Install Symfony
FROM dev_composer AS symfony_installer

# Symfony project dir path
WORKDIR /symfony-todo

# Creat symfony project
RUN composer create-project symfony/skeleton .

# Install required bundles
RUN composer require symfony/debug-bundle --dev
RUN composer require symfony/maker-bundle --dev
RUN composer require symfony/orm-pack
RUN composer require symfony/twig-bundle
RUN composer require symfony/security-bundle
RUN composer require symfony/webpack-encore-bundle --dev
RUN composer require orm-fixtures --dev

# Installer php extension pour symfony
RUN apk add --no-cache \
  postgresql-dev \
  libxml2-dev \
  php81-pdo_pgsql \
  php81-simplexml \
  php81-posix \
  php81-pdo \
  bash \
  curl \
  && curl -sS https://get.symfony.com/cli/installer | bash \
  && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Expose the Symfony application port
EXPOSE 8000

# Run Symfony
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]