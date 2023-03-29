<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sdm_m_akses_unit".
 *
 * @property int $aku_id
 * @property int $aku_pgw_id
 * @property int $aku_unt_id
 * @property int $aku_apl_id
 * @property string $aku_sk
 * @property int $aku_aktif
 * @property string|null $aku_created_at
 * @property int|null $aku_created_by
 * @property string|null $aku_updated_at
 * @property int|null $aku_updated_by
 * @property string|null $aku_deleted_at
 * @property int|null $aku_deleted_by
 */
class SdmMAksesUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sdm_m_akses_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aku_pgw_id', 'aku_unt_id', 'aku_apl_id', 'aku_sk', 'aku_aktif'], 'required'],
            [['aku_pgw_id', 'aku_unt_id', 'aku_apl_id', 'aku_aktif', 'aku_created_by', 'aku_updated_by', 'aku_deleted_by'], 'integer'],
            [['aku_created_at', 'aku_updated_at', 'aku_deleted_at'], 'safe'],
            [['aku_sk'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'aku_id' => 'Aku ID',
            'aku_pgw_id' => 'Aku Pgw ID',
            'aku_unt_id' => 'Aku Unt ID',
            'aku_apl_id' => 'Aku Apl ID',
            'aku_sk' => 'Aku Sk',
            'aku_aktif' => 'Aku Aktif',
            'aku_created_at' => 'Aku Created At',
            'aku_created_by' => 'Aku Created By',
            'aku_updated_at' => 'Aku Updated At',
            'aku_updated_by' => 'Aku Updated By',
            'aku_deleted_at' => 'Aku Deleted At',
            'aku_deleted_by' => 'Aku Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SdmMAksesUnitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SdmMAksesUnitQuery(get_called_class());
    }
}
