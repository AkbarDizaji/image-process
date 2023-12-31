# Base image
FROM php:8.3-cli

ENV COMPOSER_ALLOW_SUPERUSER=1

# Set working directory
WORKDIR /app

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    postgresql-client \
    libpng-dev

# Install gd extension
RUN docker-php-ext-install gd

# Install PHP extensions and development libraries
RUN docker-php-ext-install zip pdo pdo_mysql \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql

# Install required dependencies and enable GD extension
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd


# Copy composer files
COPY composer.json composer.json
COPY composer.lock composer.lock

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install project dependencies
RUN composer install --no-scripts --no-autoloader

# Copy application files
COPY . .

# Generate autoloader
RUN composer dump-autoload --optimize

# Expose the application port (optional)
EXPOSE 8000

# Start the application using PHP's built-in development server
CMD php -S 0.0.0.0:8000 -t public