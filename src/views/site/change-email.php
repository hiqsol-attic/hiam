<?php

/** @var \hiam\forms\ChangeEmailForm $model */
use hiam\widgets\ChangeEmailForm;

$this->title = Yii::t('hiam', 'Change email');

?>

<?= ChangeEmailForm::widget(['model' => $model]) ?>
