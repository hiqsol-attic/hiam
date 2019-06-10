<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \yii\web\View $this */
/** @var \hiam\models\AuthorizeRequest $authorizeRequest */

?>
<h5>Authorization Code Request</h5>
<br/>

<?php $form = ActiveForm::begin([
    'id' => 'authorize-form',
    'action' => '/oauth/authorize',
]) ?>

<?= $form->field($authorizeRequest, 'client_id') ?>
<?= $form->field($authorizeRequest, 'redirect_uri') ?>
<?= $form->field($authorizeRequest, 'response_type') ?>
<?= $form->field($authorizeRequest, 'scopes') ?>
<?= $form->field($authorizeRequest, 'state') ?>

<?= Html::submitButton('oauth/authorize', ['class' => 'btn btn-primary btn-block']) ?>

<?php $form->end() ?>
