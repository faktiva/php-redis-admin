<?php

/*
 * This file is part of the "PHP Redis Admin" package.
 *
 * (c) Faktiva (http://faktiva.com)
 *
 * NOTICE OF LICENSE
 * This source file is subject to the CC BY-SA 4.0 license that is
 * available at the URL https://creativecommons.org/licenses/by-sa/4.0/
 *
 * DISCLAIMER
 * This code is provided as is without any warranty.
 * No promise of being safe or secure
 *
 * @author   Sasan Rose <sasan.rose@gmail.com>
 * @author   Emiliano 'AlberT' Gabrielli <albert@faktiva.com>
 * @license  https://creativecommons.org/licenses/by-sa/4.0/  CC-BY-SA-4.0
 * @source   https://github.com/faktiva/php-redis-admin
 */


// Gets an env var, with fallback to default
function envDef($envName, $defaultVal = null) {

  $env = getenv($envName);

  if($env !== null) {
    return $env;
  }

  return $defaultVal;

}

$config = array(
    'default_controller' => 'Welcome',
    'default_action' => 'Index',
    'debug' => (bool) (envDef('DEBUG', false)),
    'default_layout' => 'layout',
    'timezone' => 'Europe/Rome',
    'auth' => array(
        'username' => envDef('LOGIN_USER', 'admin'),
        'password' => password_hash(envDef('LOGIN_PASS', 'admin'), PASSWORD_DEFAULT),
    ),
    'log' => array(
        'driver' => 'file',
        'threshold' => envDef('LOG_LEVEL', 2), /* 0: Disable Logging, 1: Error, 2: Warning, 3: Notice, 4: Info, 5: Debug */
        'file' => array(
            'directory' => 'var/log',
        ),
    ),
    'database' => array(
        'driver' => 'redis',
        'mysql' => array(
            'host' => envDef('MYSQL_HOST', 'localhost'),
            'username' => envDef('MYSQL_USERNAME', 'root'),
            'password' => envDef('MYSQL_PASSWORD', 'root'),
        ),
        'redis' => array(
            array(
                'host' => envDef('REDIS_HOST', 'localhost'),
                'port' => envDef('REDIS_PORT', '6379'),
                'password' => envDef('REDIS_PASSWORD', null),
                'database' => envDef('REDIS_DATABASE', 0),
                'max_databases' => getenv('REDIS_MAX_DATABASE', 16), /* Manual configuration of max databases for Redis < 2.6 */
                'stats' => array(
                    'enable' => 1,
                    'database' => 0,
                ),
                'dbNames' => array(/* Name databases. key should be database id and value is the name */
                ),
            ),
        ),
    ),
    'session' => array(
        'name' => 'PRASESSION',
    ),
    'gearman' => array(
        'host' => '127.0.0.1',
        'port' => 4730,
    ),
    'terminal' => array(
        'enable' => true,
        'history' => 200,
    ),
);

return $config;
