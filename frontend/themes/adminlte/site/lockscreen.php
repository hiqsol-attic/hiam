<?php
/**
 * Created by PhpStorm.
 * User: tofid
 * Date: 01.04.15
 * Time: 17:53
 */
use yii\helpers\Html;

$this->blocks['bodyClass'] = 'lockscreen';
$this->title = 'Lockscreen';
?>

<!-- User name -->
<div class="lockscreen-name">John Doe</div>

<!-- START LOCK SCREEN ITEM -->
<div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
        <img src="https://almsaeedstudio.com/themes/AdminLTE/dist/img/user1-128x128.jpg" alt="user image"/>
    </div>
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
    <form class="lockscreen-credentials">
        <input type="submit" class="form-control btn" value="Yes" />
    </form><!-- /.lockscreen credentials -->

</div><!-- /.lockscreen-item -->
<div class="help-block text-center">
    Enter your password to retrieve your session
</div>
<div class='text-center'>
    <?= Html::a('Or logout and sign in as a different user', ['/site/logout']); ?>
</div>
<div class='lockscreen-footer text-center'>
    Copyright &copy; 2014-2015 <b><a href="http://almsaeedstudio.com" class='text-black'><?= Yii::$app->name; ?></a></b><br>
    All rights reserved
</div>