<?php

namespace atans\rbac;
use yii\base\BootstrapInterface;

/**
 * rbac module definition class
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'atans\rbac\controllers';

    public $itemNamePattern = '/^[\w][\w-.:]+[\w]$/';

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if (! isset($app->get('i18n')->translations['rbac*'])) {
            $app->get('i18n')->translations['rbac*'] = [
                'class'    => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
            ];
        }
    }


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
