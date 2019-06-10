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
 * AuthorizeRequest model.
 * Used for demo page.
 */
class AuthorizeRequest extends \yii\base\Model
{
    public $client_id;
    public $redirect_uri;
    public $response_type;
    public $scopes;
    public $state;

    public function rules()
    {
        return [
            ['client_id',       'string'],
            ['redirect_uri',    'string'],
            ['response_type',   'string'],
            ['scopes',          'string'],
            ['state',           'string'],
        ];
    }
}
