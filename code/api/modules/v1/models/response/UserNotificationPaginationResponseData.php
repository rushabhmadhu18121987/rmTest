<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace api\modules\v1\models\response;

/**
 * @SWG\Definition(
 *   type="object",
 *   @SWG\Xml(name="UserNotificationPaginationResponseData")
 * )
 */
class UserNotificationPaginationResponseData {

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $page;

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $pageSize;

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $totalCount;

    /**
     * @SWG\Property(type="array", @SWG\Items(ref="#/definitions/UserNotificationResponseData"))
     * @var data
     */
    private $data;

    function getPage() {
        return $this->page;
    }

    function getPageSize() {
        return $this->pageSize;
    }

    function getTotalCount() {
        return $this->totalCount;
    }

    function getData() {
        return $this->data;
    }

    function setPage($page) {
        $this->page = $page;
    }

    function setPageSize($pageSize) {
        $this->pageSize = $pageSize;
    }

    function setTotalCount($totalCount) {
        $this->totalCount = $totalCount;
    }

    function setData($data) {
        $this->data = $data;
    }

    /**
     * 
     * @param \yii\data\ActiveDataProvider $provider
     * @param array() $params
     * @return \self
     */
    /**
     * 
     * @param int $page
     * @param int $pageSize
     * @param int $totalCount
     * @param array(UserNotificationResponseData) $data
     * @return \self
     */
    public static function withData($page, $pageSize, $totalCount, $data) {
        $instance = new self();
        $instance->setPage($page);
        $instance->setPageSize($pageSize);
        $instance->setTotalCount($totalCount);
        $instance->setData($data);
        return $instance;
    }

    public function showEverything() {
        return get_object_vars($this);
    }

}
