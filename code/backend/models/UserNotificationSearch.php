<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UserNotification;

/**
 * UserNotificationSearch represents the model behind the search form of `backend\models\UserNotification`.
 */
class UserNotificationSearch extends UserNotification
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iUserNotificationId', 'iUserId', 'iVehicleId', 'iParkingSpotId', 'iParkingLotId', 'iUserBookingId', 'tiNotificationType', 'tiIsActive', 'tiIsRead', 'tiIsDeleted', 'iCreatedAt', 'iUpdatedAt'], 'integer'],
            [['vNotificationTitle', 'vNotificationDesc'], 'safe'],
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
        $query = UserNotification::find();

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
            'iUserNotificationId' => $this->iUserNotificationId,
            'iUserId' => $this->iUserId,
            'iVehicleId' => $this->iVehicleId,
            'iParkingSpotId' => $this->iParkingSpotId,
            'iParkingLotId' => $this->iParkingLotId,
            'iUserBookingId' => $this->iUserBookingId,
            'tiNotificationType' => $this->tiNotificationType,
            'tiIsActive' => $this->tiIsActive,
            'tiIsRead' => $this->tiIsRead,
            'tiIsDeleted' => $this->tiIsDeleted,
            'iCreatedAt' => $this->iCreatedAt,
            'iUpdatedAt' => $this->iUpdatedAt,
        ]);

        $query->andFilterWhere(['like', 'vNotificationTitle', $this->vNotificationTitle])
            ->andFilterWhere(['like', 'vNotificationDesc', $this->vNotificationDesc]);

        return $dataProvider;
    }
}
