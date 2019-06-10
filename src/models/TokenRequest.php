<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2018, HiQDev (http://hiqdev.com/)
 */

namespace hiam\models;

/**
 * TokenRequest model.
 * Used for demo page.
 */
class TokenRequest extends \yii\base\Model
{
    public $client_id;
    public $client_secret;
    public $redirect_uri;
    public $grant_type;
    public $code;

    public function rules()
    {
        return [
            ['client_id',       'string'],
            ['client_secret',   'string'],
            ['redirect_uri',    'string'],
            ['grant_type',      'string'],
            ['code',            'string'],
        ];
    }

    public function formName()
    {
        return '';
    }
}
