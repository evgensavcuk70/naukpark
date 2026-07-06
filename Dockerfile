# =========================================================
# Dockerfile для Laravel-застосунку (PHP-FPM)
# =========================================================

FROM php:8.3-fpm

# Робоча директорія всередині контейнера
WORKDIR /var/www/html

# Встановлюємо системні залежності, потрібні для PHP-розширень
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    default-mysql-client \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Встановлюємо PHP-розширення, потрібні Laravel + MySQL + GD (картинки) + ZIP
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl

# Налаштовуємо PHP для роботи з tmp директоріями в контейнері
RUN echo 'upload_tmp_dir=/tmp' >> /usr/local/etc/php/conf.d/docker-php.ini && \
    echo 'sys_temp_dir=/tmp' >> /usr/local/etc/php/conf.d/docker-php.ini && \
    echo 'max_execution_time=300' >> /usr/local/etc/php/conf.d/docker-php.ini

# Встановлюємо Composer (менеджер пакетів PHP) - копіюємо вже зібраний бінарник
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Встановлюємо Node.js 20 (потрібен для збірки фронтенду через Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Копіюємо весь код проєкту в контейнер
COPY . .

# Гарантовано створюємо обов'язкові storage-директорії.
# Git/zip-архіви не зберігають порожні папки, тож без цього кроку
# Laravel падає з помилками "directory does not exist" при першому запуску.
RUN mkdir -p \
    storage/framework/sessions \
    storage/framework/cache/data \
    storage/framework/testing \
    storage/app/public \
    storage/logs \
    bootstrap/cache

# Встановлюємо PHP-залежності проєкту (без dev-пакетів, як для продакшну)
# Якщо потрібно дев-середовище з тестами - забери "--no-dev"
RUN composer install --no-dev --optimize-autoloader

# Встановлюємо JS-залежності і збираємо фронтенд (Vite + Tailwind)
RUN npm install && npm run build

# Виставляємо правильні права на директорії, куди Laravel пише файли
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/images \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/images

# PHP-FPM слухає порт 9000 (за ним прийде nginx)
EXPOSE 9000

CMD ["php-fpm"]
