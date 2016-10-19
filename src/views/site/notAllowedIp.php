<?php

use yii\helpers\Html;

$this->title = Yii::t('hiam', 'Not allowed IP');

?>

<h1 align="center"><?= $this->title ?></h1>

<p align="center">
    <?= Yii::t('hiam', 'You are not allowed to login from this IP') ?>:
    <?= Yii::$app->request->getUserIP() ?>
</p> 

<p align="center">
    <?= Html::a(Yii::t('hiam', 'Add this IP to the list of allowed IPs'), ['/site/not-allowed-ip', 'token' => 'send']) ?>
</p> 
