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
    libzip-dev \
    zip \
    unzip \
    
    && docker-php-ext-install zip


# Install supervisor
RUN apt-get install -y supervisor

# Install vim for debugging purposes
RUN apt-get install -y vim

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
#COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

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

RUN composer self-update --1

COPY .env.example /var/www/.env

# Deployment steps
RUN composer install --optimize-autoloader --dev

RUN php artisan key:generate

RUN chmod 777 /var/www/docker

# RUN chmod +x /var/www/docker/run.sh

USER $user

EXPOSE 80
# ENTRYPOINT ["/var/www/docker/run.sh"]
