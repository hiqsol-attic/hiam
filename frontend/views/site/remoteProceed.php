<?php
/**
 * @link    http://hiqdev.com/hi3a
 * @license http://hiqdev.com/hi3a/license
 * @copyright Copyright (c) 2014-2015 HiQDev
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

$this->title = 'Proceed with login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <h1><?= Html::encode($this->title) ?></h1>

    <h3>Ok, please select</h3>

    <br><br>
    <?= Html::a('I already have a membership', ['confirm']) ?>
    <br><br>

    <?= Html::a('Register a new membership', ['signup']) ?>
</div>
