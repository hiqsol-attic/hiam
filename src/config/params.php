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
    'logoUrl'           => '/site/back',

    'poweredByName'     => 'HIAM',
    'poweredByUrl'      => 'https://github.com/hiqdev/hiam-core',

    'user.passwordResetTokenExpire' => 3600,
    'user.enableAutoLogin'          => true,
    'user.disallowSignup'           => false,
    'user.disallowRestorePassword'  => false,
];
