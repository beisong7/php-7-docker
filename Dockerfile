FROM php:7.4-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

# Copy code to /var/www
COPY --chown=www:www-data . /var/www

RUN chown -R www:www /var/www

# add root to www group
RUN chmod -R ugo+rw /var/www/storage

# Laravel Error Log Permission
RUN chmod 777 /var/www/storage

COPY .env.example /var/www/.env

# Deployment steps
RUN composer install --optimize-autoloader --dev

RUN php artisan key:generate

EXPOSE 80

USER $user