<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2018, HiQDev (http://hiqdev.com/)
 */

require __DIR__ . '/../config/bootstrap.php';

$config = require \hiqdev\composer\config\Builder::path( //'hisite'
    $_ENV['ENV'] === 'dev'
            ? 'web-test'
            : 'web-test'
);

(new \yii\web\Application($config))->run();
