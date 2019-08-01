<?php

namespace common\components;

use yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use api\modules\v1\models\UserDeviceMaster;
use api\modules\v1\models\response\ErrorResponse;
use api\modules\v1\models\response\SuccessResponse;

//use backend\models\Notifications;
//use sizeg\jwt\JwtHttpBearerAuth;

class Generallib extends Component {

    public $headers;
    public $bodyParams;

    public function responseData($code, $msg = '', $data = NULL) {
        Yii::$app->response->statusCode = $code;
        Yii::$app->response->statusText = $msg;
        Yii::$app->response->data = ($data === NULL) ? new \stdClass() : $data;
    }

    public function init() {
        $this->headers = Yii::$app->request->headers;
        $this->bodyParams = Yii::$app->request->bodyParams;
        Yii::$app->language = !empty($this->headers['lang']) ? $this->headers['lang'] : Yii::$app->params['default_language'];
    }

//    public function behaviors() {
//        $behaviors = parent::behaviors();
//        $behaviors['authenticator'] = [
//            'class' => JwtHttpBasicAuth::className(),
//        ];
//        return $behaviors;
//    }

    public function errors($model_user) {
        $error = $model_user->errors;
        return $response_user = ['responseCode' => BAD_REQUEST, 'responseCode' => current($error)[0]];
    }

    public function GenerateJWTToken($header, $email) {

        $key = base64_decode('ABCDEF');

        $tokenId = base64_encode(mcrypt_create_iv(32));
        $issuedAt = time();
        $notBefore = $issuedAt + 5;
        $expire = $notBefore + 1800;

        $user = \api\modules\v1\models\UserMaster::find(['vEmailId' => $email])->one();

        $data = [
            'iss' => 'your-site.com',
            'iat' => $issuedAt,
            'jti' => $tokenId,
            'nbf' => $notBefore,
            'exp' => $expire,
            'data' => [
                'iUserId' => $user->iUserId,
                'vEmailId' => $user->vEmailId,
            //put everything you want (that not sensitive) in here
            ]
        ];
    }

    function objectToArray($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }

