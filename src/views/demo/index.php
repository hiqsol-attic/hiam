<?php

use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var string $url */

$this->title = Yii::t('hiam', 'Debug');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::a($url, $url) ?>
</div>
