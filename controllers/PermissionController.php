<?php

namespace atans\rbac\controllers;

use atans\rbac\models\Permission;
use yii\rbac\Item;

class PermissionController extends ItemController
{
    /**
     * @inheritdoc
     */
    public function getItemClass()
    {
        return Permission::className();
    }

    /**
     * @inheritdoc
     */
    public function getItemType()
    {
        return Item::TYPE_PERMISSION;
    }

    /**
     * @inheritdoc
     */
    public function getItem($name)
    {
        return $this->getAuthManager()->getPermission($name);
    }
}