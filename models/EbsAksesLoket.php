<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ebs_akses_loket".
 *
 * @property int $alo_id Akses Loket Id
 * @property int $alo_user_id User Id
 * @property int $alo_lob_id Loket Pembayaran Id
 * @property int $alo_aktif 1 => aktif 0 => Tidak Aktif	
 * @property string|null $alo_created_at
 * @property int|null $alo_created_by
 * @property string|null $alo_updated_at
 * @property int|null $alo_updated_by
 * @property string|null $alo_deleted_at
 * @property int|null $alo_deleted_by
 */
class EbsAksesLoket extends \yii\db\ActiveRecord
{
    const PARAM_LOKET = 'LOKET';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ebs_akses_loket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alo_user_id', 'alo_lob_id', 'alo_aktif'], 'required'],
            [['alo_user_id', 'alo_lob_id', 'alo_aktif', 'alo_created_by', 'alo_updated_by', 'alo_deleted_by'], 'integer'],
            [['alo_created_at', 'alo_updated_at', 'alo_deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'alo_id' => 'Alo ID',
            'alo_user_id' => 'User ID',
            'alo_lob_id' => 'Lob ID',
            'alo_aktif' => 'Alo Aktif',
            'alo_created_at' => 'Alo Created At',
            'alo_created_by' => 'Alo Created By',
            'alo_updated_at' => 'Alo Updated At',
            'alo_updated_by' => 'Alo Updated By',
            'alo_deleted_at' => 'Alo Deleted At',
            'alo_deleted_by' => 'Alo Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return EbsAksesLoketQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EbsAksesLoketQuery(get_called_class());
    }
    function getLoket()
    {
        return $this->hasOne(EbsMLoketPembayaran::className(),['lob_id'=>'alo_lob_id']);
    }
    public static function getUserAksesLoket($uid = null)
    {
        if(empty($uid)){
            $uid = \Yii::$app->user->getId();
        }

        return self::find()
          //  ->select(['lob_id'])
            ->joinWith([ 'loket'],true)
            ->where(['alo_user_id'=>$uid])
            ->asArray()
            ->indexBy('alo_lob_id')
            ->all();
    }
    public function setParam($index, $value)
    {
        $this->params[$index] = $value;

    }

    public function getParam($index = null)
    {
        if(empty($index)){
            return $this->params;
        }

        if(isset($this->params[$index])){
            return $this->params[$index];
        }
        return null;
    }
}
