<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\web\IdentityInterface $user */
/** @var yii\mail\MessageInterface $message */
/** @var string $token */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => (string) $token]);

$message->setSubject(Yii::t('hiam', 'Password reset for {org}', ['org' => Yii::$app->params['organizationName']]));

$message->renderTextBody(basename(__FILE__, '.php') . '-text', compact('user', 'resetLink'));

?>
<div class="password-reset">
    <p><?= Yii::t('hiam', 'Hello {name},', ['name' => Html::encode($user->name)]) ?></p>

    <p><?= Yii::t('hiam', 'Follow the link below to reset your password:') ?></p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
