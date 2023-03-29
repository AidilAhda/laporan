<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sdm_m_suku".
 *
 * @property int $suk_id
 * @property string $suk_nama
 * @property int $suk_aktif
 * @property string|null $suk_created_at
 * @property int|null $suk_created_by
 * @property string|null $suk_updated_at
 * @property int|null $suk_updated_by
 * @property string|null $suk_deleted_at
 * @property int|null $suk_deleted_by
 */
class SdmMSuku extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sdm_m_suku';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['suk_nama', 'suk_aktif'], 'required'],
            [['suk_aktif', 'suk_created_by', 'suk_updated_by', 'suk_deleted_by'], 'integer'],
            [['suk_created_at', 'suk_updated_at', 'suk_deleted_at'], 'safe'],
            [['suk_nama'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'suk_id' => 'Suk ID',
            'suk_nama' => 'Suk Nama',
            'suk_aktif' => 'Suk Aktif',
            'suk_created_at' => 'Suk Created At',
            'suk_created_by' => 'Suk Created By',
            'suk_updated_at' => 'Suk Updated At',
            'suk_updated_by' => 'Suk Updated By',
            'suk_deleted_at' => 'Suk Deleted At',
            'suk_deleted_by' => 'Suk Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SdmMSukuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SdmMSukuQuery(get_called_class());
    }
}
