<?php

namespace atans\rbac;

use atans\rbac\components\DbManager;
use Yii;

/**
 * rbac module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * [
     *   ['label' => 'User management', 'url' => ['user/index']]
     * ]
     *
     * @var array
     */
    public $breadcrumbs = [];

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'atans\rbac\controllers';

    /**
     * @var string
     */
    public $itemNamePattern = '/^[\w][\w-.:]+[\w]$/';


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }
}
