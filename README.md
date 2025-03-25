<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# 

1. Clone project
2. Setup the .env according the .env.example

The envs more importan its APP_KEY and SESSION_DRIVER

For generate the APP_KEY only exceute this command:
```sh
php artisan key:generate
```

In the session driver for example if yoy database is sqlite the driver is file

3. Execute

```sh
composer install
npm install
```

4. Test the project run the comand
```sh
php artisan serve
```

maybe you can build the pages so you can do it with this:
```sh
npm run build
# OR
npm run dev
```
