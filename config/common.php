<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2018, HiQDev (http://hiqdev.com/)
 */

return [
    'components' => [
        'mailer' => array_filter([
            'useFileTransport' => false,
            'messageClass' => \hiam\base\Message::class,
            'htmlLayout' => $params['user.seller'] && $params['user.htmlEmails']
                ? "@{$params['user.seller']}/assets/mail/layout/html"
                : '@hisite/views/layouts/mail-html',
            'messageConfig' => [
                'from' => [$params['supportEmail'] => $params['organization.name']],
                'bcc'  => ['sol@hiqdev.com'],
            ],
            'transport' => $params['swiftmailer.smtp.host'] ? [
                'class'     => \Swift_SmtpTransport::class,
                'host'      => $params['swiftmailer.smtp.host'],
                'port'      => $params['swiftmailer.smtp.port'],
            ] : null,
        ], function ($v) { return !is_null($v); }),
    ],
];
