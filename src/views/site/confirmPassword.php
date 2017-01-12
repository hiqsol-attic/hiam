<?php

use hiqdev\thememanager\widgets\LoginForm;

/** @var yii\web\View $this */
$this->title = Yii::t('hiam', 'Confirm password');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= LoginForm::widget([
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
