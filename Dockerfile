FROM php:8.4-apache

# 1. Устанавливаем системные библиотеки и Node.js (нужен для сборки стилей)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libsodium-dev \
    libsqlite3-dev \
    curl \
    && curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# 2. Устанавливаем расширения PHP
RUN docker-php-ext-install \
    pdo_sqlite \
    zip \
    gd \
    sodium \
    opcache

# 3. Настраиваем Apache под Laravel
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# 4. Копируем файлы проекта
COPY . /var/www/html

# 5. Устанавливаем Composer и зависимости PHP
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# 6. Устанавливаем зависимости Node.js и собираем стили Vite (Решит нашу ошибку!)
RUN npm install
RUN npm run build

# 7. Создаем пустую базу данных
RUN touch /var/www/html/database/database.sqlite

# 8. Права доступа для веб-сервера
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# 9. Настраиваем .env и генерируем ключ
RUN cp .env.example .env || true
RUN php artisan key:generate

EXPOSE 80

# 10. Очищаем базу и запускаем веб-сервер
CMD ["sh", "-c", "php artisan migrate:fresh --force && apache2-foreground"]
