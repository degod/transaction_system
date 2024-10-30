# Use PHP 8.3 as the base image
FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies and Nginx
RUN apt-get update && apt-get install -y \
    nginx \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Copy Nginx configuration file
COPY ./nginx/nginx.conf /etc/nginx/sites-available/default

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application code to the working directory
COPY . /var/www

# Set ownership and permissions
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Expose ports
EXPOSE 80

# Start Nginx and PHP-FPM
CMD service nginx start && php-fpm
