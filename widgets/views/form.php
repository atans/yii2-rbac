<?php


use atans\rbac\models\Assignment;
use kartik\select2\Select2;
use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $model Assignment
 */

?>

<?php if ($model->updated): ?>

    <?= Alert::widget([
        'options' => [
            'class' => 'alert-success'
        ],
        'body' => Yii::t('rbac', 'Assignments have been updated'),
    ]) ?>

<?php endif ?>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation'   => false,
]) ?>

<?= Html::activeHiddenInput($model, 'user_id') ?>

<?= $form->field($model, 'items')->checkboxList($model->getAvailableItems()) ?>

<?= Html::submitButton(Yii::t('rbac', 'Submit'), ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end() ?>

