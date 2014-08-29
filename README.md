# Gamespot

A bare bones website for the Web Technologies class @ univaq.

The website is built with vanilla PHP, and uses MySQL as a DBMS.
It's served by Apache (`.htaccess` is a fundamental component of the website).

## Installation

This short installation guide will assume that the website will be installed on
an Ubuntu server machine. It should work (with minor tweaks if need be) on other
Linux distributions too.

### LAMP

Follow
[this](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu)
guide from DigitalOcean in order to setup Apache, MySQL and PHP on your server.

### Apache setup

Enable the `mod_rewrite` module with:

    a2enmod rewrite

Create a file `tdw.whatyouhi.de` in `/etc/apache2/sites-enabled` with this
content:

``` apache
<VirtualHost *:80>
  ServerAdmin webmaster@localhost

  ServerName tdw.whatyouhi.de
  DocumentRoot /home/whatyouhide/gamespot

  <Directory />
    Options FollowSymLinks
    AllowOverride None
  </Directory>

  <Directory /home/whatyouhide/gamespot>
    Options Indexes FollowSymLinks MultiViews
    AllowOverride All
    Order allow,deny
    allow from all
    Require all granted
    </Directory>
</VirtualHost>
```

### `config.ini`

Copy `config.ini.example` to `config.ini` on the server and tweak the
configurations to your needs.

## Synching

When you want to sync the website, just issue:

    gamespot-sync

If [direnv](http://direnv.net/) is enabled, otherwise:

    bin/gamespot-sync

This will also regenerate the documentation on the server.
