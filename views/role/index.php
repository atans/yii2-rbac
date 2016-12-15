<?php

use yii\helpers\Html;
use atans\rbac\Module;

/**
 * @var $dataProvider array
 * @var $this         yii\web\View
 * @var $model  atans\rbac\models\ItemSearch
 * @var $module Module
 */

$module = Module::getInstance();

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('rbac', 'Roles');

if ($module->breadcrumbs) {
    foreach ($module->breadcrumbs as $row) {
        $this->params['breadcrumbs'][] = $row;
    }
}

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="rbac-role-create">

    <p>
        <?= Html::a(Yii::t('rbac', 'Create role'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('/_menu') ?>
    <div class="box">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $model,
        'layout'       => "{items}\n{pager}",
        'columns'      => [
            [
                'attribute' => 'name',
                'header'    => Yii::t('rbac', 'Name'),
                'options'   => [
                    'style' => 'width: 20%'
                ],
            ],
            [
                'attribute' => 'description',
                'header'    => Yii::t('rbac', 'Description'),
                'options'   => [
                    'style' => 'width: 55%'
                ],
            ],
            [
                'attribute' => 'rule_name',
                'header'    => Yii::t('rbac', 'Rule name'),
                'options'   => [
                    'style' => 'width: 20%'
                ],
            ],
            [
                'class'      => ActionColumn::className(),
                'header'    => Yii::t('rbac', 'Actions'),
                'template'   => '{update} {delete}',
                'urlCreator' => function ($action, $model) {
                    return Url::to(['/rbac/role/' . $action, 'name' => $model['name']]);
                },
            ]
        ],
    ]) ?>
    </div>

</div>