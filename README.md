PHP Redis Admin
=========

A web interface to manage and monitor your Redis server(s).

This is a maintained fork of [PHPRedMin](https://github.com/sasanrose/phpredmin), by [Sasan Rose](https://github.com/sasanrose) (_Thanks for the great job!_).

_Note:_ PHP Redis Admin is mostly compatible with [phpredis](https://github.com/nicolasff/phpredis) redis module for PHP

## Installation

Just drop phpredmin in your webserver's root directory and point your browser to it (You also need [phpredis](https://github.com/nicolasff/phpredis) installed)

## Configuration

Apache configuration example (`/etc/httpd/conf.d/phpredmin.conf`):

```ApacheConf
# PHP Redis Admin sample apache configuration
#
# Allows only localhost by default

Alias /phpredmin /var/www/phpredmin/web

<Directory /var/www/phpredmin/>
   AllowOverride All

   <IfModule mod_authz_core.c>
     # Apache 2.4
     <RequireAny>
       Require ip localhost
       Require local
     </RequireAny>
   </IfModule>
   <IfModule !mod_authz_core.c>
     # Apache 2.2
     Order Deny,Allow
     Deny from All
     Allow from 127.0.0.1
     Allow from ::1
   </IfModule>
</Directory>
```

**Note:**
_If your redis server is on an IP or port other than defaults (`localhost:6379`), you should edit `app/config/config.php` file
You can copy `app/config/config.dist.php`to `app/config/config.php` and edit as you need. Of course you could just include the original file and override only the configuration you need, retaining the distribution defaults._

```php
// app/config/config.php

require_once __DIR__.'/config.dist.php';

$config = array_merge(
    $config,
    array(
		/*
		 * the following are your custom settings ...
		 */
        'debug' => true,
        'auth' => null,
        'log' => array(
            'driver'    => 'file',
            'threshold' => 5, /* 0: Disable Logging, 1: Error, 2: Warning, 3: Notice, 4: Info, 5: Debug */
            'file'      => array('directory' => 'var/logs')
        ),
    )
);

return $config;

```

## Features

See [Features.md](Features.md)

## License

See [LICENSE.md](LICENSE.md)

