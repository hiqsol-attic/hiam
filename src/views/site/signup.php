<?php

use hiqdev\thememanager\widgets\LoginForm;

/** @var yii\web\View $this */
$this->title = Yii::t('hiam', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= LoginForm::widget([
    'model' => $model,
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
