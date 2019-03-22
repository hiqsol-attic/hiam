<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2018, HiQDev (http://hiqdev.com/)
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
