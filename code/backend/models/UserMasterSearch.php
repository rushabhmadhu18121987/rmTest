<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UserMaster;

/**
 * UserMasterSearch represents the model behind the search form of `backend\models\UserMaster`.
 */
class UserMasterSearch extends UserMaster {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['iUserId', 'iOTPExpireAt', 'iNotiBadgeCount', 'iCreatedAt', 'iUpdatedAt'], 'integer'],
            [['vName', 'vEmail', 'vISDCode', 'vMobileNumber', 'vPassword', 'vProfilePic', 'tiUserType', 'tiIsSocialLogin', 'vOTP', 'tiIsMobileVerified', 'vPasswordResetToken', 'tiAcceptPush', 'tiIsActive', 'tiIsDeleted'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = UserMaster::find()->where(['user_master.tiIsDeleted' => 0, 'user_master.tiUserType' => 1,]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['iUserId' => SORT_DESC]]
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
            'iOTPExpireAt' => $this->iOTPExpireAt,
            'iNotiBadgeCount' => $this->iNotiBadgeCount,
            'iCreatedAt' => $this->iCreatedAt,
            'iUpdatedAt' => $this->iUpdatedAt,
        ]);

        $query->andFilterWhere(['like', 'vName', $this->vName])
                ->andFilterWhere(['like', 'vEmail', $this->vEmail])
                ->andFilterWhere(['like', 'vProfilePic', $this->vProfilePic])
                ->andFilterWhere(['like', 'tiUserType', $this->tiUserType])
                ->andFilterWhere(['like', 'tiIsSocialLogin', $this->tiIsSocialLogin])
                ->andFilterWhere(['like', 'tiIsMobileVerified', $this->tiIsMobileVerified])
                ->andFilterWhere(['like', 'vPasswordResetToken', $this->vPasswordResetToken])
                ->andFilterWhere(['like', 'tiIsActive', $this->tiIsActive])
                ->andFilterWhere(['like', 'tiIsDeleted', $this->tiIsDeleted]);

        if($this->vMobileNumber !== NULL){
            $query->andHaving(['like', 'CONCAT(user_master.vISDCode," ",user_master.vMobileNumber)', $this->vMobileNumber??'']);
        }
        return $dataProvider;
    }

}
