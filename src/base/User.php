<?php

namespace hiam\base;

use yii\web\IdentityInterface;

class User extends \yii\web\User
{
    public $storageClass;

    public $disableSignup = false;

    public $disableRestorePassword = false;

    public $loginDuration = 3600 * 24 * 31;

    public function findIdentity($id, $password = null)
    {
        $class = $this->identityClass;
        return $class::findIdentity($id, $password);
    }

    public function login(IdentityInterface $identity, $duration = null)
    {
        if ($duration === null) {
            $duration = $this->loginDuration;
        }
        return parent::login($identity, $duration ?: $this->loginDuration);
    }
}
