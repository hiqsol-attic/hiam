<?php

namespace frontend\components;

use Yii;
use yii\web\Request;

class MyRequest extends Request {

    public function value ($name, $default = null) {
        $params = $this->getBodyParams();
        $value = isset($params[$name]) ? $params[$name] : $this->get($name);
        return $value ?: $default;
    }

};
