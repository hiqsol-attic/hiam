<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2018, HiQDev (http://hiqdev.com/)
 */

namespace hiam\base;

use hiam\forms\ChangeEmailForm;
use hiam\forms\ChangePasswordForm;
use hiam\models\Identity;
use Yii;
use yii\authclient\ClientInterface;
use yii\web\IdentityInterface;
use \yii\db\Exception;

class User extends \yii\web\User
{
    public $storageClasses = [];

    public $remoteUserClass;

    public $disableSignup = false;

    public $disableRestorePassword = false;

    public $loginDuration = 3600 * 24 * 31;

    public function login(IdentityInterface $identity, $duration = null)
    {
        return parent::login($identity, $duration ?? $this->loginDuration);
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
        $user->username = $model->username ?? $model->email;
        $ok = $user->save();

        if ($user->save()) {
            $this->notifySignup($user);

            return $user;
        }

        return null;
    }

    protected function notifySignup($user)
    {
        $params = Yii::$app->params;

        return Yii::$app->mailer->compose()
            ->renderHtmlBody('userSignup', compact('user'))
            ->setTo($params['signupEmail'] ?? $params['supportEmail'] ?? $params['adminEmail'])
            ->send();
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

    public function findIdentityByUsername($username)
    {
        $class = $this->identityClass;

        return $class::findIdentityByUsername($username);
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

    public function changePassword(ChangePasswordForm $model): bool
    {
        if (!$model->validate()) {
            return false;
        }
        $user = $this->findIdentityByUsername($model->login);
        $user->password = $model->new_password;
        if ($user->save()) {
            return true;
        }

        return false;
    }

    public function changeEmail(ChangeEmailForm $model): bool
    {
        if (!$model->validate()) {
            return false;
        }
        try {
            if (Yii::$app->db->createCommand()->update('zclient', ['email' => $model->email], 'login = :login')->bindValue(':login', $model->login)->execute()) {
                return true;
            }
        } catch (Exception $e) {
        }

        return false;
    }
}
