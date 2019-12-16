<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   proprietary
 * @copyright Copyright (c) 2014-2019, HiQDev (http://hiqdev.com/)
 */

namespace hiam\actions;

use Yii;
use yii\base\Action;
use yii\helpers\Url;

class OpenapiAction extends Action
{
    public function run()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/x-yaml');
        $headers->add('Access-Control-Allow-Origin', '*');
        $path = dirname(__DIR__, 2) . '/openapi.yaml';
        $text = file_get_contents($path);

        return strtr($text, ['https://hiam.hipanel.com' => Url::base(true)]);
    }
}
