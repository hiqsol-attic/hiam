<?php

/*
 * Identity and Access Management server providing OAuth2, RBAC and logging
 *
 * @link      https://github.com/hiqdev/hiam-core
 * @package   hiam-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

Yii::setAlias('hiam',     dirname(dirname(__DIR__)));
Yii::setAlias('project',  dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))));
Yii::setAlias('common',   '@project/common');
Yii::setAlias('frontend', '@project/frontend');
Yii::setAlias('backend',  '@project/backend');
Yii::setAlias('console',  '@project/console');
