<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \yii\web\View $this */
/** @var \hiam\models\AuthorizeRequest $authorizeRequest */

?>

<?php $form = ActiveForm::begin([
    'id' => 'authorize-form',
    'action' => '/oauth/authorize',
    'method' => 'get',
]) ?>

<?= $form->field($authorizeRequest, 'client_id') ?>
<?= $form->field($authorizeRequest, 'redirect_uri') ?>
<?= $form->field($authorizeRequest, 'response_type') ?>
<?= $form->field($authorizeRequest, 'scopes') ?>
<?= $form->field($authorizeRequest, 'state') ?>
<?= $form->field($authorizeRequest, 'prefer_signup') ?>

<?= Html::submitButton('oauth/authorize', ['class' => 'btn btn-primary btn-block']) ?>

<?php $form->end() ?>
