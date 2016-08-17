<?php

/**
 * @var $dataProvider array
 * @var $this         yii\web\View
 * @var $model  atans\rbac\models\ItemSearch
 */

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('rbac', 'Permissions');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="rbac-permission-index">

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
            'template'   => '{update} {delete}',
            'urlCreator' => function ($action, $model) {
                return Url::to(['/rbac/permission/' . $action, 'name' => $model['name']]);
            },
            'options'   => [
                'style' => 'width: 5%'
            ],
        ]
    ],
]) ?>

</div>