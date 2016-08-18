<?php

use yii\helpers\Html;
use atans\rbac\Module;

/**
 * @var $model atans\rbac\models\Role
 * @var $this  yii\web\View
 * @var $module Module
 */

$module = Module::getInstance();

$this->title = Yii::t('rbac', 'Update role');

if ($module->breadcrumbs) {
    foreach ($module->breadcrumbs as $row) {
        $this->params['breadcrumbs'][] = $row;
    }
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="rbac-role-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
