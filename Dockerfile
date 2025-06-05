FROM php:8.4-apache

# Copy `./markdown-blog` to `/var/www/html`

COPY ./markdown-blog /var/www/html

# Set ownership and permissions of Apache Document Root to www-data:www-data
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Enable Apache modules
RUN a2enmod rewrite headers

EXPOSE 80

ENTRYPOINT ["apache2-foreground"]

