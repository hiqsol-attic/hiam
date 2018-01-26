<?php

use yii\helpers\Html;

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
        login: <b><?= $user->username ?></b><br>
        email: <?= $user->email ?><br>
        first name: <?= $user->first_name ?><br>
        last name: <?= $user->last_name ?><br>
    </p>
</div>
