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
        return $this->render('index', [
            'url' => $url,
        ]);
    }

    public function actionGo()
    {
        return $this->redirect($this->buildAuthorizeUrl());
    }

    private function buildAuthorizeUrl()
    {
        return Url::to(['/oauth/authorize',
            'client_id'     => 'demo',
            'scopes'        => 'email',
            'state'         => 'x',
            'response_type' => 'code',
            'redirect_uri'  => 'http://localhost/oauth',
        ], true);
    }
}
