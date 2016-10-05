<?php

/*
 * Identity and Access Management server providing OAuth2, RBAC and logging
 *
 * @link      https://github.com/hiqdev/hiam-core
 * @package   hiam-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hiam\storage;

class ClientQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        parent::init();
        $this
            ->select([
                'c.obj_id   AS id',
                'c.login    AS username',
                'r.login    AS seller',
                'y.name     AS type',
                'z.name     AS state',
                'k.name     AS name',
                'coalesce(c.email,k.email) AS email',
            ])
            ->from('client          c')
            ->innerJoin('client     r', 'r.obj_id=c.seller_id')
            ->innerJoin('ref        y', 'y.obj_id=c.type_id')
            ->innerJoin('ref        z', "z.obj_id=c.state_id AND z.name IN ('ok')")
            ->leftJoin('contact     k', 'k.obj_id=c.obj_id')
        ;
    }

    public function andWhere($condition)
    {
        if (!is_array($condition) || $condition[0]) {
            return parent::andWhere($condition);
        }
        foreach (['id', 'username', 'password', 'email'] as $key) {
            if (isset($condition[$key])) {
                $this->{"where$key"}($condition[$key]);
                unset($condition[$key]);
            }
        }
        if (!empty($condition)) {
            $this->andWhere($condition);
        }

        return $this;
    }

    public function whereId($id)
    {
        return parent::andWhere(['c.obj_id' => $id]);
    }

    public function whereEmail($username)
    {
        return $this->whereUsername($username);
    }

    public function whereUsername($username)
    {
        $userId = (int) $username;
        if ($userId>0) {
            return $this->whereId($userId);
        }

        return parent::andWhere(['or', 'c.login=:username', 'c.email=:username'], [':username' => $username]);
    }

    public function wherePassword($password)
    {
        return parent::andWhere(
            'check_password(:password,c.password) OR check_password(:password,t.value)',
            [':password' => $password]
        )->leftJoin('value t', "t.obj_id=c.obj_id AND t.prop_id=prop_id('client,access:tmp_pwd')");
    }
}
