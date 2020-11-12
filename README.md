# PHP API

## MariaDB

### create database

- create database room;

### create user

- localhost
  - create user 'r4r'@'localhost' identified by 'password';
  - grant all privileges on room.* to 'r4r'@'localhost';
  - flush privileges;
- %
  - create user 'r4r'@'%' identified by 'password';
  - grant all privileges on room.* to 'r4r'@'%';
  - flush privileges;

## PHP-FPM

- create new socket

## Nginx

> reference: <https://docs.nginx.com/nginx/admin-guide/security-controls/configuring-http-basic-authentication/>

- mkdir -p /etc/nginx/auth
- sudo htpasswd -c /etc/nginx/auth/.htpasswd user1
- cp [nginx_web.conf](./nginx_web.conf) /etc/nginx/conf.d/
