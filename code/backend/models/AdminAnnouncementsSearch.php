<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AdminAnnouncements;

/**
 * AdminAnnouncementsSearch represents the model behind the search form of `backend\models\AdminAnnouncements`.
 */
class AdminAnnouncementsSearch extends AdminAnnouncements {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['iAnnouncementId', 'tiNotificationReceiver', 'iCreatedAt', 'tiIsDeleted'], 'integer'],
            [['vSubject', 'vMessage'], 'safe'],
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
        $query = AdminAnnouncements::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['iAnnouncementId' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'iAnnouncementId' => $this->iAnnouncementId,
            'tiNotificationReceiver' => $this->tiNotificationReceiver,
            'iCreatedAt' => $this->iCreatedAt,
            'tiIsDeleted' => $this->tiIsDeleted,
        ]);

        $query->andFilterWhere(['like', 'vSubject', $this->vSubject])
                ->andFilterWhere(['like', 'vMessage', $this->vMessage]);

        return $dataProvider;
    }

}
