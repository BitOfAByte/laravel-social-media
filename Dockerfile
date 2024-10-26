FROM bitnami/laravel:latest

# Set working directory
WORKDIR /app

# Copy the application code
COPY . .

# Install the Composer dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copy the environment file
COPY .env.example .env

# Generate the application key
RUN php artisan key:generate
RUN php artisan storage:link

EXPOSE 8000
CMD php artisan migrate && php artisan serve --host=0.0.0.0 --port=8000
