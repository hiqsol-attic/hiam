<?php
/**
 * hiam.0domain.name
 *
 * @link      http://hiam.0domain.name/
 * @package   hiam.0domain.name
 * @license   proprietary
 * @copyright Copyright (c) 2017-2018, AHnames (https://ahnames.com/)
 */

if (!defined('WEBAPP_ROOT_DIR')) {
    define('WEBAPP_ROOT_DIR', dirname(__DIR__, 4));
}

$bootstrap = WEBAPP_ROOT_DIR . '/vendor/hiqdev/hidev-webapp/src/bootstrap.php';

if (!file_exists($bootstrap)) {
    fwrite(STDERR, "Run composer to set up dependencies!\n");
    exit(1);
}

require_once $bootstrap;
