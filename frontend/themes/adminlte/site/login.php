<?php
/**
 * Created by PhpStorm.
 * User: tofid
 * Date: 01.04.15
 * Time: 17:29
 */
use yii\helpers\Html;

$this->blocks['bodyClass'] = 'login-page';
$this->title = 'Sign in';
?>

<div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <form action="../../index2.html" method="post">
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Email"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox"> Remember Me
                    </label>
                </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
        </div>
    </form>

    <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
        <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
    </div><!-- /.social-auth-links -->

    <?= Html::a('I forgot my password', ['/site/recovery']); ?><br>
    <?= Html::a('Register a new membership', ['/site/register'], ['class' => 'text-center']); ?>

</div><!-- /.login-box-body -->