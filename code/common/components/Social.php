<?php

namespace common\components;

use yii;
use yii\base\Component;
use api\modules\v1\models\UserSocialAccount;
use api\modules\v1\models\UserMaster;
use api\modules\v1\models\response\ErrorResponse;
use api\modules\v1\models\response\SuccessResponse;
use api\modules\v1\models\response\UserMasterResponse;
use api\modules\v1\models\response\UserMasterResponseData;
use api\modules\v1\models\response\TransactionResponse;
use yii\authclient\OAuthToken; // Added By Vijay Panchal 

class Social extends Component {

    /**
     * Get Social Data
     * @param string $social_type
     * @param \yii\db\Transaction $transaction
     * @param string $access_token
     * @return \api\modules\v1\models\response\TransactionResponse
     * @author Yagnesh Panchal <vijayp.spaceo@gmail.com>
     */
    public function getSocialId($social_type, $transaction, $access_token) {
        try {
            switch ($social_type) {
                //Start Facebook Authentication
                case 'facebook':
                    $url = Yii::$app->params['FB_URL'] . '?access_token=' . $access_token . '&fields=' . Yii::$app->params['FB_RETURN_FIELDS'];

                    $result = $this->send_request($url);
                    if (!isset($result->error)) {
                        $params['vSocialId'] = $result->id;
                        $params['vName'] = $result->first_name ?? NULL . '' . $result->last_name ?? NULL;
                        $params['vEmail'] = $result->email ?? NULL;
                        $params['vImageUrl'] = $result->picture->data->url;
                        $params['tiSocialType'] = "1";
                        $params['tiIsSocialLogin'] = "1";
                        $params['tiIsActive'] = "1";
                        $params['tiUserType'] = "1";
                        return $this->socialIdFromData($params, $transaction);
                    } else {
                        return ErrorResponse::withData(BAD_REQUEST, $result->error->message);
                    }
                    break;
                //End Facebook Authentication
                //Start Google Authentication
                case 'google':
                    $url = Yii::$app->params['GOOGLE_URL'] . '&access_token=' . $access_token;
                    $result = $this->send_request($url);
                    if (!isset($result->error)) {
                        $resource = explode('/', $result->resourceName);
                        $params['vSocialId'] = $resource[1];
                        $params['vName'] = $result->names[0]->givenName ?? NULL . ' ' . $result->names[0]->familyName ?? NULL;
                        $params['vLastName'] = !empty($result->names[0]->familyName) ? $result->names[0]->familyName : "";
                        $params['vEmail'] = !empty($result->emailAddresses[0]->value) ? $result->emailAddresses[0]->value : "";
                        $params['vImageUrl'] = $result->photos[0]->url;
                        $params['tiSocialType'] = "2";
                        $params['tiIsSocialLogin'] = "1";
                        $params['tiIsActive'] = "1";
                        $params['tiUserType'] = "1";
                        return $this->socialIdFromData($params, $transaction);
                    } else {
                        return ErrorResponse::withData(BAD_REQUEST, $result->error->message);
                    }
                    break;
                //End Google Authentication

                default :
                    return ErrorResponse::withData(BAD_REQUEST, 'Invalid Social type');
                    break;
            }
        } catch (Exception $ex) {
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    /**
     * Send CURL Request
     * @param type $url
     * @return type
     * @author Yagnesh Panchal <vijayp.spaceo@gmail.com>
     */
    protected function send_request($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result = json_decode($result);
    }

    /**
     * 
     * @param Array $params
     * @param \yii\db\Transaction $transaction
     * @return \api\modules\v1\models\response\TransactionResponse
     * @author Yagnesh Panchal <vijayp.spaceo@gmail.com>
     */
    protected function socialIdFromData($params, $transaction) {
        try {
            $modelUser = UserMaster::find()->where(['vEmail' => $params['vEmail'], 'tiUserType' => 1])->one();
            $modelUserSocial = new UserSocialAccount;
            if (empty($modelUser)) {
                $modelUser = new UserMaster;
                $modelUserSocial = new UserSocialAccount;
                $modelUser->scenario = SCH_SOCIAL_SIGNUP;
                $responce = Yii::$app->apptransaction->insert($modelUser, $params, $transaction);
                if ($responce->getResponseCode() == OK) {
                    $modelUser = $responce->getResponseModel();
                    $modelUser->scenario = SCH_SOCIAL_SIGNUP;
                    $profilePicName = '';
                    if (!empty($params['vImageUrl'])) {
                        $url = explode('?', pathinfo($params['vImageUrl'], PATHINFO_EXTENSION));
                        $profilePicName = time() . '.' . ($url[0] ?? 'jpeg');
                        $dir = Yii::getAlias('@app') . '/../uploads/users/' . $modelUser->iUserId;
                        Yii::$app->generallib->createDir($dir);
                        $arrContextOptions = array(
                            "ssl" => array(
                                "verify_peer" => false,
                                "verify_peer_name" => false,
                            ),
                        );
                        file_put_contents($dir . "/" . $profilePicName, file_get_contents($params['vImageUrl'], false, stream_context_create($arrContextOptions)));
                        $modelUser->vProfilePic = $profilePicName;
                        $modelUser->save();
                    }
                    $iUserId = $modelUser->iUserId;
                    $modelUserSocial->iUserId = $iUserId;
                    $responce = Yii::$app->apptransaction->insert($modelUserSocial, $params, $transaction);
                }
                return $responce;
            } else {
                $modelUser->scenario = SCH_SOCIAL_SIGNUP;
                $responce = Yii::$app->apptransaction->update($modelUser, $params, $transaction);
                if ($responce->getResponseCode() == OK) {
                    $modelUserSocial = UserSocialAccount::find()->where(['vSocialId' => $params['vSocialId']])->one();
                    if (empty($modelUserSocial)) {
                        $modelUserSocial = new UserSocialAccount;
                        $iUserId = $modelUser->iUserId;
                        $modelUserSocial->iUserId = $iUserId;
                        $responce = Yii::$app->apptransaction->insert($modelUserSocial, $params, $transaction);
                    } else {
                        $responce = Yii::$app->apptransaction->update($modelUserSocial, $params, $transaction);
                    }
                }
                return $responce;
            }
        } catch (Exception $ex) {
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

}

?>