<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiam\base;

use yii\authclient\ClientInterface;
use yii\web\IdentityInterface;

class User extends \yii\web\User
{
    public $storageClasses = [];

    public $remoteUserClass;

    public $disableSignup = false;

    public $disableRestorePassword = false;

    public $loginDuration = 3600 * 24 * 31;

    public function login(IdentityInterface $identity, $duration = null)
    {
        return parent::login($identity, isset($duration) ? $duration : $this->loginDuration);
    }

    /**
     * Registers new user.
     * @return Identity|null the saved identity or null if saving fails
     */
    public function signup($model)
    {
        if (!$model->validate()) {
            return null;
        }
        $class = $this->identityClass;
        $user = new $class();
        $user->setAttributes($model->getAttributes());
        $user->username = isset($model->username) ? $model->username : $model->email;

        return $user->save() ? $user : null;
    }

    public function findIdentity($id, $password = null)
    {
        $class = $this->identityClass;

        return $class::findIdentity($id, $password);
    }

    public function findIdentityByEmail($email)
    {
        $class = $this->identityClass;

        return $class::findIdentityByEmail($email);
    }

    /**
     * Finds user through RemoteUser.
     * @return IdentityInterface
     */
    public function findIdentityByAuthClient(ClientInterface $client)
    {
        $remote = $this->getRemoteUser($client);
        if (!$remote->provider) {
            return null;
        }
        if ($remote->client_id) {
            return $this->findIdentity($remote->client_id);
        }
        $email = $client->getUserAttributes()['email'];
        $user = $this->findIdentityByEmail($email);
        if (!$user) {
            return null;
        }
        if ($remote->isTrustedEmail($email)) {
            return $this->setRemoteUser($client, $user);
        }

        return null;
    }

    /**
     * Inserts or updates RemoteUser.
     * @return IdentityInterface user
     */
    public function setRemoteUser(ClientInterface $client, IdentityInterface $user)
    {
        $model = $this->getRemoteUser($client);
        $model->client_id = $user->getId();
        $model->save();

        return $user;
    }

    public function getRemoteUser(ClientInterface $client)
    {
        $class = $this->remoteUserClass;

        return $class::findOrCreate($client->getId(), $client->getUserAttributes()['id']);
    }

    public function getStorageClass($name)
    {
        if ($name === $this->identityClass) {
            $name = 'identity';
        } elseif ($name === $this->remoteUserClass) {
            $name = 'remoteUser';
        }
        if (!isset($this->storageClasses[$name])) {
            throw new InvalidConfigException("not configured storage class for $name");
        }

        return $this->storageClasses[$name];
    }
}
