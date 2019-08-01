<?php

/* *     **********************************************************************
 * Original Author: Vijay Panchal
 * Created By : Vijay Panchal    
 * Created On : 10 Jan 2019
 * File Creation Date: 10 Jan 2019
 * Development Group: Space-O Technologies
 * Description:     
 * Last Modified on:
 * Modified By:
 * Modified Description:
 * Purpose :  base controller for yii2-backend    
 * Modified Code:
 * ********************************************************************* */

namespace backend\controllers\base;

use Yii;
use yii\web\Controller;
use Carbon\Carbon;
use backend\models\AppSetting;

class BaseController extends Controller {

    /**
     *
     * @var \yii\web\HeaderCollection
     */
    public $headers;

    /**
     *
     * @var array $bodyParams
     */
    public $bodyParams;

    /**
     *
     * @var array $queryParams
     */
    public $queryParams;

    /**
     *
     * @var \frontend\models\UserMaster 
     */
    public $identity;

    /**
     *
     * @var array 
     */
    public $data = [];

    /**
     *
     * @var int 
     */
    public $offset;

    /**
     *
     * @var string 
     */
    public $timezone;

    /**
     *
     * @var string 
     */
    public $datetimeFormat = 'M d,Y h:i:s A';

    /**
     *
     * @var string 
     */
    public $timeFormat = 'h:i A';

    /**
     *
     * @var string 
     */
    public $dateFormat = 'd/m/Y';

    /**
     *
     * @var  \api\modules\v1\models\response\AppSettingResponseData $appSetting
     */
    public $appSetting;

    public function __construct($id, $module) {
        parent::__construct($id, $module);
    }

    public function init() {
        parent::init();
        $this->bodyParams = Yii::$app->request->bodyParams;
        $this->queryParams = Yii::$app->request->queryParams;
        $this->headers = Yii::$app->request->headers;
        Yii::$app->language = !empty($this->headers['lang']) ? $this->headers['lang'] : Yii::$app->params['default_language']??'en';
        $this->offset = Yii::$app->request->cookies['timezone_offset_minutes']->value ?? 0;
        $timezoneOffset = (0 - $this->offset) * 60; /* get time zone offset */
        $this->appSetting = AppSetting::getAppSetting();
        $this->timezone = $this->appSetting->ADMIN_TIMEZONE;
    }  

}
