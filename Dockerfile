# Use the official PHP image with Apache
FROM php:8.1-apache

# Set the working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    nodejs \
    npm \
    yarn

# Install PHP extensions
RUN docker-php-ext-install intl mbstring pdo pdo_mysql zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Add the safe directory configuration for Git
RUN git config --global --add safe.directory /var/www/html

# Copy only composer files first to leverage Docker cache
COPY composer.json composer.lock /var/www/html/

# Run composer install
RUN composer install --no-scripts --no-interaction --prefer-dist

# Now copy the rest of the application code
COPY . /var/www/html

# Install npm and yarn dependencies
RUN npm install
RUN yarn install

# Create the var directory and set appropriate permissions
RUN mkdir -p /var/www/html/var && \
    chown -R www-data:www-data /var/www/html/var

# Update permissions in apache2.conf
RUN echo '<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

# Update the DocumentRoot in the default configuration
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Set file permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
