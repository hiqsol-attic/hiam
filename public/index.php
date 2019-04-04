<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2018, HiQDev (http://hiqdev.com/)
 */

use hiqdev\composer\config\Builder;
use yii\web\Application;

(function () {
    require __DIR__ . '/../config/bootstrap.php';

    $config = require Builder::path(
		$_ENV['ENV'] === 'test' ? 'web-test' : 'web'
    );

    (new Application($config))->run();
})();
