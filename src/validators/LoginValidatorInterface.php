<?php

namespace hiam\validators;

interface LoginValidatorInterface
{
    /**
     * // TODO: напиши PHPDoc
     */
    public function __invoke(string $attribute, array $params, yii\validators\InlineValidator $validator): void;
}
