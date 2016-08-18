<?php

namespace atans\rbac;

use atans\rbac\components\DbManager;
use atans\rbac\components\ManagerInterface;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\i18n\PhpMessageSource;

class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if (! isset($app->i18n->translations['rbac*'])) {
            $app->i18n->translations['rbac*'] = [
                'class'    => PhpMessageSource::className(),
                'basePath' => __DIR__ . '/messages',
            ];
        }

        if ($this->isRbacModuleInstalled($app)) {
            if (! $app->authManager instanceof ManagerInterface) {
                $app->set('authManager', [
                    'class' => DbManager::className(),
                ]);
            }
        }
    }

    public function isRbacModuleInstalled(Application $app)
    {
        return $app->hasModule('rbac') && $app->getModule('rbac') instanceof Module;
    }
}
