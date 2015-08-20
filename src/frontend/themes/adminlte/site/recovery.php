<?php
/**
 * Created by PhpStorm.
 * User: tofid
 * Date: 01.04.15
 * Time: 18:02
 */
$this->blocks['bodyClass'] = 'login-page';
$this->title = 'Recovery';
?>

<div class="login-box-body">
    <p class="login-box-msg">Recovery</p>
    <form action="../../index2.html" method="post">
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Email"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Send</button>
            </div><!-- /.col -->
        </div>
    </form>
</div><!-- /.login-box-body -->