        if (is_array($d)) {
            /*
             * Return array converted to object
             * Using __FUNCTION__ (Magic constant)
             * for recursive call
             */
            return array_map(__FUNCTION__, $d);
        } else {
            // Return array
            return $d;
        }
    }

    public function validateToken($header, $content_type = false) {

        if (empty($header['token'])) {
            $response = ['responseCode' => BAD_REQUEST, 'responseMessage' => Yii::t('response', 'token_error')];
        } else if (empty($header['nonce'])) {
            $response = ['responseCode' => BAD_REQUEST, 'responseMessage' => Yii::t('response', 'nonce_error')];
        } else if (empty($header['timestamp'])) {
            $response = ['responseCode' => BAD_REQUEST, 'responseMessage' => Yii::t('response', 'timestamp_error')];
        } else if ($content_type == true && $_SERVER["CONTENT_TYPE"] != 'application/x-www-form-urlencoded') {
            $response = ['responseCode' => BAD_REQUEST, 'responseMessage' => Yii::t('response', 'content_type_error')];
        } else {
            $hash_str = "nonce=" . $header['nonce'] . "&timestamp=" . $header['timestamp'] . "|" . SECRET_KEY;
            $sig = hash_hmac(HASH_KEY, $hash_str, PRIVATE_KEY);
            if ($sig !== $header['token']) {
                $response = ['responseCode' => BAD_REQUEST, 'responseMessage' => Yii::t('response', 'token_invalid_error')];
            } else {
                $response = ['responseCode' => OK];
            }
        }
        return $response;
    }

    public function backgroundPost($url) {
//        $handle = fopen('test.txt', 'a+');
//        $logtext = "******************" . date('d-m-Y h:i:s') . "******************\n\n";
//        $logtext .= print_r($url, true);
//        $logtext .= "\n\n**********************************************************************\n\n";
//        $errorlog = fwrite($handle, $logtext);
//        fclose($handle);
        $parts = parse_url($url);
        $fp = fsockopen($parts['host'], isset($parts['port']) ? $parts['port'] : 80, $errno, $errstr, 30);
        if (!$fp) {
            return false;
        } else {
            $out = "POST " . $parts['path'] . " HTTP/1.1\r\n";
            $out .= "Host: " . $parts['host'] . "\r\n";
            $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $out .= "Content-Length: " . strlen($parts['query']) . "\r\n";
            $out .= "Connection: Close\r\n\r\n";
            if (isset($parts['query']))
                $out .= $parts['query'];
            fwrite($fp, $out);
            fclose($fp);
            return true;
        }
    }

    public function clouderrorlog($errordata) {
        $handle = fopen('testFile.txt', 'a+');
        $logtext = "******************" . date('d-m-Y H:i:s') . "******************\n\n";
        $logtext .= $errordata;
        $logtext .= "\n\n**********************************************************************\n\n";
        $errorlog = fwrite($handle, $logtext);
        fclose($handle);
        return true;
    }

    public function send_push($modelDevice, $msgData) {


        foreach ($modelDevice as $device) {

            if (!empty($device->vDeviceToken)) {

                if ($device->eDeviceType == 1) {

                    $this->send_notification_ios($device->vDeviceToken, $msgData);
                } else if ($device->eDeviceType == 2) {

                    $this->send_notification_android($device->vDeviceToken, $msgData);
                }
            }
        }
    }

    public function send_notification_android($registrationId, $msgData) {

        $url = Yii::$app->params['FCM_API_SERVER_URL'];
        $message = json_encode($msgData);
        $fields = [
            'to' => $registrationId,
            //'priority' => 'high',
            'notification' => [
                'body' => $msgData['msg'],
                'type' => $msgData['type'],
//                'badge' => $msgData['badge'],
                'sound' => 'default',
                //'color' => "#48BD99",
                'image' => Yii::$app->params['logo_url']
            ],
        ];

        $headers = [
            'Authorization: key=' . Yii::$app->params['ANDROID_FCM_SERVER_KEY'],
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post
        $result = curl_exec($ch);
        // Close connection
        curl_close($ch);

        if ($result) {
            return 1;
        } else {

            return 0;
        }
    }

    public function send_notification_ios($registrationId, $msgData) {

        $url = Yii::$app->params['FCM_API_SERVER_URL'];
        $message = json_encode($msgData);
        $fields = [
            'to' => $registrationId,
            //'priority' => 'high',
            'notification' => [
                'body' => $msgData['msg'],
                'type' => $msgData['type'],
//                'badge' => $msgData['badge'],
                'sound' => 'default',
                //'color' => "#48BD99",
                'image' => Yii::$app->params['logo_url']
            ],
        ];

        $headers = [
            'Authorization: key=' . Yii::$app->params['IOS_FCM_SERVER_KEY'],
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post
        $result = curl_exec($ch);
        // Close connection
        curl_close($ch);
        if ($result) {
            return 1;
        } else {
            return 0;
        }
    }

    public function twilioSend($toMobile, $msg) {
        try {
            $sid = Yii::$app->params['TWILIO_SID'];
            $token = Yii::$app->params['TWILIO_TOKEN'];
            $client = new \Twilio\Rest\Client($sid, $token);
            $client->messages->create(
                    $toMobile, array(
                'from' => Yii::$app->params['TWILIO_FROM_NO'],
                'body' => $msg
                    )
            );
            return \api\modules\v1\models\response\SuccessResponse::withData(OK, Yii::t('response', 'Enter the One-time Password (OTP) that was Sent to ' . $toMobile));
        } catch (\Twilio\Exceptions\RestException $e) {
            return \api\modules\v1\models\response\ErrorResponse::withData(BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * Create Directory
     * @param type $dir
     */
    public function createDir($dir) {
        if (!is_dir($dir)) {
            $oldmask = umask(0);
            mkdir($dir, 0777, true);
            umask($oldmask);
        }
    }

    public function sendFCMNotification($params, $iUserId, $IsDebug = FALSE) {
        $modelDevices = UserDeviceMaster::find()
                        ->leftJoin('user_master um', 'um.iUserId = user_device_master.iUserId')
                        ->select(['user_device_master.*', 'um.iNotiBadgeCount AS badgeCount'])
                        ->where(['user_device_master.iUserId' => $iUserId])->asArray()->all();
        if (!empty($modelDevices)) {
            $AndroidDevices = array_filter($modelDevices, function($arr) {
                return $arr['tiDeviceType'] == 1;
            });
            $iOsDevices = array_filter($modelDevices, function($arr) {
                return $arr['tiDeviceType'] == 2;
            });
            $badgeCount = ArrayHelper::getColumn($modelDevices, 'badgeCount', FALSE);
            if (!empty($iOsDevices)) {
                $registration_ids = ArrayHelper::getColumn($iOsDevices, 'vDeviceToken', FALSE);
                $fields = [
                    'registration_ids' => $registration_ids,
                    'notification' => [
                        'iUserNotificationId' => $params['iUserNotificationId'] ?? NULL,
                        'body' => $params['vNotificationTitle'] ?? 'Hello',
                        'type' => $params['tiNotificationType'] ?? 1,
                        'desc' => $params['vNotificationDesc'] ?? '',
                        'badge' => $badgeCount[0],
                        'iEntryId' => (int) $params['iEntryId'],
                        'sound' => 'default',
                        'image' => Yii::$app->params['logo_url']
                    ]
                ];
                if ($IsDebug) {
                    print_r($iOsDevices);
                    print_r($fields);
                }
                $this->sendFCMNotificationRequest($fields, $IsDebug);
            }
            if (!empty($AndroidDevices)) {
                $registration_ids = array_filter(ArrayHelper::getColumn($AndroidDevices, 'vDeviceToken', FALSE));
                $fields = [
                    'registration_ids' => $registration_ids,
                    'data' => [
                        'iUserNotificationId' => $params['iUserNotificationId'] ?? NULL,
                        'body' => $params['vNotificationTitle'] ?? 'Hello',
                        'type' => $params['tiNotificationType'] ?? 0,
                        'desc' => $params['vNotificationDesc'] ?? '',
                        'badge' => $badgeCount[0],
                        'iEntryId' => (int) $params['iEntryId'],
                        'sound' => 'default',
                        'image' => Yii::$app->params['logo_url']
                    ]
                ];
                if ($IsDebug) {
                    print_r($AndroidDevices);
                    print_r($fields);
                }
                $this->sendFCMNotificationRequest($fields, $IsDebug);
            }
            return TRUE;
        }
    }

    public function sendFCMNotificationRequest($fields, $IsDebug) {
        $url = Yii::$app->params['FCM_API_SERVER_URL'];
        $headers = [
            'Authorization: key=' . Yii::$app->params['FCM_SERVER_KEY'],
            'Content-Type: application/json'
        ];
        if (!empty($fields) && !empty($fields['registration_ids']) && (!empty($fields['data']) || !empty($fields['notification']))) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            // Execute post
            $result = curl_exec($ch);
            // Close connection
            curl_close($ch);
            if ($IsDebug) {
                print_r($result);
            }
        }
    }

    /**
     * 
     * @param int $latitude
     * @param int $longitude
     * @return string Timezone name
     */
    function getTimezoneGeo($latitude, $longitude) { //connect to web service
        $url = 'http://api.geonames.org/timezone?lat=' . $latitude . '&lng=' . $longitude . '&style=full&username=' . urlencode('vbpanchal');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $xml = curl_exec($ch);
        curl_close($ch);
        if (!$xml) {
            return 'The GeoNames service did not return any data: ' . $url;
        }
        //parse XML response
        $data = new \SimpleXMLElement($xml);
//        echo '<pre>'.print_r($data,true).'</pre>'; die();
        $timezone = trim(strip_tags($data->timezone->timezoneId));
        if ($timezone) {
            return $timezone;
        } else {
            return 'The GeoNames service did not return a time zone: ' . $url;
        }
        return $data->timezoneId;
    }

    
    // public function sendEmail($subject, $content) {
    //     try{
    //         $adminEmail = 'akshayb.spaceo@gmail.com';//$this->getAdminSettingByKey('APP_ADMIN_EMAIL');
    //         $admin = 'akshayb.spaceo@gmail.com';//$adminEmail->vAppSettingValue;
    //         $successorfailure = Yii::$app->mailer->compose()
    //                             ->setFrom([Yii::$app->params['SMTP_FROM_EMAIL'] => Yii::$app->name])
    //                             ->setTo([$admin])
    //                             ->setCc(Yii::$app->params['DEVELOPER_EMAIL'])
    //                             ->setSubject($subject)
    //                             ->setTextBody($content)
    //                             ->setHtmlBody($content)
    //                             ->send();

    //         if($successorfailure){
    //             $data = array('data' => 'Mail jay 6e');
    //             $data = \json_encode($data);
    //             $this->clouderrorlog($data);
    //         }else{
    //             $data = array('data' => 'Mail nathi jay 6e');
    //             $data = \json_encode($data);
    //             $this->clouderrorlog($data);
    //         }
    //     }catch(\Exception $e){
    //             // echo "<pre>";print_r($e->getMessage());die;
    //             $data = array('data' => $e->getMessage());
    //             $data = \json_encode($data);
    //             $this->clouderrorlog($data);
    //     }
    // }

    public function sendEmail($to = NULL, $from = NULL, $subject = NULL, $body = NULL, $attachment = NULL, $filename = NULL, $bcc = NULL, $cc = NULL, $extrattachment = NULL) {
        try {

            if ($attachment != NULL) {

                $message = \Yii::$app->mailer->compose()
                        ->setFrom($from)
                        ->setTo($to)
                        ->setBcc($bcc)
                        ->setCc($cc)
                        ->setSubject($subject)
                        ->setHtmlBody($body)
                        ->attachContent($attachment, [
                    'fileName' => $filename,
                    'contentType' => 'application/pdf'
                ]);
                if (!empty($extrattachment)) {

                    foreach ($extrattachment as $value) {

//                        $message->attachContent('Attachment content', ['fileName' => file_get_contents($_FILES['file']['tmp_name'][0]), 'contentType' => 'image/png']);
//                        $message->attach(
//                                Swift_Attachment::fromPath($_FILES['file']['tmp_name'][0])->setFilename($_FILES['file']['name'][0])
//                        );
//                        $message->attach(Swift_Attachment::fromPath($_FILES['file']['tmp_name'][0]));
//                        $message->attach(
//                                Swift_Attachment::fromPath(file_get_contents($value->tempName))->setFilename($value->name)
//                        );

                        $filename = Yii::getAlias('@emailattachments') . $value->name; # i'd suggest adding an absolute path here, not a relative.
                        $value->saveAs($filename);
                        chmod($filename, 0777);
                        $message->attach($filename);
//                        unlink($filename);
                    }
                }
                if ($message->send()) {
                    array_map('unlink', glob(Yii::getAlias('@emailattachments') . "*"));
                    return 1;
                } else {
                    return 0;
                }
            } else {

                \Yii::$app->mailer->compose(
                        )
                        ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
                        ->setTo($to)
                        ->setSubject($subject)
                        ->setHtmlBody($body)
                        ->send();

                return true;
            }
        } catch (\Swift_TransportException $e) {
            $response = $e->getMessage();
            //Yii::$app->generallib->cloud_error_log($response);

            return true;
        }
    }


}

?>
