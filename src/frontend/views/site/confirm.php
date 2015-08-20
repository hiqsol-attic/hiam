<?php
/**
 * @link    http://hiqdev.com/hi3a
 * @license http://hiqdev.com/hi3a/license
 * @copyright Copyright (c) 2014-2015 HiQDev
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\authclient\widgets\AuthChoice;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

$this->blocks['bodyClass'] = 'login-page';
$this->title = 'Confirm connect social';
?>

<div class="login-box-body">
    <p class="login-box-msg"><?= $this->title ?></p>
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <div class="form-group has-feedback">
            <?= $form->field($model, 'username')->textInput(['placeholder' => 'Login or Email', 'class' => 'form-control', 'autofocus' => 'autofocus'])->label(false); ?>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password', 'class' => 'form-control'])->label(false); ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Confirm</button>
            </div><!-- /.col -->
        </div>
    <?php $form::end(); ?>

    <br>
    <?= Html::a('I forgot my password', ['/site/recovery']); ?><br>
    <?= Html::a('Register a new membership', ['/site/signup']); ?>

</div><!-- /.login-box-body -->
