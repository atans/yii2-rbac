<?php

namespace atans\rbac\controllers;

use Yii;
use yii\rbac\Item;
use yii\web\Controller;
use yii\rbac\ManagerInterface as AuthManager;

abstract class ItemController extends Controller
{

    /**
     * @var AuthManager
     */
    protected $authManager;

    /**
     * Get item class
     *
     * @return string
     */
    abstract public function getItemClass();

    /**
     * Get item type
     *
     * @return int
     */
    abstract public function getItemType();

    /**
     * Get item
     *
     * @param $name
     * @return \yii\rbac\Rule|\yii\rbac\Permission
     */
    abstract public function getItem($name);


    public function actionIndex()
    {
        $model = new ItemSearch($this->type);

        return $this->render('index', [
            'filterModel'  => $model,
            'dataProvider' => $model->search(Yii::$app->request->get()),
        ]);
    }

    public function actionCreate()
    {
        /** @var $model \atans\rbac\models\Role|\atans\rbac\models\Permission */
        $model = Yii::createObject([
            'class'    => $this->modelClass,
            'scenario' => 'create',
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($name)
    {
        /** @var $model \atans\rbac\models\Role|\atans\rbac\models\Permission */
        $item  = $this->getItem($name);
        $model = \Yii::createObject([
            'class'    => $this->modelClass,
            'scenario' => 'update',
            'item'     => $item,
        ]);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($name)
    {
        $item = $this->getItem($name);

        if (! $item instanceof Item) {
            Yii::$app->session->setFlash('warning', Yii::t('rbac', 'Item "{0}" does not exist', $name));

            return $this->redirect(['index']);
        }

        $this->getAuthManager()->remove($item);

        Yii::$app->session->setFlash('success', Yii::t('rbac', 'Item "{0}" was successfully deleted', $name));

        return $this->redirect(['index']);
    }

    /**
     * Get authManager
     *
     * @return AuthManager
     */
    public function getAuthManager()
    {
        if (! $this->authManager instanceof AuthManager) {
            $this->setAuthManager(Yii::$app->authManager);
        }

        return $this->authManager;
    }

    /**
     * Set authManager
     *
     * @param  AuthManager $authManager
     * @return $this
     */
    public function setAuthManager(AuthManager $authManager)
    {
        $this->authManager = $authManager;
        return $this;
    }
}