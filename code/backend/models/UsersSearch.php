<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Users;

/**
 * UsersSearch represents the model behind the search form of `backend\models\Users`.
 */
class UsersSearch extends Users {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['iUserId', 'tiLanguage', 'tiDeviceType', 'tiAcceptPush', 'iCreatedAt', 'tiIsActive', 'tiIsDelete'], 'integer'],
            [['vAuthKey', 'vRecipientId', 'vEmail', 'vPassword', 'vFacebookId', 'vGoogleId', 'vFirstName', 'vLastName', 'vProfilePic', 'vDeviceToken', 'vPasswordResetToken'], 'safe'],
            [['fTotBalance'], 'number'],
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
        $query = Users::find();

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
            /*    'iUserId' => $this->iUserId, */
            'tiLanguage' => $this->tiLanguage,
            'fTotBalance' => $this->fTotBalance,
            'tiDeviceType' => $this->tiDeviceType,
            'tiAcceptPush' => $this->tiAcceptPush,
            'iCreatedAt' => $this->iCreatedAt,
            'tiIsActive' => $this->tiIsActive,
            'tiIsDelete' => $this->tiIsDelete,
        ]);

        $query->andFilterWhere(['like', 'vAuthKey', $this->vAuthKey])
                ->andFilterWhere(['like', 'vRecipientId', $this->vRecipientId])
                ->andFilterWhere(['like', 'vEmail', $this->vEmail])
                ->andFilterWhere(['like', 'vPassword', $this->vPassword])
                ->andFilterWhere(['like', 'vFacebookId', $this->vFacebookId])
                ->andFilterWhere(['like', 'vGoogleId', $this->vGoogleId])
                ->andFilterWhere(['like', 'vFirstName', $this->vFirstName])
                ->andFilterWhere(['like', 'vLastName', $this->vLastName])
                ->andFilterWhere(['like', 'vProfilePic', $this->vProfilePic])
                ->andFilterWhere(['like', 'vDeviceToken', $this->vDeviceToken])
                ->andFilterWhere(['like', 'vPasswordResetToken', $this->vPasswordResetToken]);

        return $dataProvider;
    }

}
