<?php

use hiqdev\thememanager\widgets\LoginForm;

/** @var yii\web\View $this */
/** @var \hiam\forms\SignupForm $model */
/** @var bool $captcha title */
$this->title = Yii::t('hiam', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= LoginForm::widget([
    'model' => $model,
    'captcha' => $captcha,
    'options' => [
        'validationUrl' => '/site/signup-validate',
    ],
    'texts' => [
        'message' => Yii::t('hiam', 'Please fill out the following fields to signup'),
        'button' => Yii::t('hiam', 'Proceed'),
    ],
    'shows' => [
        'login' => true,
    ],
]) ?>
