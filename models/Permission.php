<?php

namespace atans\rbac\models;

use yii\helpers\ArrayHelper;
use yii\rbac\Item as RbacItem;

class Permission extends Item
{
    /**
     * @inheritdoc
     */
    public function createItem($name)
    {
        return $this->getAuthManager()->createPermission($name);
    }

    /**
     * @inheritdoc
     */
    public function getUnassignedItems()
    {
        return ArrayHelper::map(
            $this->getAuthManager()->getItems(RbacItem::TYPE_PERMISSION, $this->item !== null ? [$this->item->name] : []),
            'name',
            function ($item) {
                return empty($item->description) ? $item->name : $item->name . ' (' . $item->description . ')';
            }
        );
    }
}
