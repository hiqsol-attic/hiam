<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var hiam\models\User $user */
/** @var yii\mail\MessageInterface $message */
/** @var string $token */
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/site/not-allowed-ip', 'token' => (string) $token]);

$message->setSubject(Yii::t('hiam', 'Allow IP {ip} for {org}', ['ip' => $token->get('ip'), 'org' => Yii::$app->params['organizationName']]));

$message->renderTextBody(basename(__FILE__, '.php') . '-text', compact('user', 'resetLink'));

?>
<div class="password-reset">
    <p><?= Yii::t('hiam', 'Hello {name}', ['name' => Html::encode($user->name)]) ?>,</p>

    <p><?= Yii::t('hiam', 'Follow the link below to allow IP address {ip}:', ['ip' => $token->get('ip')]) ?></p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
