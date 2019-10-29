<?php

use hiqdev\thememanager\widgets\LoginForm;

/** @var yii\web\View $this */
/** @var hiam\forms\RestorePasswordForm $model */
/** @var bool $isCaptchaRequired */
$this->title = Yii::t('hiam', 'Request password reset');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= LoginForm::widget([
    'model' => $model,
    'isCaptchaRequired' => $isCaptchaRequired,
    'texts' => [
        'header' => '',
        'message' => Yii::t('hiam', 'Please fill out your username or email. We will send a password reset link.'),
    ],
    'shows' => [
        'signup' => true,
    ],
]) ?>
