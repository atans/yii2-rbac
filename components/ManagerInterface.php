<?php

namespace atans\rbac\components;

use yii\rbac\ManagerInterface as BaseManagerInterface;

interface ManagerInterface extends BaseManagerInterface
{
    /**
     * Get items by type and exclude items
     *
     * @param  int|null $type
     * @param  array $excludeItems
     * @return array
     */
    public function getItems($type = null, $excludeItems = []);

    /**
     * Get item by user id
     *
     * @param  integer $userId
     * @return array
     */
    public function getItemsByUser($userId);

    /**
     * Get item
     *
     * @param  string $name
     * @return \yii\rbac\Item
     */
    public function getItem($name);
}