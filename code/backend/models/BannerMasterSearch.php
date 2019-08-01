<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\BannerMaster;

/**
 * BannerMasterSearch represents the model behind the search form of `backend\models\BannerMaster`.
 */
class BannerMasterSearch extends BannerMaster {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['iBannerId', 'tiBannerType', 'tiOrderNo', 'tiIsActive', 'tiIsDeleted', 'iCreatedAt', 'iUpdatedAt'], 'integer'],
            [['vTitle', 'vBannerPic'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
    public function search($params) {
        $query = BannerMaster::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['iBannerId' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'iBannerId' => $this->iBannerId,
            'tiBannerType' => $this->tiBannerType,
            'tiOrderNo' => $this->tiOrderNo,
            'tiIsActive' => $this->tiIsActive,
            'tiIsDeleted' => $this->tiIsDeleted,
            'iCreatedAt' => $this->iCreatedAt,
            'iUpdatedAt' => $this->iUpdatedAt,
        ]);

        $query->andFilterWhere(['like', 'vTitle', $this->vTitle])
                ->andFilterWhere(['like', 'vBannerPic', $this->vBannerPic]);

        return $dataProvider;
    }

}
