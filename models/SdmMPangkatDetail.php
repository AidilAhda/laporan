<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sdm_m_pangkat_detail".
 *
 * @property int $smpd_id
 * @property int $smpd_smp_id PK tb sdm_m_pangkat
 * @property string|null $smpd_alias
 * @property string $smpd_nama
 * @property int $smpd_aktif 1=y,0=n
 * @property string|null $smpd_created_at
 * @property int|null $smpd_created_by
 * @property string|null $smpd_updated_at
 * @property int|null $smpd_updated_by
 * @property string|null $smpd_deleted_at
 * @property int|null $smpd_deleted_by
 */
class SdmMPangkatDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sdm_m_pangkat_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['smpd_smp_id', 'smpd_nama', 'smpd_aktif'], 'required'],
            [['smpd_smp_id', 'smpd_aktif', 'smpd_created_by', 'smpd_updated_by', 'smpd_deleted_by'], 'integer'],
            [['smpd_created_at', 'smpd_updated_at', 'smpd_deleted_at'], 'safe'],
            [['smpd_alias'], 'string', 'max' => 50],
            [['smpd_nama'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'smpd_id' => 'Smpd ID',
            'smpd_smp_id' => 'Smpd Smp ID',
            'smpd_alias' => 'Smpd Alias',
            'smpd_nama' => 'Smpd Nama',
            'smpd_aktif' => 'Smpd Aktif',
            'smpd_created_at' => 'Smpd Created At',
            'smpd_created_by' => 'Smpd Created By',
            'smpd_updated_at' => 'Smpd Updated At',
            'smpd_updated_by' => 'Smpd Updated By',
            'smpd_deleted_at' => 'Smpd Deleted At',
            'smpd_deleted_by' => 'Smpd Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SdmMPangkatDetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SdmMPangkatDetailQuery(get_called_class());
    }
}
