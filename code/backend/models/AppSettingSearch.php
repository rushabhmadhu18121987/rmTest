<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AppSetting;

/**
 * AppSettingSearch represents the model behind the search form of `backend\models\AppSetting`.
 */
class AppSettingSearch extends AppSetting
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iAppSettingId', 'iCreatedAt', 'iUpdatedAt'], 'integer'],
            [['vSettingLabel', 'vAppSettingKey', 'eAppSettingDatatype', 'vAppSettingValue', 'vAppSettingDesc'], 'safe'],
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
        $query = AppSetting::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['iAppSettingId' => SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'iAppSettingId' => $this->iAppSettingId,
            'iCreatedAt' => $this->iCreatedAt,
            'iUpdatedAt' => $this->iUpdatedAt,
        ]);

        $query->andFilterWhere(['like', 'vSettingLabel', $this->vSettingLabel])
            ->andFilterWhere(['like', 'vAppSettingKey', $this->vAppSettingKey])
            ->andFilterWhere(['like', 'eAppSettingDatatype', $this->eAppSettingDatatype])
            ->andFilterWhere(['like', 'vAppSettingValue', $this->vAppSettingValue])
            ->andFilterWhere(['like', 'vAppSettingDesc', $this->vAppSettingDesc]);

        return $dataProvider;
    }
}
