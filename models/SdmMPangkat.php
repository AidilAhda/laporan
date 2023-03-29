<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sdm_m_pangkat".
 *
 * @property int $smp_id
 * @property string $smp_nama
 * @property int $smp_aktif 1=y,0=n
 * @property string|null $smp_created_at
 * @property int|null $smp_created_by
 * @property string|null $smp_updated_at
 * @property int|null $smp_updated_by
 * @property string|null $smp_deleted_at
 * @property int|null $smp_deleted_by
 */
class SdmMPangkat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sdm_m_pangkat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['smp_nama', 'smp_aktif'], 'required'],
            [['smp_aktif', 'smp_created_by', 'smp_updated_by', 'smp_deleted_by'], 'integer'],
            [['smp_created_at', 'smp_updated_at', 'smp_deleted_at'], 'safe'],
            [['smp_nama'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'smp_id' => 'Smp ID',
            'smp_nama' => 'Smp Nama',
            'smp_aktif' => 'Smp Aktif',
            'smp_created_at' => 'Smp Created At',
            'smp_created_by' => 'Smp Created By',
            'smp_updated_at' => 'Smp Updated At',
            'smp_updated_by' => 'Smp Updated By',
            'smp_deleted_at' => 'Smp Deleted At',
            'smp_deleted_by' => 'Smp Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SdmMPangkatQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SdmMPangkatQuery(get_called_class());
    }
}
