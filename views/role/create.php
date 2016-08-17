<?php

/**
 * @var $model atans\rbac\models\Role
 * @var $this  yii\web\View
 */

$this->title = Yii::t('rbac', 'Create role');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="rbac-role-create">

<?= $this->render('_form', [
    'model' => $model,
]) ?>

</div>
