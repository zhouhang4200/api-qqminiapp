# 今日好看

## 接口文档
api.miniapp.test/docs

## 部署
环境：nginx、php 7.1（pdo_mysql，redis，fileinfo扩展）、mysql 5.7、redis、composer

1、发布和配置

发布代码到 /webser/www/qqminiapp/ 目录。

在项目目录下:
```
php artisan storage:link
cp .env.example .env
```
2、执行数据库迁移和初始数据：

```
php artisan migrate
composer install
```
3、在www用户下面增加定时任务

```
* * * * * /usr/bin/php /webser/www/qqminiapp/artisan schedule:run >> /dev/null 2>&1
```

4、nginx配置

先修改权限

```
chown -R www:www /webser/www/qqminiapp/* && chmod -R 755/webser/www/qqminiapp/*
```
nginx 配置，ssl证书配置。

```
server {
    listen 443;

    ssl on;
    ssl_certificate    /webser/www/qqminiapp/storage/ssl/*.two002.com.crt;
    ssl_certificate_key /webser/www/qqminiapp/storage/ssl/*.two002.com.key;

    server_name  mini.adhei.com api.mini.adhei.com;
    index index.html index.htm index.php;
    root /webser/www/qqminiapp/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.html index.htm index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/dev/shm/php-fpm72.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    access_log  logs/api.qqminiapp.com.access.log;
    error_log  logs/api.qqminiapp.com.error.log;
}

server {  
    listen  80;  
    server_name  api.qqminiapp.com;      
    rewrite ^(.*)$  https://$host$1 permanent;  
} 
```
6、验证

```
https://api.qqminiapp.com/docs
```
有响应，说明基本正常。
