<?php

namespace atans\rbac\widgets;

use atans\rbac\models\Assignment;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;

class Assignments extends Widget
{
    public $user_id;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (is_null($this->user_id)) {
            throw new InvalidConfigException(sprintf(
                'You should set %s::user_id',
                self::className()
            ));
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        /* @var $model Assignment */
        $model = Yii::createObject([
            'class' => Assignment::className(),
            'user_id' => $this->user_id
        ]);

        if ($model->load(Yii::$app->request->post())) {
            $model->update();
        }

        return $this->render('form', [
            'model' => $model,
        ]);
    }

}