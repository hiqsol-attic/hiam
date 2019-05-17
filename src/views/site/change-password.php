<?php

/** @var \hiam\forms\ChangePasswordForm $model */

use hiam\widgets\ChangePasswordForm;

$this->title = Yii::t('hiam', 'Change password');

?>

<?= ChangePasswordForm::widget(['model' => $model]) ?>
