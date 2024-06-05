composer install --ignore-platform-reqs --optimize-autoloader --no-scripts --no-interaction
php artisan migrate --no-scripts --no-interaction
composer dump-autoload --no-scripts --no-interaction
