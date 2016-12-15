<?php

use yii\bootstrap\Nav;

?>

<?= Nav::widget([
    'options' => [
        'class' => 'nav-tabs',
    ],
    'items' => [
        [
            'label'   => Yii::t('user', 'Users'),
            'url'     => ['/user/admin/index'],
            'visible' => isset(Yii::$app->extensions['atans/yii2-user']),
        ],
        [
            'label'   => Yii::t('user', 'Roles'),
            'url'     => ['/rbac/role/index'],
        ],
        [
            'label' => Yii::t('user', 'Permissions'),
            'url'   => ['/rbac/permission/index'],
        ],
    ],
]) ?>
