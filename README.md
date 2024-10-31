# E-commers-system-task

- composer create-project laravel/laravel:^10.0 E-commers-system-task

-
php artisan make:model User -m
php artisan make:model Product -m
php artisan make:model Order -m

- composer require tymon/jwt-auth
- php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
- php artisan jwt:secret

- php artisan make:model order_product
- php artisan make:factory OrderProductFactory
- php artisan make:seeder OrderProductTableSeed
- php artisan db:seed --class=OrdersTableSeeder
- php artisan db:seed --class=OrderSeeder  
