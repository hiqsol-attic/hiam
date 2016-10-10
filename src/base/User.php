<?php

namespace hiam\base;

use yii\web\IdentityInterface;

class User extends \yii\web\User
{
    public $storageClass;

    public $disallowSignup = false;

    public $disallowRestorePassword = false;

    public $loginDuration = 3600 * 24 * 31;

    public function findIdentity($id)
    {
        $class = $this->identityClass;
        return $class::findIdentity($id);
    }

    public function login(IdentityInterface $identity, $duration = 0)
    {
        if ($duration === null) {
            $duration = $this->loginDuration;
        }
        return parent::login($identity, $duration ?: $this->loginDuration);
    }
}
