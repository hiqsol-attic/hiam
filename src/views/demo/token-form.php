<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \yii\web\View $this */
/** @var \hiam\models\TokenRequest $tokenRequest */

?>
<?php $form = ActiveForm::begin([
    'id' => 'token-form',
    'action' => '/oauth/token',
]) ?>

<?= $form->field($tokenRequest, 'client_id') ?>
<?= $form->field($tokenRequest, 'client_secret') ?>
<?= $form->field($tokenRequest, 'redirect_uri') ?>
<?= $form->field($tokenRequest, 'grant_type') ?>
<?= $form->field($tokenRequest, 'code') ?>

<?= Html::submitButton('oauth/token', ['class' => 'btn btn-primary btn-block']) ?>

<?php $form->end() ?>
