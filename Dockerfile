# Bước 1: Sử dụng hình ảnh PHP cơ bản
FROM php:8.2-fpm

# Cài đặt các phụ thuộc hệ thống cần thiết
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev unzip git \
    && rm -rf /var/lib/apt/lists/*

# Cài đặt các tiện ích PHP cần thiết
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip

# Cài đặt Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Sao chép mã nguồn vào thư mục /var/www/html
COPY . /var/www/html

# Thiết lập thư mục làm việc
WORKDIR /var/www/html

# Cài đặt các phụ thuộc của Composer
RUN composer install --no-dev --optimize-autoloader \
    && php artisan package:discover --ansi \
    && php artisan vendor:publish --tag=laravel-assets --ansi --force \
    && php -r "file_exists('.env') || copy('.env.example', '.env');" \
    && php artisan key:generate --ansi \
    && composer dump-autoload

# Expose port 9000
EXPOSE 9000

# Thiết lập lệnh mặc định
CMD ["php-fpm"]
