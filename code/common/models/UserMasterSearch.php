<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserMaster;

/**
 * UserMasterSearch represents the model behind the search form of `common\models\UserMaster`.
 */
class UserMasterSearch extends UserMaster
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iUserId', 'tiIsSocialLogin', 'iOTPExpireAt', 'tiIsMobileVerified', 'iNotiBadgeCount', 'tiAcceptPush', 'tiAcceptEmail', 'tiAcceptSMS', 'tiIsActive', 'tiIsDeleted', 'iCreatedAt', 'iUpdatedAt'], 'integer'],
            [['vFirstName', 'vLastName', 'vEmail', 'vMobileNumber', 'vPassword', 'vProfilePic', 'vOTP', 'vEjabberedId', 'vPasswordResetToken'], 'safe'],
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
        $query = UserMaster::find();

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
            'iUserId' => $this->iUserId,
            'tiIsSocialLogin' => $this->tiIsSocialLogin,
            'dbLatitude' => $this->dbLatitude,
            'dbLogitude' => $this->dbLogitude,
            'iOTPExpireAt' => $this->iOTPExpireAt,
            'tiIsMobileVerified' => $this->tiIsMobileVerified,
            'iNotiBadgeCount' => $this->iNotiBadgeCount,
            'tiAcceptPush' => $this->tiAcceptPush,
            'tiAcceptEmail' => $this->tiAcceptEmail,
            'tiAcceptSMS' => $this->tiAcceptSMS,
            'tiIsActive' => $this->tiIsActive,
            'tiIsDeleted' => $this->tiIsDeleted,
            'iCreatedAt' => $this->iCreatedAt,
            'iUpdatedAt' => $this->iUpdatedAt,
        ]);

        $query->andFilterWhere(['like', 'vFirstName', $this->vFirstName])
            ->andFilterWhere(['like', 'vLastName', $this->vLastName])
            ->andFilterWhere(['like', 'vEmail', $this->vEmail])
            ->andFilterWhere(['like', 'vMobileNumber', $this->vMobileNumber])
            ->andFilterWhere(['like', 'vPassword', $this->vPassword])
            ->andFilterWhere(['like', 'vProfilePic', $this->vProfilePic])
            ->andFilterWhere(['like', 'vOTP', $this->vOTP])
            ->andFilterWhere(['like', 'vEjabberedId', $this->vEjabberedId])
            ->andFilterWhere(['like', 'vPasswordResetToken', $this->vPasswordResetToken]);

        return $dataProvider;
    }
}
