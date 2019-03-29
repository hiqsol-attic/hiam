<?php

return [
    'PARAMS_LOCATION' => dirname(__DIR__) . '/vendor/hiqdev/composer-config-plugin-output/acceptance.php',
    'YII2_CONFIG_LOCATION' => dirname(__DIR__) . '/tests/acceptance/config/suite.php',

    'COMMON_TESTS_LOCATION' => dirname(__DIR__) . '/tests',
    'COMMON_ACCEPTANCE_SUITE' => dirname(__DIR__) . '/tests/acceptance.suite.yml',

    'URL' => $params['url'],
    'BROWSER' => 'chrome',
    'SELENIUM_HOST' => $params['tests.acceptance.selenium.host'],
];
