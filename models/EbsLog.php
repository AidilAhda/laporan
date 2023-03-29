<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ebs_log".
 *
 * @property int $ebslog_id
 * @property int $ebslog_user_id PK Pegawai
 * @property string $ebslog_user_ip
 * @property string $ebslog_action
 * @property string|null $ebslog_data
 * @property string|null $ebslog_media
 * @property string $ebslog_created_at
 */
class EbsLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ebs_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ebslog_user_id', 'ebslog_user_ip', 'ebslog_action'], 'required'],
            [['ebslog_user_id'], 'integer'],
            [['ebslog_data', 'ebslog_media'], 'string'],
            [['ebslog_created_at'], 'safe'],
            [['ebslog_user_ip'], 'string', 'max' => 15],
            [['ebslog_action'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ebslog_id' => 'Ebslog ID',
            'ebslog_user_id' => 'Ebslog User ID',
            'ebslog_user_ip' => 'Ebslog User Ip',
            'ebslog_action' => 'Ebslog Action',
            'ebslog_data' => 'Ebslog Data',
            'ebslog_media' => 'Ebslog Media',
            'ebslog_created_at' => 'Ebslog Created At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return EbsLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EbsLogQuery(get_called_class());
    }

    static function saveLog($action,$data=[])
    {
        Yii::$app->db->createCommand()->insert(self::tableName(),[
            'ebslog_user_id'=>Yii::$app->user->identity->id,
            'ebslog_user_ip'=>Yii::$app->request->userIp,
            'ebslog_action'=>$action,
            'ebslog_data'=>($data != null) ? json_encode($data) : null,
            'ebslog_media'=>Yii::$app->request->getUserAgent(),
            'ebslog_created_at'=>date('Y-m-d H:i:s'),
         ])->execute();
    }

    static function getByUser()
    {
        return self::find()->select(['ebslog_action as action','ebslog_created_at as date'])->where(['ebslog_user_id'=>AuthUser::user()->id])->limit(50)->asArray()->all();
    }
}
