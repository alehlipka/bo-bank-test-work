FROM php:8.3-fpm-alpine

RUN echo "dev ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers

RUN addgroup -g 1000 dev
RUN adduser -u 1000 -G dev -h /home/dev -D dev

RUN sed -i "s/user = www-data/user = dev/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = dev/g" /usr/local/etc/php-fpm.d/www.conf
RUN echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apk add --no-cache \
  curl \
  libxml2-dev \
  php-soap \
  libzip-dev \
  unzip \
  zip \
  libpng \
  libpng-dev \
  jpeg-dev \
  oniguruma-dev \
  curl-dev \
  freetype-dev \
  libpq-dev \
  icu-dev

RUN docker-php-ext-install pgsql pdo pdo_pgsql mbstring exif zip soap pcntl bcmath curl zip opcache

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-configure intl \
  && docker-php-ext-install intl

RUN apk --no-cache add pcre-dev ${PHPIZE_DEPS} && pecl install redis && docker-php-ext-enable redis

WORKDIR /home/dev/apps

RUN chown -R www-data:www-data /home/dev/apps

USER dev

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]