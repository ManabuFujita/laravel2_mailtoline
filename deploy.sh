#!/usr/bin/php

git pull git@github.com:ManabuFujita/laravel2_mailtoline.git
php artisan config:cache
php artisan route:cache
php artisan view:cache
