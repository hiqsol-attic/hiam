<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \yii\web\View $this */
/** @var \hiam\models\ResourceRequest $resourceRequest */

?>
<?php $form = ActiveForm::begin([
    'id' => 'userinfo-form',
    'action' => '/userinfo',
]) ?>

<?= $form->field($resourceRequest, 'access_token')->textInput(['name' => 'access_token']) ?>

<?= Html::submitButton('userinfo', ['class' => 'btn btn-primary btn-block']) ?>

<?php $form->end() ?>
