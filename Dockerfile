FROM php:8.2-apache

# Устанавливаем необходимые зависимости
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libsodium-dev \
    libsqlite3-dev \
    && rm -rf /var/lib/apt/lists/*

# Включаем PHP расширения
RUN docker-php-ext-install \
    pdo_sqlite \
    zip \
    gd \
    sodium \
    opcache

# Настраиваем Apache (Mod_rewrite для Laravel)
RUN a2enmod rewrite

# Копируем исходный код приложения в контейнер
COPY . /var/www/html

# Устанавливаем Composer (если его нет в образе)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Обновляем зависимости Composer
RUN composer install --no-dev --optimize-autoloader

# Устанавливаем права на папки (для Laravel)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Копируем .env.example в .env (если .env нет)
RUN cp .env.example .env || true

# Генерируем ключ приложения
RUN php artisan key:generate

# Открываем порт 80 (стандартный для веб)
EXPOSE 80
CMD ["sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0"]
