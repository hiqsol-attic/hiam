<?php

use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var string $url */

$this->title = Yii::t('hiam', 'Demo OAUTH2');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">

    <h5>Authorization Code Request</h5>
    <br/>

    <?= $this->render('authorize-form', compact('authorizeRequest'))?>

    <br/>
    <hr/>
    <br/>

    <ul>
        <li><?= Html::a('Access Token Request', '/demo/token') ?></li>
        <li><?= Html::a('Resource Request', '/demo/resource') ?></li>
    </ul>

</div>
