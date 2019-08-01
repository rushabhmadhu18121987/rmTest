<?php

namespace api\modules\v1\models\response;

use Yii;

/**
 * @SWG\Definition(
 *   type="object",
 *   @SWG\Xml(name="AppSettingResponseData")
 * )
 */
class AppSettingResponseData {

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $APP_MAP_DISTANCE_RADIUS;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $APP_SUPPORT_NUMBER;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $APP_ADMIN_EMAIL;

    /**
     * @SWG\Property(format="float")
     * @var number
     */
    private $APP_SUPPORT_EMAIL;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $IPHONE_APP_LINK;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $ANDROID_APP_LINK;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $FACEBOOK_LINK;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $TWITTER_LINK;

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $API_PAGE_LIMIT;

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $NOTIFICATION_BADGE_COUNT;

    function getAPP_MAP_DISTANCE_RADIUS() {
        return $this->APP_MAP_DISTANCE_RADIUS;
    }

    function getAPP_SUPPORT_NUMBER() {
        return $this->APP_SUPPORT_NUMBER;
    }

    function getAPP_ADMIN_EMAIL() {
        return $this->APP_ADMIN_EMAIL;
    }

    function getAPP_SUPPORT_EMAIL() {
        return $this->APP_SUPPORT_EMAIL;
    }

    function getIPHONE_APP_LINK() {
        return $this->IPHONE_APP_LINK;
    }

    function getANDROID_APP_LINK() {
        return $this->ANDROID_APP_LINK;
    }

    function getFACEBOOK_LINK() {
        return $this->FACEBOOK_LINK;
    }

    function getTWITTER_LINK() {
        return $this->TWITTER_LINK;
    }

    function getAPI_PAGE_LIMIT() {
        return $this->API_PAGE_LIMIT;
    }

    function getNOTIFICATION_BADGE_COUNT() {
        return $this->NOTIFICATION_BADGE_COUNT;
    }

    function setAPP_MAP_DISTANCE_RADIUS($APP_MAP_DISTANCE_RADIUS) {
        $this->APP_MAP_DISTANCE_RADIUS = $APP_MAP_DISTANCE_RADIUS;
    }

    function setAPP_SUPPORT_NUMBER($APP_SUPPORT_NUMBER) {
        $this->APP_SUPPORT_NUMBER = $APP_SUPPORT_NUMBER;
    }

    function setAPP_ADMIN_EMAIL($APP_ADMIN_EMAIL) {
        $this->APP_ADMIN_EMAIL = $APP_ADMIN_EMAIL;
    }

    function setAPP_SUPPORT_EMAIL($APP_SUPPORT_EMAIL) {
        $this->APP_SUPPORT_EMAIL = $APP_SUPPORT_EMAIL;
    }

    function setIPHONE_APP_LINK($IPHONE_APP_LINK) {
        $this->IPHONE_APP_LINK = $IPHONE_APP_LINK;
    }

    function setANDROID_APP_LINK($ANDROID_APP_LINK) {
        $this->ANDROID_APP_LINK = $ANDROID_APP_LINK;
    }

    function setFACEBOOK_LINK($FACEBOOK_LINK) {
        $this->FACEBOOK_LINK = $FACEBOOK_LINK;
    }

    function setTWITTER_LINK($TWITTER_LINK) {
        $this->TWITTER_LINK = $TWITTER_LINK;
    }

    function setAPI_PAGE_LIMIT($API_PAGE_LIMIT) {
        $this->API_PAGE_LIMIT = $API_PAGE_LIMIT;
    }

    function setNOTIFICATION_BADGE_COUNT($NOTIFICATION_BADGE_COUNT) {
        $this->NOTIFICATION_BADGE_COUNT = $NOTIFICATION_BADGE_COUNT;
    }

    public static function withModel($model) {
        $instance = new self();
        $instance->setAPP_MAP_DISTANCE_RADIUS($model->APP_MAP_DISTANCE_RADIUS);
        $instance->setAPP_SUPPORT_NUMBER((int) $model->APP_SUPPORT_NUMBER);
        $instance->setAPP_ADMIN_EMAIL($model->APP_ADMIN_EMAIL);
        $instance->setAPP_SUPPORT_EMAIL($model->APP_SUPPORT_EMAIL);
        $instance->setIPHONE_APP_LINK($model->IPHONE_APP_LINK);
        $instance->setANDROID_APP_LINK($model->ANDROID_APP_LINK);
        $instance->setAPP_SUPPORT_NUMBER($model->APP_SUPPORT_NUMBER);
        $instance->setFACEBOOK_LINK($model->FACEBOOK_LINK);
        $instance->setTWITTER_LINK($model->TWITTER_LINK);
        $instance->setAPI_PAGE_LIMIT($model->API_PAGE_LIMIT);
        $instance->setNOTIFICATION_BADGE_COUNT((int) $model->NOTIFICATION_BADGE_COUNT ?? 0);
        return $instance;
    }

    public function showEverything() {
        return get_object_vars($this);
    }

}
