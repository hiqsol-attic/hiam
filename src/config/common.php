<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2018, HiQDev (http://hiqdev.com/)
 */

return [
    'aliases' => [
        '@runtime/var'      => $params['hiapi.var_dir'],
        '@runtime/tokens'   => '@runtime/var/tokens',
    ],
];
