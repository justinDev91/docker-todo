# Install Composer
FROM justinkat/custom-composer:v1  AS dev_symfony

# Delete directory if it exists
RUN rm -rf /var/www/html

# Symfony project dir path
WORKDIR /var/www/html

# Creat symfony project
RUN composer create-project symfony/skeleton .

# Installer php extension pour symfony
RUN apk add --no-cache \
  postgresql-dev \
  libxml2-dev \
  php81-pdo_pgsql \
  php81-simplexml \
  php81-posix \
  php81-pdo \
  bash \
  php-ctype \
  curl \
  && curl -sS https://get.symfony.com/cli/installer | bash \
  && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "/var/www/html/public"]