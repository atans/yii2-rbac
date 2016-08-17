<?php

namespace atans\rbac\controllers;

use atans\rbac\models\Role;
use yii\rbac\Item;
use yii\web\NotFoundHttpException;

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
        $role = $this->getAuthManager()->getRole($name);

        if ($role instanceof \yii\rbac\Role) {
            return $role;
        }

        throw new NotFoundHttpException;
    }
}