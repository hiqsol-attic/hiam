<?php

use yii\db\Schema;
use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function safeUp()
    {
        //$tableOptions = $this->mysql('CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('hi3a_user', [
            'id'            => Schema::TYPE_PK,
            'type'          => 'char'                   . ' NOT NULL',
            'state'         => 'char'                   . ' NOT NULL',
            'username'      => Schema::TYPE_TEXT        . '     NULL',
            'email'         => Schema::TYPE_TEXT        . '     NULL',
            'abuse_email'   => Schema::TYPE_TEXT        . '     NULL',
            'password_hash' => Schema::TYPE_TEXT        . '     NULL',
            'remoteid'      => Schema::TYPE_TEXT        . '     NULL',
            'create_time'   => Schema::TYPE_TIMESTAMP   . ' NOT NULL',
            'update_time'   => Schema::TYPE_TIMESTAMP   . ' NOT NULL',
/// birth_date,organization,street1,street2,street3,city,province,postal_code,country,phone,fax,abuse_email
            'UNIQUE (username)',
            'UNIQUE (email)',
        ], $tableOptions);

        $this->createTable('hi3a_contact', [
            'id'            => Schema::TYPE_PK,
            'state'         => 'char'                   . ' NOT NULL',
            'user_id'       => Schema::TYPE_INTEGER     . ' NOT NULL',
            'email'         => Schema::TYPE_TEXT        . '     NULL',
            'password'      => Schema::TYPE_TEXT        . '     NULL',
            'remoteid'      => Schema::TYPE_TEXT        . '     NULL',
            'create_time'   => Schema::TYPE_TIMESTAMP   . ' NOT NULL',
            'update_time'   => Schema::TYPE_TIMESTAMP   . ' NOT NULL',
            'birth_date'    => Schema::TYPE_DATE        . '     NULL',
            'first_name'    => Schema::TYPE_TEXT        . " NOT NULL DEFAULT ''",
            'last_name'     => Schema::TYPE_TEXT        . " NOT NULL DEFAULT ''",
            'organization'  => Schema::TYPE_TEXT        . " NOT NULL DEFAULT ''",
            'street1'       => Schema::TYPE_TEXT        . " NOT NULL DEFAULT ''",
            'street2'       => Schema::TYPE_TEXT        . " NOT NULL DEFAULT ''",
            'street3'       => Schema::TYPE_TEXT        . " NOT NULL DEFAULT ''",
            'city'          => Schema::TYPE_TEXT        . " NOT NULL DEFAULT ''",
            'province'      => Schema::TYPE_TEXT        . " NOT NULL DEFAULT ''",
            'postal_code'   => Schema::TYPE_TEXT        . " NOT NULL DEFAULT ''",
            'country'       => Schema::TYPE_TEXT        . " NOT NULL DEFAULT ''",
            'phone'         => Schema::TYPE_TEXT        . " NOT NULL DEFAULT ''",
            'fax'           => Schema::TYPE_TEXT        . " NOT NULL DEFAULT ''",
/// birth_date,organization,street1,street2,street3,city,province,postal_code,country,phone,fax,abuse_email
        ], $tableOptions);

        $this->createTable('hi3a_remote_user', [
            'provider'      => 'char'                   . ' NOT NULL',
            'remoteid'      => Schema::TYPE_TEXT        . ' NOT NULL',
            'user_id'       => Schema::TYPE_INTEGER     . ' NOT NULL',
            'PRIMARY KEY (provider,remoteid)',
            'FOREIGN KEY (user_id) REFERENCES hi3a_user (id) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        return true;
    }

    public function safeDown()
    {
        $this->dropTable('hi3a_remote_user');

        return true;
    }
}
