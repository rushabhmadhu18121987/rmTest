<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ContactUs;

/**
 * ContactUsSearch represents the model behind the search form of `backend\models\ContactUs`.
 */
class ContactUsSearch extends ContactUs {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['iContactId', 'iUserId', 'tiStatus', 'iCreatedAt'], 'integer'],
            [['vEmail', 'txMessage', 'vName'], 'safe'],
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
        $query = ContactUs::find()->alias('cu')
                ->select(['cu.*','um.vName'])
                ->join('JOIN', 'user_master um','um.iUserId = cu.iUserId AND um.tiIsDeleted = 0');

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
            'cu.iContactId' => $this->iContactId,
            'cu.iUserId' => $this->iUserId,
            'cu.tiStatus' => $this->tiStatus,
            'cu.iCreatedAt' => $this->iCreatedAt,
        ]);

        $query->andFilterWhere(['like', 'cu.vEmail', $this->vEmail])
                ->andFilterWhere(['like', 'cu.txMessage', $this->txMessage])
                ->andFilterWhere(['like', 'um.vName', $this->vName]);

        return $dataProvider;
    }

}
