<?php

use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var string $url */

$this->title = Yii::t('hiam', 'Demo OAUTH2');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">

    <?= $this->render('authorize-form', compact('authorizeRequest'))?>

    <br/>
    <hr/>
    <br/>

    <?= $this->render('token-form', compact('tokenRequest'))?>

</div>
