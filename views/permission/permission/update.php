<?php

/**
 * @var $model atans\rbac\models\Role
 * @var $this  yii\web\View
 */

$this->title = Yii::t('rbac', 'Update permission');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="rbac-permission-update">

<?= $this->render('_form', [
    'model' => $model,
]) ?>

</div>
