<?php

namespace hiam\base;

use yii\web\IdentityInterface;
use yii\authclient\ClientInterface;

class User extends \yii\web\User
{
    public $storageClass;

    public $remoteUserClass;

    public $disableSignup = false;

    public $disableRestorePassword = false;

    public $loginDuration = 3600 * 24 * 31;

    public function login(IdentityInterface $identity, $duration = null)
    {
        if ($duration === null) {
            $duration = $this->loginDuration;
        }
        return parent::login($identity, $duration ?: $this->loginDuration);
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
}
