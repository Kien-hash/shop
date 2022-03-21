# How to install 
1. Install [xampp](https://www.apachefriends.org/download.html), [composer](https://getcomposer.org/Composer-Setup.exe).
2. Add `%xampp\php` to PATH
3. Clone code.
   ```
   git clone https://github.com/Kien-hash/shop.git
   ```
4. In xampp, open phpMyAdmin => create a database called `shop`
5. In database `shop`, import file [shop.sql](./shop.sql)
6. Create file .env (copies of [.env.example](./.env.example)). Then, change some param to this:
   ```
    ...
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=shop
    DB_USERNAME=root
    DB_PASSWORD=
    ...
   ```
7. Run:
   ```
   composer install
   php artisan key:generate
   php artisan serve
   ```

