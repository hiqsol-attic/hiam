<?php

use hiam\frontend\assets\PictonicAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\authclient\widgets\AuthChoice;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */
PictonicAsset::register($this);
$this->registerCss(<<<'CSS'
.social-button-login > a:nth-child(n+3){
    display:none;
}​

.social-button-login:hover > a:nth-child(n+1) {
    display:block;
}
CSS
);


// Social Pictonic associative
$buttonOptions = [
    'facebook' => [
        'icon' => 'icon-facebook',
    ],
    'google' => [
        'icon' => 'icon-google',
    ],
    'github' => [
        'icon' => 'icon-github-01',
    ],
    'linkedin' => [
        'icon' => 'icon-linkedin',
    ],
    'vk' => [
        'icon' => 'icon-rus-vk-02',
    ],
    'yandex' => [
        'icon' => 'icon-rus-yandex-01',
    ],
    'windows' => [
        'icon' => 'fa fa-windows',
    ],
];

$this->blocks['bodyClass'] = 'login-page';
$this->title = 'Sign in';
$this->registerCss(<<<'CSS'
    .checkbox label {
        padding-left: 0px;
    }
CSS
);
?>

<div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
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
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <?= $form->field($model, 'rememberMe')->checkbox([])->label(false); ?>
                </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
        </div>
    <?php $form::end(); ?>

    <?php $authAuthChoice = AuthChoice::begin([
        'baseAuthUrl' => ['site/auth'],
        'options' => ['class' => 'social-auth-links text-center'],
    ]); ?>
        <p>-- OR SIGN IN WITH --</p>
    <div class="social-button-login">
        <div class="row">
        <?php foreach ($authAuthChoice->getClients() as $name => $client): ?>
            <div class="col-md-6 col-xs-12" style="margin-bottom: 0.5em">
            <?php $text = sprintf("<i class='%s'></i>&nbsp;%s", $buttonOptions[$name]['icon'], $client->getTitle()); ?>
            <?php $authAuthChoice->clientLink($client,$text,['class' => "btn btn-block btn-social btn-$name"]) ?>
            </div>
        <?php endforeach ?>
        </div>
    </div>
    <?php AuthChoice::end(); ?>

    <?= Html::a('I forgot my password', ['/site/recovery']); ?><br>
    <?= Html::a('Register a new membership', ['/site/signup']); ?>

</div><!-- /.login-box-body -->
