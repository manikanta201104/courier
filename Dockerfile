# Use an official PHP image with Apache
FROM php:8.2-apache

# Copy project files to the Apache root directory
COPY . /var/www/html/

# Give proper permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Enable necessary PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Expose port 80 for Apache
EXPOSE 80

# Start Apache when the container runs
CMD ["apache2-foreground"]
