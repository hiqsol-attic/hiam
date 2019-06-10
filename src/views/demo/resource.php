<?php

use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var string $url */

$this->title = Yii::t('hiam', 'Demo OAUTH2');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">

    <h5>Resource Request</h5>
    <br/>

    <?= $this->render('resource-form', compact('resourceRequest'))?>

    <br/>
    <hr/>
    <br/>

    <ul>
        <li><?= Html::a('Authorize Code Request', '/demo/authorize') ?></li>
        <li><?= Html::a('Access Token Request', '/demo/token') ?></li>
    </ul>

</div>
