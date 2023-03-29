<?php
namespace app\widgets;

use app\models\SdmMAplikasiLevel;
use Yii;
class AuthUser
{
    static function isGuest()
    {
        $user=Yii::$app->user;
        if(!$user->isGuest){
            return false;
        }
        return true;
    }

    static function user()
    {
        $obj = new \stdClass();
        $obj->id=Yii::$app->user->identity->pgw_id;
        $obj->username=Yii::$app->user->identity->pgw_username;
        $obj->fullname=Yii::$app->user->identity->pgw_nama;
        // $obj->level=Yii::$app->user->identity->akp_all_id;
        return $obj;
    } 
}