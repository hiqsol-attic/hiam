<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   proprietary
 * @copyright Copyright (c) 2014-2019, HiQDev (http://hiqdev.com/)
 */

namespace hiam\widgets;

use yii\base\Widget;

class ChangePasswordForm extends Widget
{
    /**
     * @var \hiam\forms\ChangePasswordForm
     */
    public $model;

    public function run()
    {
        return $this->render('ChangePasswordForm', [
            'model' => $this->model,
        ]);
    }
}
