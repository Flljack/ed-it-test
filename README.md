## 🚀 Build & Run

### 🐳 For Docker

1. Copy env.example to .env
    ```shell
    cp .env.example .env
    ```
2. Run docker-compose
    ```shell
    docker-compose up -d --build
    ```
3. Initialize app
    ```shell
    docker-compose exec laravel.test composer install &&
    docker-compose exec laravel.test php artisan key:generate &&
    docker-compose exec laravel.test php artisan migrate
    ```
4. Run seed for Interval
    ```shell
    docker-compose exec laravel.test php artisan db:seed --class=IntervalsSeeder
    ```
5. Run interval list command
    ```shell
    docker-compose exec laravel.test php artisan intervals:list --left=23 --right=1000
    ```

### If you using Laravel Sail

1. Copy env.example to .env
    ```shell
    cp .env.example .env
    ```

2. Install composer dependencies
   ```shell
   composer i
   ```
3. Start sail
    ```shell
    ./vendor/bin/sail up -d
    ```
4. Run migrations
   ```shell
    ./vendor/bin/sail artisan migrate
   ```
5. Run seeders
    ```shell
    ./vendor/bin/sail artisan db:seed
    ```
6. Run interval list command
    ```shell
    ./vendor/bin/sail artisan intervals:list --left=23 --right=1000
    ```

