<?php

namespace common\components;

use yii;
use yii\base\Component;
use yii\db\Transaction;
use backend\models\Notifications;
use yii\web\UploadedFile;
use common\models\MediaMaster;
use api\modules\v1\models\response\TransactionResponse;
use api\modules\v1\models\response\ErrorResponse;
use api\modules\v1\models\response\SuccessResponse;

class Transactions extends Component {

    /**
     * 
     * @param type $model
     * @param type $params
     * @param type $transaction
     * @param type $scenerio
     * @return TransactionResponse
     */
    public function insert($model, $params, $transaction, $scenerio = "") {
        try {
            if (!empty($scenerio)) {
                $model->scenario = $scenerio;
            }
            $model->attributes = $params;
            $model->iCreatedAt = time();
            if ($model->validate() && $model->save()) {
                return TransactionResponse::withData(OK, Yii::t('response', 'insert_success'), $model);
            } else {
                return ErrorResponse::withData(BAD_REQUEST, current($model->getFirstErrors()));
            }
        } catch (Exception $e) {
            return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'server_error'));
        }
    }

    /**
     * 
     * @param type $model
     * @param type $params
     * @param type $transaction
     * @param type $scenerio
     * @return TransactionResponse
     */
    public function update($model, $params, $transaction, $scenerio = "") {
        try {
            if (!empty($scenerio)) {
                $model->scenario = $scenerio;
            }
            $model->attributes = $params;
            $model->iUpdatedAt = time();

            if ($model->validate() && $model->save()) {
                return TransactionResponse::withData(OK, Yii::t('response', 'update_success'), $model);
            } else {
                return ErrorResponse::withData(BAD_REQUEST, current($model->getFirstErrors()));
            }
        } catch (Exception $e) {
            return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'server_error'));
        }
    }

    public function batchInsert($tableName, $fieldName, $insertData) {
        try {
            Yii::$app->db->createCommand()->batchInsert($tableName, $fieldName, $insertData)->execute();
            return SuccessResponse::withData(OK, Yii::t('response', 'insert_success'));
        } catch (\yii\db\IntegrityException $e) {
            return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'server_error'));
        }
    }

    public function delete($model, $IsSoftDelete = FAlSE, $scenerio = "") {
        try {
            if (!empty($scenerio)) {
                $model->scenario = $scenerio;
            }
            if ($IsSoftDelete) {
                $model->tiIsDeleted = 1;
                $model->iUpdatedAt = time();
                if ($model->validate() && $model->save()) {
                    return SuccessResponse::withData(OK, Yii::t('response', 'delete_success'));
                }
            } else if ($model->delete()) {
                return SuccessResponse::withData(OK, Yii::t('response', 'delete_success'));
            } else {
                return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'delete_failed'));
            }
        } catch (\yii\db\IntegrityException $e) {
            return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'server_error'));
        }
    }

    /**
     * 
     * @param yii\db\ActiveRecord $model
     * @param UploadedFile $instances
     * @param string $dir
     * @param string $tableName
     */
    public function uploadMultipleFiles($model, $instances, $dir, $tableName) {
        try {
            $Filedata = [];
            foreach ($instances as $key => $value) {
                
            }
            
        } catch (\yii\db\IntegrityException $e) {
            return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'server_error'));
        }
    }

    function uploadImage($files, $folder_name, $Id) {

        try {
            for ($p = 0; $p < count($files['vMediaName']['name']); $p++) {
                $vMediaName = UploadedFile::getInstanceByName('vMediaName[' . $p . ']');
                $ImageName = time() . rand(0, 999) . '.' . $vMediaName->extension;
                $imgData = array('imageData' => $vMediaName, 'name' => $ImageName, 'id' => $Id);

                if (!empty($vMediaName)) {
                    $uploadpath = Yii::getAlias('@root') . '/uploads/' . $folder_name . '/' . $Id;
                    if (!is_dir($uploadpath)) {
                        if (!file_exists($uploadpath)) {
                            mkdir($uploadpath, 0777, true);
                        }
                    }

                    $vMediaName->saveAs($uploadpath . '/' . $ImageName);
                    $insertData[] = [$ImageName, $vMediaName->size, $vMediaName->type, $folder_name, $Id, time()];
                }
            }

            $fieldName = ['vMediaName', 'biFileSize', 'vFileType', 'eMediaType', 'iUserId', 'iCreatedAt'];
            $model = $this->batchInsert('media_master', $fieldName, $insertData);
            //Batch Insert in media_master table
            $model = Yii::$app->common->setResponse(OK, Yii::t('response', 'success'), $model);
        } catch (Exception $e) {

            $transaction->rollBack();
            Yii::$app->common->setResponse(BAD_REQUEST, Yii::t('response', 'server_error'));
        }
    }

    function uploadImageURL($model, $mediaData, $folder_name, $Id) {
        try {
            //Delete previous image
            foreach ($mediaData as $media) {

                $insertData[] = [$media->vMediaName, $media->biFileSize, $media->vFileType, $folder_name, $Id, time()];
            }
            $fieldName = ['vMediaName', 'biFileSize', 'vFileType', 'eMediaType', 'iUserId', 'iCreatedAt'];
            $model = $this->batchInsert('media_master', $fieldName, $insertData);
            //Batch Insert in media_master table
            $model = Yii::$app->common->setResponse(OK, Yii::t('response', 'success'), $model);
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::$app->common->setResponse(BAD_REQUEST, Yii::t('response', 'server_error'));
        }
    }

}

?>