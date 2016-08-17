<?php

/**
 * @var $this  yii\web\View
 * @var $model atans\rbac\models\Role
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'rule') ?>

    <?= Html::submitButton(Yii::t('rbac', 'Save'), ['class' => 'btn btn-success']) ?>

<?php ActiveForm::end() ?>