<?php

namespace atans\rbac\controllers;

use atans\rbac\components\ManagerInterface;
use atans\rbac\models\ItemSearch;
use Yii;
use yii\web\Response;
use yii\rbac\Item;
use yii\web\Controller;
use yii\widgets\ActiveForm;

abstract class ItemController extends Controller
{
    /**
     * @var ManagerInterface
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
     * @return \yii\rbac\Role|\yii\rbac\Permission
     */
    abstract public function getItem($name);


    public function actionIndex()
    {
        $model = new ItemSearch($this->getItemType());

        return $this->render('index', [
            'model'  => $model,
            'dataProvider' => $model->search(Yii::$app->request->get()),
        ]);
    }

    public function actionCreate()
    {
        /** @var $model \atans\rbac\models\Role|\atans\rbac\models\Permission */
        $model = Yii::createObject([
            'class'    => $this->getItemClass(),
            'scenario' => 'create',
        ]);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

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
            'class'    => $this->getItemClass(),
            'scenario' => 'update',
            'item'     => $item,
        ]);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

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
     * @return ManagerInterface
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
     * @param  ManagerInterface $authManager
     * @return $this
     */
    public function setAuthManager(ManagerInterface $authManager)
    {
        $this->authManager = $authManager;
        return $this;
    }
}