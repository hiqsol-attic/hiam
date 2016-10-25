<?php

/* @var $this yii\web\View */

$this->title = Yii::t('hiam', 'Confirm password');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= Yii::$app->themeManager->widget([
    'class' => 'LoginForm',
    'model' => $model,
    'texts' => [
        'header' => '',
        'message' => Yii::t('hiam', 'Please enter your password'),
    ],
    'shows' => [
        'restore-password' => true,
        'signup' => true,
    ],
]) ?>
