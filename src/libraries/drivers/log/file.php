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

class FileLog
{
    const LOGFILE_NAME = 'php-redis-admin.log';

    protected $config_dir;
    protected $threshold;

    public function __construct()
    {
        $this->threshold = App::instance()->config['log']['threshold'];
        if ($this->threshold > 0) {
            $this->config_dir = App::instance()->config['log']['file']['directory'];
            if (!$this->config_dir) {
                echo 'Please provide a log directory in your config file';
                throw new ExitException();
            } else {
                if ('/' != $this->config_dir{0}) {
                    $this->config_dir = ROOT_DIR.DIRECTORY_SEPARATOR.$this->config_dir;
                }
                if (!is_writable($this->config_dir)) {
                    echo "Log directory '{$this->config_dir}' does not exist or is not writable";
                    throw new ExitException();
                }
            }
        }
    }

    public function write($type, $msg, $namespace = null)
    {
        if ($this->threshold < Log::instance()->$type) {
            return;
        }

        $logfile = rtrim($this->config_dir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.self::LOGFILE_NAME;
        if (false === ($file = fopen($logfile, 'a+'))) {
            echo 'Can not open file: '.$logfile;
            throw new ExitException();
        }

        $ip = isset($_SERVER['REMOTE_ADDR']) ? "[{$_SERVER['REMOTE_ADDR']}]" : '';
        $namespace = isset($namespace) ? '['.ucwords(strtolower($namespace)).']' : '';
        $date = '['.date('Y-m-d H:i:s').']';

        fwrite($file, "{$date} {$ip} {$namespace} [{$type}]: {$msg}\n");
        fclose($file);
    }
}
