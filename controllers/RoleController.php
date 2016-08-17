<?php

namespace atans\rbac\models;

use yii\rbac\Item;

class RoleController extends ItemController
{
    /**
     * @inheritdoc
     */
    public function getItemClass()
    {
        return Role::className();
    }

    /**
     * @inheritdoc
     */
    public function getItemType()
    {
        return Item::TYPE_ROLE;
    }

    /**
     * @inheritdoc
     */
    public function getItem($name)
    {
        return $this->getAuthManager()->getRole($name);
    }
}