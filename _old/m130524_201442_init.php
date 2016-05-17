<?php

/*
 * Identity and Access Management server providing OAuth2, RBAC and logging
 *
 * @link      https://github.com/hiqdev/hiam-core
 * @package   hiam-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

use yii\db\Migration;
use yii\db\Schema;

class m130524_201442_init extends Migration
{
    public function safeUp()
    {
        //$tableOptions = $this->mysql('CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('hiam_remote_user', [
            'provider'      => 'char' . ' NOT NULL',
            'remoteid'      => Schema::TYPE_TEXT . ' NOT NULL',
            'client_id'     => Schema::TYPE_INTEGER . ' NOT NULL',
            'PRIMARY KEY (provider,remoteid)',
            'FOREIGN KEY (client_id) REFERENCES client (obj_id) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        return true;
    }

    public function safeDown()
    {
        $this->dropTable('hiam_remote_user');

        return true;
    }
}
