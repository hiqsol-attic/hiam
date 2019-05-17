<?php

/** @var \hiam\forms\ChangePasswordForm $model */

use hiqdev\thememanager\widgets\ChangePasswordForm;

$this->title = Yii::t('hiam', 'Change password');

?>

<?= ChangePasswordForm::widget([
    'model' => $model,
]) ?>
