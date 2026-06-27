FROM php:8.4-apache

# 1. Устанавливаем необходимые системные библиотеки
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

# 2. Устанавливаем расширения PHP (включая SQLite)
RUN docker-php-ext-install \
    pdo_sqlite \
    zip \
    gd \
    sodium \
    opcache

# 3. Перенаправляем Apache на публичную папку Laravel (public)
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# 4. Копируем файлы проекта в контейнер
COPY . /var/www/html

# 5. Устанавливаем Composer и зависимости
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# 6. Создаем пустую базу данных прямо на сервере
RUN touch /var/www/html/database/database.sqlite

# 7. ДАЕМ ПРАВА ДОСТУПА ВЕБ-СЕРВЕРУ (Это решит нашу ошибку!)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# 8. Настраиваем .env и генерируем ключ безопасности
RUN cp .env.example .env || true
RUN php artisan key:generate

# Открываем порт 80
EXPOSE 80

# 9. При старте контейнера очищаем базу и запускаем веб-сервер Apache
CMD ["sh", "-c", "php artisan migrate:fresh --force && apache2-foreground"]
