<?php

use hiqdev\thememanager\widgets\LoginForm;

/** @var yii\web\View $this */
/** @var hiam\forms\LoginForm $model */
/** @var bool $isCaptchaRequired */
$this->title = Yii::t('hiam', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= LoginForm::widget([
    'model' => $model,
    'captcha' => $isCaptchaRequired,
    'shows' => [
        'social-login' => true,
        'signup' => true,
        'restore-password' => true,
    ],
]) ?>
