<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   proprietary
 * @copyright Copyright (c) 2014-2019, HiQDev (http://hiqdev.com/)
 */

namespace hiam\components;

use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;

class AuthKeyGenerator
{
    /**
     * @var string Secret key to be used by OpenSSL
     */
    private $secret;

    private $cipher;

    public function __construct($secret, $cipher)
    {
        if (empty($secret)) {
            throw new InvalidConfigException('Secret is missing');
        }
        if (!in_array($cipher, openssl_get_cipher_methods(), true)) {
            throw new InvalidConfigException('Cipher "' . $cipher . '" is not supported by local OpenSSL');
        }

        $this->secret = base64_encode($secret);
        $this->cipher = $cipher;
    }

    /**
     * @param string $password_hash Password hash encoded in base64
     * @return string
     */
    protected function buildIv($password_hash)
    {
        $iv = base64_decode($password_hash, true);
        if ($iv === false) {
            throw new InvalidParamException('Wrong password hash');
        }

        $ivlen = openssl_cipher_iv_length($this->cipher);
        if (strlen($iv) < $ivlen) {
            $iv = str_pad($iv, strlen($iv) - $ivlen, '0');
        }

        return $iv;
    }

    /**
     * @param string $user_id
     * @param string $password_hash Password hash encoded in base64
     * @return string Token that contains encrypted user_id and encryption tag
     */
    public function generateForUser($user_id, $password_hash)
    {
        $iv = $this->buildIv($password_hash);
        $encrypted = openssl_encrypt((string) $user_id, $this->cipher, $this->secret, 0, $iv, $tag);

        return implode('.', [$encrypted, base64_encode($tag)]);
    }

    /**
     * Method validates that provided $token was generated for the $user_id
     * and is valid only while its' password hash equals $password_hash.
     *
     * @param string $user_id
     * @param string $password_hash
     * @param string $token
     * @return bool whether $token is valid
     */
    public function validateForUser($user_id, $password_hash, $token)
    {
        list($encrypted, $tag) = explode('.', $token);
        $iv = $this->buildIv($password_hash);
        $decrypted = openssl_decrypt($encrypted, $this->cipher, $this->secret, 0, $iv, base64_decode($tag, true));

        return $decrypted === (string) $user_id;
    }
}
