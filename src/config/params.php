<?php

/*
 * Identity and Access Management server providing OAuth2, RBAC and logging
 *
 * @link      https://github.com/hiqdev/hiam-core
 * @package   hiam-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

return [
    'adminEmail'            => 'admin@hiqdev.com',
    'poweredByName'         => 'HIAM',
    'poweredByUrl'          => 'https://github.com/hiqdev/hiam-core',

    'cookieValidationKey'   => '',
    'debug_allowed_ips'     => [],

    'db_name'               => 'mrdp',
    'db_user'               => 'sol',
    'db_password'           => '****',

    'user.passwordResetTokenExpire' => 3600,

    'facebook_client_id'        => null,
    'facebook_client_secret'    => null,
    'google_client_id'          => null,
    'google_client_secret'      => null,
];
