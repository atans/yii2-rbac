<?php

namespace atnas\rbac\models;

use atans\rbac\validators\ChildrenValidator;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class Assignment extends Model
{
    public $items = [];

    public $user_id;

    public $updated = false;

    /**
     * @var \atans\rbac\components\DbManager
     */
    public $manager;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->manager = Yii::$app->authManager;

        if (is_null($this->user_id)) {
            throw new InvalidConfigException(sprintf('You should set %s::user_id', self::className()));
        }

        $this->items = array_keys($this->manager->getItemsByUser($this->user_id));
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            'items' => Yii::t('rbac', 'Items'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['user_id', 'required'],
            ['user_id', 'integer'],

            ['items', ChildrenValidator::className()],
        ];
    }

    public function update()
    {
        if (! $this->validate()) {
            return null;
        }

        if (! is_array($this->items)) {
            $this->items = [];
        }

        $assignedItems = $this->manager->getItemsByUser($this->user_id);
        $assignedItemNames = array_keys($assignedItems);

        foreach (array_diff($assignedItemNames, $this->items) as $name) {
            $this->manager->revoke($assignedItems[$name], $this->user_id);
        }

        foreach (array_diff($this->items, $assignedItemNames) as $name) {
            $this->manager->assign($this->manager->getItem($name), $this->user_id);
        }

        $this->updated = true;

        return true;
    }

    /**
     * @return array
     */
    public function getAvailableItems()
    {
        return ArrayHelper::map($this->manager->getItems(), 'name', function($item){
            return (empty($item->description) ? $item->name : $item->name . '(' . $item->description . ')');
        });
    }

}