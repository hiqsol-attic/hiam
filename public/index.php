<?php
/**
 * hiam.0domain.name
 *
 * @link      http://hiam.0domain.name/
 * @package   hiam.0domain.name
 * @license   proprietary
 * @copyright Copyright (c) 2017-2018, AHnames (https://ahnames.com/)
 */

require __DIR__ . '/../config/bootstrap.php';

$config = require \hiqdev\composer\config\Builder::path('hisite');

(new \yii\web\Application($config))->run();
