<?php

/**
 * @var $this  yii\web\View
 * @var $model atans\rbac\models\Role
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation'   => true,
]) ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'rule') ?>

    <?= $form->field($model, 'children')->checkboxList($model->getUnassignedItems()) ?>

    <?= Html::submitButton(Yii::t('rbac', 'Submit'), ['class' => 'btn btn-success']) ?>

<?php ActiveForm::end() ?>