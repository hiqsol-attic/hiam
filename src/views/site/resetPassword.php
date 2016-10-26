<?php

/** @var yii\web\View $this */
$this->title = Yii::t('hiam', 'Reset password');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= Yii::$app->themeManager->widget([
    'class' => 'LoginForm',
    'model' => $model,
    'texts' => [
        'header' => '',
        'message' => Yii::t('hiam', 'Please choose your new password'),
    ],
]) ?>
