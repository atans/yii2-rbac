<?php

use yii\helpers\Html;

/**
 * @var $dataProvider array
 * @var $model  atans\rbac\models\ItemSearch
 * @var $this   yii\web\View
 */

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('rbac', 'Roles');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="rbac-role-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a(Yii::t('app', 'Create role'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
                'header'    => Yii::t('rbac', 'Actions'),
                'class'      => ActionColumn::className(),
                'template'   => '{update} {delete}',
                'urlCreator' => function ($action, $model) {
                    return Url::to(['/rbac/role/' . $action, 'name' => $model['name']]);
                },
            ]
        ],
    ]) ?>

</div>