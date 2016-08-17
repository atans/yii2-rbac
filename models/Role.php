<?php

namespace atans\rbac\models;

use yii\helpers\ArrayHelper;

class Role extends Item
{
    /**
     * @inheritdoc
     */
    public function createItem($name)
    {
        return $this->getAuthManager()->createRole($name);
    }

    /**
     * @inheritdoc
     */
    public function getUnassignedItems()
    {
        return ArrayHelper::map(
            $this->getAuthManager()->getItems(null, $this->item !== null ? [$this->item->name] : []),
            'name',
            function ($item) {
                return empty($item->description) ? $item->name : $item->name . ' (' . $item->description . ')';
            }
        );
    }
}
