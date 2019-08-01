<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CategoryMaster;

/**
 * CategoryMasterSearch represents the model behind the search form of `backend\models\CategoryMaster`.
 */
class CategoryMasterSearch extends CategoryMaster
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iCategoryId', 'iParentCategoryId', 'tiOrderNo', 'tiIsActive', 'tiIsDeleted', 'iCreatedAt', 'iUpdatedAt'], 'integer'],
            [['vCategoryName', 'vCategoryIcon'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CategoryMaster::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'iCategoryId' => $this->iCategoryId,
            'iParentCategoryId' => $this->iParentCategoryId,
            'tiOrderNo' => $this->tiOrderNo,
            'tiIsActive' => $this->tiIsActive,
            'tiIsDeleted' => $this->tiIsDeleted,
            'iCreatedAt' => $this->iCreatedAt,
            'iUpdatedAt' => $this->iUpdatedAt,
        ]);

        $query->andFilterWhere(['like', 'vCategoryName', $this->vCategoryName])
            ->andFilterWhere(['like', 'vCategoryIcon', $this->vCategoryIcon]);

        return $dataProvider;
    }
}
