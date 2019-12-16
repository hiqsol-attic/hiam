<?php

/** @var yii\web\View $this */
/** @var yii\web\IdentityInterface $user */
/** @var yii\mail\MessageInterface $message */
/** @var string $token */
$org = Yii::$app->params['organization.name'];

$message->setSubject(Yii::t('hiam', '[{org}] New user signup', ['org' => $org]));

$message->renderTextBody(basename(__FILE__, '.php') . '-text', compact('user'));

?>
<div class="password-reset">
    <p><?= Yii::t('hiam', 'Hello,') ?></p>

    <p><?= Yii::t('hiam', 'New user signup:') ?></p>

    <p>
        <?= Yii::t('hiam', 'Login') ?>: <b><?= $user->username ?></b><br>
        <?= Yii::t('hiam', 'Email') ?>: <?= $user->email ?><br>
        <?= Yii::t('hiam', 'First name') ?>: <?= $user->first_name ?><br>
        <?= Yii::t('hiam', 'Last name') ?>: <?= $user->last_name ?><br>
        <?= Yii::t('hiam', 'IP') ?>:  <?= Yii::$app->request->getRemoteIP() ?><br>
    </p>
</div>
