<?php

/** @var yii\web\View $this */
$this->title = Yii::t('hiam', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= Yii::$app->themeManager->widget([
    'class' => 'LoginForm',
    'model' => $model,
    'shows' => [
        'social-login' => true,
        'signup' => true,
        'restore-password' => true,
    ],
]) ?>
