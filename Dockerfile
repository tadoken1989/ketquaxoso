FROM php:7.1-apache

WORKDIR /var/www/html

RUN DEBIAN_FRONTEND=noninteractive apt-get update && apt-get install -y \
	libmcrypt-dev \
    zlib1g-dev \
    telnet \
    git \
  && rm -rf /var/lib/apt/lists/*

COPY ./default.conf /etc/apache2/sites-available/000-default.conf

# Setup bare-minimum extra extensions for Laravel & others

RUN docker-php-ext-install mysqli pdo pdo_mysql


RUN docker-php-ext-install mbstring mcrypt zip

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
	--install-dir=/usr/local/bin \
	--filename=composer

RUN  chown -R www-data:www-data /var/www

RUN  a2enmod rewrite && service apache2 restart

ADD php-custom.ini /usr/local/etc/php/conf.d/php-custom.ini

COPY . /var/www/html
