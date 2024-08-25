FROM php:8.3.11RC2-fpm-alpine3.20

# Install necessary build dependencies and libraries
RUN apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    icu-dev \
    mariadb-dev \
    libzip-dev \
    zlib-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    gettext-dev \
    curl \
    gnupg \
    oniguruma-dev

# Install runtime dependencies
RUN apk add --no-cache \
    bash \
    nodejs \
    npm \
    libpng \
    libjpeg-turbo \
    freetype \
    libintl \
    libzip



# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install pnpm
RUN npm install -g pnpm

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install gettext intl pdo_mysql zip exif pcntl

# Install and enable the pcntl extension
RUN docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-install pcntl

# Clean up build dependencies to reduce image size
RUN apk del .build-deps

WORKDIR /var/www/html
