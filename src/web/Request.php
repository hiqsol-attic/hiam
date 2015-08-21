<?php

namespace hiam\web;

use Yii;

class Request extends \yii\web\Request {

    public function value ($name, $default = null) {
        $params = $this->getBodyParams();
        $value = isset($params[$name]) ? $params[$name] : $this->get($name);
        return $value ?: $default;
    }

};
