<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Signup';
$this->blocks['bodyClass'] = 'register-page';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="register-box-body">
    <h1><?= Html::encode($this->title) ?></h1>
    <p class="login-box-msg">Please fill out the following fields to signup:</p>

    <?php $form = ActiveForm::begin(['id' => 'form-signup']) ?>
        <div class="form-group has-feedback">
            <?= $form->field($model, 'first_name')->textInput(['placeholder' => 'First Name','class'=>'form-control', 'autofocus' => 'autofocus'])->label(false) ?>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <?= $form->field($model, 'last_name')->textInput(['placeholder' => 'Last Name','class'=>'form-control'])->label(false) ?>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email', 'class' => 'form-control'])->label(false) ?>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Password','class'=>'form-control'])->label(false) ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <?= $form->field($model, 'password_retype')->passwordInput(['placeholder'=>'Retype password', 'class'=>'form-control'])->label(false) ?>
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox"> I agree to the <a href="#">terms</a>
                    </label>
                </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Signup</button>
            </div><!-- /.col -->
        </div>
    <?php ActiveForm::end(); ?>

    <?= Html::a('I already have a membership', ['/site/confirm']); ?>
</div><!-- /.form-box -->
