<?php

namespace api\modules\v1\models\response;

/**
 * @SWG\Definition(
 *   type="object",
 *   @SWG\Xml(name="UserNotificationResponseData")
 * )
 */
class UserNotificationResponseData {

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $iUserNotificationId;

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $iUserId;

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $iEntryId;
            
    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vNotificationTitle;
            
    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vNotificationDesc;

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $tiNotificationReceiver;

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $tiNotificationType;

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $tiIsRead;

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $iCreatedAt;
    
    function getIUserNotificationId() {
        return $this->iUserNotificationId;
    }

    function getIUserId() {
        return $this->iUserId;
    }

    function getIEntryId() {
        return $this->iEntryId;
    }

    function getVNotificationTitle() {
        return $this->vNotificationTitle;
    }

    function getVNotificationDesc() {
        return $this->vNotificationDesc;
    }

    function getTiNotificationReceiver() {
        return $this->tiNotificationReceiver;
    }

    function getTiNotificationType() {
        return $this->tiNotificationType;
    }

    function getTiIsRead() {
        return $this->tiIsRead;
    }

    function getICreatedAt() {
        return $this->iCreatedAt;
    }

    function setIUserNotificationId($iUserNotificationId) {
        $this->iUserNotificationId = $iUserNotificationId;
    }

    function setIUserId($iUserId) {
        $this->iUserId = $iUserId;
    }

    function setIEntryId($iEntryId) {
        $this->iEntryId = $iEntryId;
    }

    function setVNotificationTitle($vNotificationTitle) {
        $this->vNotificationTitle = $vNotificationTitle;
    }

    function setVNotificationDesc($vNotificationDesc) {
        $this->vNotificationDesc = $vNotificationDesc;
    }

    function setTiNotificationReceiver($tiNotificationReceiver) {
        $this->tiNotificationReceiver = $tiNotificationReceiver;
    }

    function setTiNotificationType($tiNotificationType) {
        $this->tiNotificationType = $tiNotificationType;
    }

    function setTiIsRead($tiIsRead) {
        $this->tiIsRead = $tiIsRead;
    }

    function setICreatedAt($iCreatedAt) {
        $this->iCreatedAt = $iCreatedAt;
    }


    /**
     * Create Instance Using Notification Model
     * @param \api\modules\v1\models\UserNotification $model
     * @return self
     */
    public static function withModel($model) {
        $instance = new self();
        $instance->setIUserNotificationId($model->iUserNotificationId);
        $instance->setIUserId($model->iUserId);
        $instance->setIEntryId($model->iEntryId);
        $instance->setVNotificationTitle($model->vNotificationTitle);
        $instance->setVNotificationDesc($model->vNotificationDesc);
        $instance->setTiNotificationReceiver($model->tiNotificationReceiver);
        $instance->setTiNotificationType($model->tiNotificationType);
        $instance->setTiIsRead($model->tiIsRead);
        $instance->setICreatedAt($model->iCreatedAt);
        return $instance;
    }

    public function showEverything() {
        return get_object_vars($this);
    }

}
