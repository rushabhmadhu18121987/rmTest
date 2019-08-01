<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\VendorMaster;

/**
 * VendorMasterSearch represents the model behind the search form of `common\models\VendorMaster`.
 */
class VendorMasterSearch extends VendorMaster
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iVendorId', 'iNotiBadgeCount', 'tiAcceptPush', 'tiAcceptEmail', 'tiAcceptSMS', 'tiVerificationStatus', 'tiIsActive', 'tiIsDeleted', 'iCreatedAt', 'iUpdatedAt'], 'integer'],
            [['vEmail', 'vMobileNumber', 'vPassword', 'vProfilePic', 'vBusinessName', 'vWebsite', 'vCountry', 'vState', 'vCity', 'vEjabberedId', 'vStripeCustomerId', 'vStripeCardId', 'vSubscriptionId', 'vPasswordResetToken'], 'safe'],
            [['dbLatitude', 'dbLogitude'], 'number'],
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
        $query = VendorMaster::find();

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
            'iVendorId' => $this->iVendorId,
            'dbLatitude' => $this->dbLatitude,
            'dbLogitude' => $this->dbLogitude,
            'iNotiBadgeCount' => $this->iNotiBadgeCount,
            'tiAcceptPush' => $this->tiAcceptPush,
            'tiAcceptEmail' => $this->tiAcceptEmail,
            'tiAcceptSMS' => $this->tiAcceptSMS,
            'tiVerificationStatus' => $this->tiVerificationStatus,
            'tiIsActive' => $this->tiIsActive,
            'tiIsDeleted' => $this->tiIsDeleted,
            'iCreatedAt' => $this->iCreatedAt,
            'iUpdatedAt' => $this->iUpdatedAt,
        ]);

        $query->andFilterWhere(['like', 'vEmail', $this->vEmail])
            ->andFilterWhere(['like', 'vMobileNumber', $this->vMobileNumber])
            ->andFilterWhere(['like', 'vPassword', $this->vPassword])
            ->andFilterWhere(['like', 'vProfilePic', $this->vProfilePic])
            ->andFilterWhere(['like', 'vBusinessName', $this->vBusinessName])
            ->andFilterWhere(['like', 'vWebsite', $this->vWebsite])
            ->andFilterWhere(['like', 'vCountry', $this->vCountry])
            ->andFilterWhere(['like', 'vState', $this->vState])
            ->andFilterWhere(['like', 'vCity', $this->vCity])
            ->andFilterWhere(['like', 'vEjabberedId', $this->vEjabberedId])
            ->andFilterWhere(['like', 'vStripeCustomerId', $this->vStripeCustomerId])
            ->andFilterWhere(['like', 'vStripeCardId', $this->vStripeCardId])
            ->andFilterWhere(['like', 'vSubscriptionId', $this->vSubscriptionId])
            ->andFilterWhere(['like', 'vPasswordResetToken', $this->vPasswordResetToken]);

        return $dataProvider;
    }
}
