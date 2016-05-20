<?php

/*
 * Identity and Access Management server providing OAuth2, RBAC and logging
 *
 * @link      https://github.com/hiqdev/hiam-core
 * @package   hiam-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hiam\rbac;

use hiam\models\User;
use yii\base\InvalidParamException;
use yii\rbac\Assignment;
use yii\rbac\DbManager;
use yii\rbac\Permission;
use yii\rbac\Role;
use yii\rbac\Rule;

/**
 * hi3a RBAC DB Manager.
 */
class HiDbManager extends DbManager
{
    protected $is_loaded    = false;
    protected $is_forced    = false;
    protected $roles        = [];
    protected $permissions  = [];
    protected $rules        = [];

    public function init()
    {
        parent::init();
    }

    public function load($force = false)
    {
        if ($this->is_forced) {
            $force = true;
        }
        if ($this->is_loaded && !$force) {
            return;
        }
        $this->roles        = $this->getRoles();
        $this->permissions  = $this->getPermissions();
        $this->rules        = $this->getRules();
        $this->is_loaded    = true;
    }

    public function removeAllChildren()
    {
        $this->db->createCommand()->delete($this->itemChildTable)->execute();
    }

    public function what($obj)
    {
        if ($obj instanceof Role) {
            return 'role';
        } elseif ($obj instanceof Permission) {
            return 'permission';
        } elseif ($obj instanceof Rule) {
            return 'rule';
        } else {
            throw new InvalidParamException('Checking unsupported object type.');
        };
    }

    protected function _has($name, $what)
    {
        return key_exists($name, $this->{$what . 's'});
    }
    protected function _get($name, $what)
    {
        return $this->_has($name, $what) ? $this->{$what . 's'}[$name] : parent::{'get' . $what}($name);
    }
    protected function _set($name, $what, $obj)
    {
        $this->_has($name, $what) ? $this->update($name, $obj) : $this->add($obj);
        $this->{$what . 's'}[$obj->name] = $obj;
        return $obj;
    }

    public function has($obj)
    {
        $this->load();
        return $this->_has($obj->name, $this->what($obj));
    }
    public function get($obj)
    {
        $this->load();
        return $this->_get($obj->name, $this->what($obj));
    }
    public function set($obj)
    {
        $this->load();
        return $this->_set($obj->name, $this->what($obj), $obj);
    }

    public function hasRole($name)
    {
        $this->load();
        return $this->_has($name, 'role');
    }
    public function hasPermission($name)
    {
        $this->load();
        return $this->_has($name, 'permission');
    }
    public function hasRule($name)
    {
        $this->load();
        return $this->_has($name, 'rule');
    }

    public function getRole($name)
    {
        $this->load();
        return $this->_get($name, 'role');
    }
    public function getPermission($name)
    {
        $this->load();
        return $this->_get($name, 'permission');
    }
    public function getRule($name)
    {
        $this->load();
        return $this->_get($name, 'rule');
    }

    public function setRole($name)
    {
        return $this->set($this->createRole($name));
    }
    public function setPermission($name)
    {
        return $this->set($this->createPermission($name));
    }
    public function setRule($name)
    {
        return $this->set($this->createRule($name));
    }
    public function setChild($p, $c)
    {
        return $this->hasChild($p, $c) ?: $this->addChild($p, $c);
    }

    public function fill($roles)
    {
        $all = [];
        foreach ($roles as $role => $list) {
            $o_role = $this->setRole($role);
            foreach ($list as $wrap) {
                $items = $this->unwrapItems($wrap);
                $all = array_merge($all, $items);
                foreach ($items as $item) {
                    $o_item = $this->hasRole($item) ? $this->getRole($item) : $this->setPermission($item);
                    $this->setChild($o_role, $o_item);
                };
            };
        };
    }

    public function unwrapItems($items, $prefixes = null)
    {
        if (preg_match('/(.*?[a-z])([A-Z].*)/', $items, $m)) {
            $items = $this->unwrapItems($m[2], explode('/', $m[1]));
        } else {
            $items = explode('/', $items);
        }
        return $this->multiplyItems($items, $prefixes);
    }

    public function multiplyItems($items, $prefixes = null)
    {
        if (!is_array($items)) {
            $items = [$items];
        }
        if (!$prefixes) {
            return $items;
        }
        if ($prefixes[1] === 's') {
            $prefixes[1] = $prefixes[0] . 's';
        }
        foreach ($prefixes as $x) {
            foreach ($items as $p) {
                $res[] = $x . $p;
            }
        }
        return $res;
    }

    public function getAssignments($user)
    {
        $res = parent::getAssignments($user_id);
        $user = User::findByUsername($user);
        if ($user->type) {
            $res[$user->type] = new Assignment([
                'userId' => $user,
                'roleName' => $user->type,
            ]);
        };
        return $res;
    }
}
