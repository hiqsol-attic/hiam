<?php

use hiqdev\thememanager\widgets\LoginForm;

/** @var yii\web\View $this */
$this->title = Yii::t('hiam', 'Reset password');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= LoginForm::widget([
    'model' => $model,
    'texts' => [
        'header' => '',
        'message' => Yii::t('hiam', 'Please choose your new password'),
    ],
    'options' => [
        'action' => ['token' => (string) $token],
    ],
]) ?>
