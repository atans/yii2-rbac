<?php

/**
 * @var $model atans\rbac\models\Role
 * @var $this  yii\web\View
 */

$this->title = Yii::t('rbac', 'Update role');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="rbac-role-update">

<?= $this->render('_form', [
    'model' => $model,
]) ?>

</div>
