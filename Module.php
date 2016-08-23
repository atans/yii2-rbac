<?php

namespace atans\rbac;

use atans\rbac\components\DbManager;
use Yii;
use yii\filters\AccessControl;

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
    public $itemNamePattern = '/^[\w][\w-.:\/]+[\w]$/';

    /**
     * @var array
     */
    public $admins = [];

    /**
     * @var array
     */
    public $adminPermission = [];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            $app = Yii::$app;
                            $user = Yii::$app->user->identity;

                            return ($app->authManager && $this->adminPermission  ? $app->user->can($this->adminPermission) : false) || in_array($user->username, $this->admins);
                        },
                    ],
                ],
            ],
        ];
    }

}
