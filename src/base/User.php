<?php

namespace hiam\base;

class User extends \yii\web\User
{
    public $storageClass;

    public $disallowSignup = false;

    public $disallowRestorePassword = false;
}
