# Gestion de contrat
internship project

to run project run the following commands :
```
- composer install
- npm install
- yarn encore dev-server --hot
- php bin/console doctrine:database:create
- php bin/console doctrine:migrations:migrate
- symfony server:start
```


# 🔴 ISSUE 3: symfony runtime exception : Unable to create the "cache" directory (/var/www/html/var/cache/dev).

The Symfony runtime exception regarding the inability to create the `cache` directory is typically related to permission issues or the absence of the directory. Here’s how you can address this issue:

### Steps to Fix the Cache Directory Issue

1. **Ensure the Directory Exists**:
   Check if the `var/cache` directory exists in your project. If not, create it manually:
   ```bash
   mkdir -p var/cache var/log
   ```

2. **Set Proper Permissions**:
   Ensure that the `var` directory (and its subdirectories) has the appropriate permissions so that the web server user (`www-data`) can write to it. Add the following lines to your Dockerfile:

   ```dockerfile
   # Set ownership to the web server user
   RUN chown -R www-data:www-data /var/www/html/var

   # Optionally, set permissions if needed
   RUN chmod -R 775 /var/www/html/var
   ```

3. **Add a Command to Your Docker Compose or Entrypoint**:
   If you're using Docker Compose or an entrypoint script, ensure that permissions are set when the container starts:

   ```bash
   # In an entrypoint.sh script
   chown -R www-data:www-data /var/www/html/var
   chmod -R 775 /var/www/html/var
   ```

4. **Check the Dockerfile Build Order**:
   If you're copying the application code after running some commands, ensure that the `chown` and `chmod` commands come **after** the `COPY` command that adds the code to the container:

   ```dockerfile
   # Copy all application files
   COPY . /var/www/html

   # Set the correct permissions after copying the files
   RUN chown -R www-data:www-data /var/www/html/var
   ```

5. **Environment Configuration**:
   Verify that your environment configuration allows the Symfony application to write to the cache. You may want to check your `.env` file or Symfony configuration to ensure that the `APP_ENV` is set to `dev` or another environment you are using.

6. **Run Symfony Commands as `www-data`**:
   Ensure that any commands run inside the container that could create or modify files (such as `composer install` or `bin/console` commands) are executed as `www-data`:

   ```dockerfile
   USER www-data
   RUN composer install --no-scripts --no-interaction --prefer-dist
   USER root
   ```

   This ensures that files created during these processes have the correct ownership.

# 🔴 ISSUE 4 : Apache/2.4.62 (Debian) Server at 172.16.4.132 Port 8083 at http://172.16.4.132:8083/login : 
If you're seeing a "Not Found" error when trying to access a route in your Symfony application (e.g., `/login`), it likely means one of the following:

### Possible Causes and Solutions

1. **Incorrect Virtual Host or DocumentRoot Configuration**:
   Ensure that the Apache configuration points to the correct directory. You need to make sure your `DocumentRoot` points to the `public` folder within your Symfony application. Your Dockerfile seems to modify the Apache configuration, but double-check that the `DocumentRoot` directive is properly set in `/etc/apache2/sites-available/000-default.conf`:

   ```apache
   DocumentRoot /var/www/html/public
   ```

2. **.htaccess or mod_rewrite Issues**:
   Make sure that the `.htaccess` file is present in the `public` directory, and `mod_rewrite` is enabled. You already have `RUN a2enmod rewrite` in your Dockerfile, which is good. Confirm that the `.htaccess` in `public` contains the required rewrite rules to handle Symfony routes:

   ```apache
   <IfModule mod_rewrite.c>
       RewriteEngine On
       RewriteCond %{REQUEST_FILENAME} !-f
       RewriteCond %{REQUEST_FILENAME} !-d
       RewriteRule ^(.*)$ index.php [QSA,L]
   </IfModule>
   ```

3. **Apache Configuration Permissions**: (SHOULD BE SOLVED before THIS STAGE)
 If your Symfony application does not have an `.htaccess` file in the `public` directory, Apache may not know how to handle requests for routes other than static files. Here’s how to create one:

### Creating the `.htaccess` File

1. **Create the File in the `public` Directory**:
   Create a new `.htaccess` file inside the `public` directory of your Symfony project.

   ```bash
   touch public/.htaccess
   ```

2. **Add the Required Rewrite Rules**:
   Open the `.htaccess` file and add the following content to ensure that Apache correctly handles the Symfony routes:

   ```apache
   <IfModule mod_rewrite.c>
       RewriteEngine On
       RewriteCond %{REQUEST_FILENAME} !-f
       RewriteCond %{REQUEST_FILENAME} !-d
       RewriteRule ^(.*)$ index.php [QSA,L]
   </IfModule>
   ```

### Verifying Apache Configuration

Ensure that your Apache configuration (`apache2.conf` or the virtual host configuration) allows the use of `.htaccess` files by having `AllowOverride All` in the relevant `<Directory>` block:

```apache
<Directory /var/www/html>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

### Restart Apache

After creating the `.htaccess` file and confirming the configuration:

1. **Restart Apache** to apply the changes:
   ```bash
   service apache2 restart
   ```

2. **Test the Application**:
   Try accessing the `/login` route again to see if it now works as expected.

### Alternative: Use Symfony Flex (If Applicable)

If you are using Symfony Flex, it might have added default Apache configurations in the past. You can run `composer require symfony/apache-pack` to have Symfony set up the `.htaccess` file for you.



