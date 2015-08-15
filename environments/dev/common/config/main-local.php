<?php
return [
    'components' => [
        'db' => [
            'class'     => 'yii\db\Connection',
            'dsn'       => 'pgsql:host=localhost;port=5432;dbname=mrdp',
            'charset'   => 'utf8',
            'username'  => 'sol',
            'password'  => 'cnhju45l',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
