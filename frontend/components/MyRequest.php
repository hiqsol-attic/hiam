<?php

namespace frontend\components;

use Yii;
use yii\web\Request;

class MyRequest extends Request {

    public function value ($name) {
        $params = $this->getBodyParams();
        return isset($params[$name]) ? $params[$name] : $this->get();
    }

};
