<?php

namespace atans\rbac\models;

use atans\rbac\Module;
use atans\rbac\validators\ChildrenValidator;
use ReflectionClass;
use Yii;
use yii\base\Model;
use yii\rbac\ManagerInterface;

abstract class Item extends Model
{
    public $name;
    public $description;
    public $rule;
    public $children = [];

    /**
     * @var \yii\rbac\Role|\yii\rbac\Permission
     */
    public $item;

    /**
     * @var ManagerInterface|\yii\rbac\DbManager
     */
    protected $authManager;

    /**
     * @return array
     */
    abstract public function getUnassignedItems();

    /**
     * Create item
     *
     * @param  string $name
     * @return \yii\rbac\Item
     */
    abstract public function createItem($name);

    public function init()
    {
        parent::init();

        if ($this->item instanceof \yii\rbac\Item) {
            $this->name        = $this->item->name;
            $this->description = $this->item->description;
            $this->children    = array_keys($this->getAuthManager()->getChildren($this->item->name));
            $this->rule        = $this->getAuthManager()->getRole($this->item->ruleName);
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        /* @var $module Module */
        $module = Module::getInstance();

        return [
            ['name', 'required'],
            ['name', 'match', 'pattern' => $module->itemNamePattern],
            [['name', 'description', 'rule'], 'trim'],
            ['name', function () {
                if (empty($this->getAuthManager()->getItem($this->name))) {
                    $this->addError('name', Yii::t('rbac', 'Item name already exists'));
                }
            }, 'when' => function () {
                return $this->scenario == 'create' || $this->item->name != $this->name;
            }],
            ['children', ChildrenValidator::className()],
            ['rule', function () {
                try {
                    $class = new ReflectionClass($this->rule);
                } catch (\Exception $e) {
                    $this->addError('rule', Yii::t('rbac', 'Rule class "{0}" does not exist', $this->rule));

                    return;
                }

                if (! $class->isInstantiable()) {
                    $this->addError('rule', Yii::t('rbac', 'Rule class can not be instantiated'));
                }

                if (! $class->isSubclassOf('\yii\rbac\Rule')) {
                    $this->addError('rule', Yii::t('rbac', 'Rule class must extend "yii\\rbac\\Rule"'));
                }
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name'        => Yii::t('rbac', 'Name'),
            'description' => Yii::t('rbac', 'Description'),
            'children'    => Yii::t('rbac', 'Children'),
            'rule'        => Yii::t('rbac', 'Rule'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'create' => ['name', 'description', 'children', 'rule'],
            'update' => ['name', 'description', 'children', 'rule'],
        ];
    }

    /**
     * Saves item.
     *
     * @return bool
     */
    public function save()
    {
        if (! $this->validate()) {
            return null;
        }

        $authManager = $this->getAuthManager();

        $isNewItem = $this->item === null;
        $oldName   = $this->item->name;
        if ($isNewItem) {
            $this->item = $this->createItem($this->name);
        }

        $this->item->name        = $this->name;
        $this->item->description = $this->description;

        if (! empty($this->rule)) {
            /* @var $rule \yii\rbac\rule */
            $rule = Yii::createObject($this->rule);
            if (! $authManager->getRule($rule->name)) {
                $authManager->add($rule);
            }

            $this->item->ruleName = $rule->name;
        } else {
            $this->item->ruleName = null;
        }

        if ($isNewItem) {
            Yii::$app->session->setFlash('success', Yii::t('rbac', 'Item has been created'));
            $authManager->add($this->item);
        } else {
            Yii::$app->session->setFlash('success', Yii::t('rbac', 'Item has been updated'));
            $authManager->update($oldName, $this->item);
        }

        $this->updateChildren();

        return true;
    }

    protected function updateChildren()
    {
        $authManager   = $this->getAuthManager();
        $children      = $authManager->getChildren($this->item->name);
        $childrenNames = array_keys($children);

        if (is_array($this->children)) {
            foreach (array_diff($childrenNames, $this->children) as $item) {
                $authManager->removeChild($this->item, $children[$item]);
            }

            foreach (array_diff($this->children, $childrenNames) as $item) {
                $authManager->addChild($this->item, $authManager->getItem($item));
            }
        } else {
            $authManager->removeChildren($this->item);
        }
    }

    /**
     * Get authManager
     *
     * @return ManagerInterface|\yii\rbac\DbManager
     */
    public function getAuthManager()
    {
        if (! $this->authManager instanceof ManagerInterface) {
            $this->setAuthManager(Yii::$app->authManager);
        }

        return $this->authManager;
    }

    /**
     * Set authManager
     *
     * @param  ManagerInterface|\yii\rbac\DbManager $authManager
     * @return $this
     */
    public function setAuthManager($authManager)
    {
        $this->authManager = $authManager;

        return $this;
    }
}
