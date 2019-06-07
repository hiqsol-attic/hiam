<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2018, HiQDev (http://hiqdev.com/)
 */

namespace hiam\controllers;

use yii\helpers\Url;

/**
 * Demo controller.
 */
class DemoController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $url = Url::to(['/oauth/authorize',
            'client_id'     => 'me',
            'scopes'        => 'email',
            'state'         => 'x',
            'response_type' => 'code',
            'redirect_uri'  => 'http://localhost/oauth',
        ], true);

        return $this->render('index', [
            'url' => $url,
        ]);
    }
}
