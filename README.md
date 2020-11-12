# php api

## mariadb

### create database

- create database room;

### create user / pass for login to database

- localhost
  - create user 'r4r'@'localhost' identified by 'password';
  - grant all privileges on room.* to 'r4r'@'localhost';
  - flush privileges;

- %
  - create user 'r4r'@'%' identified by 'password';
  - grant all privileges on room.* to 'r4r'@'%';
  - flush privileges;

## php-fpm

- create new socket

## nginx

> reference: <https://docs.nginx.com/nginx/admin-guide/security-controls/configuring-http-basic-authentication/>

- mkdir -p /etc/nginx/auth
- sudo htpasswd -c /etc/nginx/auth/.htpasswd user1
- use file nginx_web.conf
