<?php


/** @var yii\web\View $this */
/** @var yii\web\IdentityInterface $user */
/** @var yii\mail\MessageInterface $message */
/** @var string $token */
?>

<?= Yii::t('hiam', 'Hello,') ?>

<?= Yii::t('hiam', 'New user signup: {login}', ['login' => $user->username]) ?>

login: <?= $user->username ?>
email: <?= $user->email ?>
first name: <?= $user->first_name ?>
last name: <?= $user->last_name ?>
ip: <?= Yii::$app->request->getRemoteIP() ?>
