<?php

namespace atans\rbac;

use atans\rbac\components\DbManager;
use Yii;
use yii\base\Application;
use yii\rbac\ManagerInterface;

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

        $app = Yii::$app;




 ///       if ($this->isRbacModuleInstalled($app)) {
//            if (! $app->authManager instanceof ManagerInterface) {
//                $app->set('authManager', [
//                    'class' => DbManager::className(),
//                ]);
//            }
        }
 //   }


}
