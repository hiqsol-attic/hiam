<?php

use hiqdev\thememanager\widgets\LoginForm;

/** @var yii\web\View $this */

$this->title = Yii::t('hiam', 'Request password reset');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= LoginForm::widget([
    'model' => $model,
    'texts' => [
        'header' => '',
        'message' => Yii::t('hiam', 'Please fill out your email. A link to reset password will be sent there.'),
    ],
    'shows' => [
        'signup' => true,
    ],
]) ?>
