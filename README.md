## Build & Run

1. Install composer dependencies
   ```shell
   composer i
   ```
2. Start sail
    ```shell
    ./vendor/bin/sail up -d
    ```
3. Run migrations
   ```shell
    ./vendor/bin/sail artisan migrate
   ```
4. Run seeders
    ```shell
    ./vendor/bin/sail artisan db:seed
    ```
5. Run interval list command
    ```shell
    ./vendor/bin/sail artisan intervals:list --left=23 --right=1000
    ```

