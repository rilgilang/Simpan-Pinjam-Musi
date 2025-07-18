FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd mbstring

# Set working directory
WORKDIR /var/www/html

# Copy app files
COPY . .

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Expose the port for PHP built-in server
EXPOSE 9000

# Run Laravel dev server (or any PHP entrypoint)
CMD ["php", "-S", "0.0.0.0:9000", "-t", "public"]
