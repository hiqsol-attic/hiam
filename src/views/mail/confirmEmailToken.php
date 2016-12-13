<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\web\IdentityInterface $user */
/** @var yii\mail\MessageInterface $message */
/** @var string $token */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm-email', 'token' => (string) $token]);

$message->setSubject(Yii::t('hiam', '[{org}] Please confirm your email address', ['org' => Yii::$app->params['organizationName']]));

$message->renderTextBody(basename(__FILE__, '.php') . '-text', compact('user', 'confirmLink'));

?>
<div class="password-reset">
    <p><?= Yii::t('hiam', 'Hello {name},', ['name' => Html::encode($user->name)]) ?></p>

    <p><?= Yii::t('hiam', 'Follow the link below to confirm your email:') ?></p>

    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
</div>
