<?php

use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var string $url */
$this->title = Yii::t('hiam', 'Demo OAUTH2');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">

    <h5><?= Yii::t('hiam', 'Access Token Request') ?></h5>
    <br/>

    <?= $this->render('token-form', compact('tokenRequest'))?>

    <br/>
    <hr/>
    <br/>

    <ul>
        <li><?= Html::a('Authorization Code Request', '/demo/index') ?></li>
        <li><?= Html::a('Resource Request', '/demo/resource') ?></li>
    </ul>

</div>
