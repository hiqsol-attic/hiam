<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   proprietary
 * @copyright Copyright (c) 2014-2019, HiQDev (http://hiqdev.com/)
 */

namespace hiam\models;

/**
 * ResourceRequest model.
 * Used for demo page.
 */
class ResourceRequest extends \yii\base\Model
{
    public $access_token;

    public function rules()
    {
        return [
            ['access_token',    'string'],
            ['access_token',    'required'],
        ];
    }

    public function formName()
    {
        return '';
    }
}
