# How to install 
## First method
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
8. Go to http://localhost:3000/ => customer page
9. Go to http://localhost:3000/admin => admin page
   ```
   username: admin@gmail.com
   password: 123456
   ```


## Second method
1. Install [docker](https://docs.docker.com/get-docker/)
2. Download [this](https://drive.google.com/file/d/1C8a91yVvR5ua-O3uw-AuF1ymN-Xg4Dmh/view?usp=sharing) (is a compressed docker image file)
3. Run
   ```
      docker load -i shop
      docker run -it -p 8000:8000 shop:v1
      service mysql start
      cd /home/admin/shop/
      php artisan serve --host 0.0.0.0
   ```
5. Go to http://localhost:3000/ => customer page
6. Go to http://localhost:3000/admin => admin page
   ```
   username: admin@gmail.com
   password: 123456
   ```


