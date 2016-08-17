<?php

namespace atans\rbac;

/**
 * rbac module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'atans\rbac\controllers';

    public $itemNamePattern = '/^[\w][\w-.:]+[\w]$/';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
