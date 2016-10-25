<?php

/* @var $this yii\web\View */

$this->title = Yii::t('hiam', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Yii::$app->themeManager->widget([
    'class' => 'LoginForm',
    'model' => $model,
    'options' => [
        'validationUrl' => '/site/signup-validate',
    ],
    'texts' => [
        'message' => Yii::t('hiam', 'Please fill out the following fields to signup'),
    ],
    'shows' => [
        'login' => true,
    ],
]) ?>
