<?php

/** @var yii\web\View $this */
/** @var yii\web\IdentityInterface $user */
/** @var yii\mail\MessageInterface $message */
/** @var string $token */
?>

<?= Yii::t('hiam', 'Hello,') ?>

<?= Yii::t('hiam', 'New user signup: {login}', ['login' => $user->username]) ?>

<?= Yii::t('hiam', 'Login: {login}', ['login' => $user->username]) ?>

<?= Yii::t('hiam', 'Email: {email}', ['email' => $user->email]) ?>

<?= Yii::t('hiam', 'First name: {first_name}', ['first_name' => $user->first_name]) ?>

<?= Yii::t('hiam', 'Last name: {last_name}', ['last_name' => $user->last_name]) ?>

<?= Yii::t('hiam', 'IP: {ip}', ['ip' => Yii::$app->request->getRemoteIP()]) ?>

