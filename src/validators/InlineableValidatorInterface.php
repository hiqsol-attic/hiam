<?php

namespace hiam\validators;

use yii\validators\InlineValidator;
use yii\base\Model;

interface InlineableValidatorInterface
{
    /**
     * Provides inline validator closure for given model.
     * @var Model $model
     * @return function ($attribute, $params, $validator)
     */
    public function inlineFor(Model $model): \Closure;
}
