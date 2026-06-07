git pull git@github.com:ManabuFujita/laravel2_mailtoline.git
composer install --no-dev
/usr/local/bin/php8.2 artisan config:cache
/usr/local/bin/php8.2 artisan route:cache
/usr/local/bin/php8.2 artisan view:cache

