<?php

use yii\helpers\Html;

/* @var \yii\web\View $this */

$this->title = Yii::t('hiam', 'About');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>This is Identity and Access Management server of <?= Yii::$app->themeManager->widget('OrganizationLink') ?>.</p>
    <p><?= Yii::$app->themeManager->widget('PoweredBy') ?>
</div>
