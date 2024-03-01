# Install symfony from custom_composer image
FROM justinkat/custom-composer:latest  AS symfony

# Set environment variables
ENV PHP_VERSION=81

# Delete directory if it exists
RUN rm -rf /var/www/html

# Symfony project dir path
WORKDIR /var/www/html

# Installer php extension pour symfony
RUN apk add --no-cache \
  php${PHP_VERSION}-posix \
  php${PHP_VERSION}-pdo \
  bash \
  php-ctype \
  curl \
  postgresql-dev \
  libxml2-dev \
  php${PHP_VERSION}-pdo_pgsql \
  php${PHP_VERSION}-simplexml \
  && curl -sS https://get.symfony.com/cli/installer | bash \
  && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "/var/www/html/public"]