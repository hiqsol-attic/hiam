<?php

use yii\db\Schema;
use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function safeUp()
    {
        //$tableOptions = $this->mysql('CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('hi3a_remote_user', [
            'provider'      => 'char'                   . ' NOT NULL',
            'remoteid'      => Schema::TYPE_TEXT        . ' NOT NULL',
            'client_id'     => Schema::TYPE_INTEGER     . ' NOT NULL',
            'PRIMARY KEY (provider,remoteid)',
            'FOREIGN KEY (client_id) REFERENCES client (obj_id) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        return true;
    }

    public function safeDown()
    {
        $this->dropTable('hi3a_remote_user');

        return true;
    }
}
