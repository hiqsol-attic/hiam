<?php

use hiqdev\thememanager\widgets\LoginForm;

/** @var yii\web\View $this */
$this->title = Yii::t('hiam', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= LoginForm::widget([
    'model' => $model,
    'shows' => [
        'social-login' => true,
        'signup' => true,
        'restore-password' => true,
    ],
]) ?>
