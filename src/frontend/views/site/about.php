<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = Yii::t('app', 'Powered by HIAM');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>HIAM is Identity and Access Management server providing OAuth2, ABAC and logging</p>
    <ul>
        <li>IAM - Identity and Access Management</li>
        <li>ABAC - Attribute Based Access Control</li>
        <li>Social login: Facebook, Google, VK, LinkedIn, GitHub, Live, Yandex</li>
        <li>Full activity logging with searching and reporting</li>
    </ul>
    <p>Open source. BSD-3-Clause license.</p>
    <p>Copyright © 2014-2015, HiQDev (<a href="https://hiqdev.com/">https://hiqdev.com/</a>)</p>
    <p>Available at <a href="https://github.com/hiqdev/hiam-core">GitHub</a>.</p>
</div>
