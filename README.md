# php-api

## mariadb

- create datebase

- create user / pass for login to database

## php-fpm

- create new socket

## nginx

> ref: https://docs.nginx.com/nginx/admin-guide/security-controls/configuring-http-basic-authentication/

- mkdir -p /etc/nginx/auth

- sudo htpasswd -c /etc/nginx/auth/.htpasswd user1
 
- use file nginx_web.conf
