<?php

namespace atans\rbac\validators;

use Yii;
use yii\rbac\Item;
use yii\rbac\ManagerInterface;
use yii\validators\Validator;

class ChildrenValidator extends Validator
{
    /**
     * @var ManagerInterface|\yii\rbac\DbManager
     */
    protected $authManager;

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        if (! is_array($value)) {
            return [Yii::t('rbac', 'Invalid item children'), []];
        }

        $authManager = $this->getAuthManager();

        foreach ($value as $name) {
            if (! $authManager->getItem($name) instanceof Item) {
                return [Yii::t('rbac', 'Item "{0}" does not exits', [$name]), []];
            }
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
    public function setAuthManager(ManagerInterface $authManager)
    {
        $this->authManager = $authManager;
        return $this;
    }
}