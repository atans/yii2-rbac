<?php

namespace atans\rbac\models;

use yii\rbac\ManagerInterface;
use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\db\Query;

class ItemSearch extends Model
{
    public $name;
    public $description;

    public $rule_name;

    /**
     * @var ManagerInterface|\yii\rbac\DbManager
     */
    protected $authManager;

    protected $type;

    /**
     * Constructor
     *
     * @param string $type
     * @param array $config
     */
    public function __construct($type, $config = [])
    {
        parent::__construct($config);
        $this->type = $type;
    }

    public function scenarios()
    {
        return [
          'default' => ['name', 'description', 'rule_name'],  
        ];
    }

    /**
     * Search items
     *
     * @param array $params
     * @return object[]
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params = [])
    {
        $dataProvider =  Yii::createObject(ArrayDataProvider::className());

        $query = (new Query())->select(['name', 'description', 'rule_name'])
            ->from($this->getAuthManager()->itemTable)
            ->andWhere(['type' => $this->type]);


        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'rule_name', $this->rule_name]);
        }

        $dataProvider->allModels = $query->all($this->getAuthManager()->db);

        return $dataProvider;
    }


    /**
     * Get authManager
     *
     * @return ManagerInterface|\yii\rbac\DbManager
     */
    public function getAuthManager()
    {
        if (! $this->authManager instanceof ManagerInterface) {
            $this->setAuthManager(Yii::$app->authManager);
        }
        return $this->authManager;
    }

    /**
     * Set authManager
     *
     * @param  ManagerInterface|\yii\rbac\DbManager $authManager
     * @return ItemSearch
     */
    public function setAuthManager(ManagerInterface $authManager)
    {
        $this->authManager = $authManager;
        return $this;
    }

}