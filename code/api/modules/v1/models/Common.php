<?php

/**
 * @author Sameer Paghdar <sameerp.spaceo@gmail.com>
 * 
 * @file_creation_date 14 Dec 2017
 * 
 * @development_group SOI
 * 
 * @description This model can handle validateToken proccess.
 * 
 */

namespace api\modules\v1\models;

use yii\base\Model;
use Yii;
use api\modules\v1\models\Users;

/**
 * Common model.
 */
class Common extends Model {

    public function time_ago($time_ago) {

        $current_time = time();
        $time_difference = $current_time - $time_ago;
        $seconds = $time_difference;

        $minutes = round($seconds / 60); // value 60 is seconds  
        $hours = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec  
        $days = round($seconds / 86400); //86400 = 24 * 60 * 60;  
        $weeks = round($seconds / 604800); // 7*24*60*60;  
        $months = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60  
        $years = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60

        if ($seconds <= 60) {
            return "Just Now";
        } else if ($minutes <= 60) {
            return $minutes . 'm';
        } else if ($hours <= 24) {
            return $hours . 'h';
        } else if ($days <= 7) {
            return $days . 'd';
        } else if ($weeks <= 4.3) {
            return $weeks . 'w';
        } else if ($months <= 12) {
            return $months . 'm';
        } else {
            return $years . 'y';
        }
    }


//    private function extractUniqueId($creditCard) {
////        print_r($creditCard);
////        die;
//        return $creditCard->uniqueNumberIdentifier;
//    }

    public function create_dir($dir) {
        if (!is_dir($dir)) {
            $oldmask = umask(0);
            mkdir($dir, 0777, true);
            umask($oldmask);
        } else {
            array_map('unlink', glob($dir . '/*'));
        }
    }

    public function getStatusCodeMsg($status) {
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
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

}
