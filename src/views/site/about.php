<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = Yii::t('app', 'About');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>This is Identity and Access Management server of <?= Yii::$app->themeManager->widget('OrganizationLink') ?>.</p>
    <p><?= Yii::$app->themeManager->widget('PoweredBy') ?>
</div>
