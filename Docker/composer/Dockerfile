# Use Alpine Linux as the base image
FROM alpine AS main_php

# Set metadata for the image
LABEL maintainer="Justin Katasi <justinkatasi.dev@gmail.com>"

# Set the working directory
WORKDIR /app

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

# Delete directory if it exists
RUN rm -rf /var/www/html

# Symfony project dir path
WORKDIR /var/www/html
