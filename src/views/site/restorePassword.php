<?php

use hiqdev\thememanager\widgets\LoginForm;

/** @var yii\web\View $this */
/** @var hiam\forms\RestorePasswordForm $model */
/** @var bool $captcha */
$this->title = Yii::t('hiam', 'Request password reset');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= LoginForm::widget([
    'model' => $model,
    'captcha' => $captcha,
    'texts' => [
        'header' => '',
        'message' => Yii::t('hiam', 'Please fill out your username or email. We will send a password reset link.'),
    ],
    'shows' => [
        'signup' => true,
    ],
]) ?>
