<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sdm_m_agama".
 *
 * @property int $agm_id
 * @property string $agm_nama
 * @property int $agm_aktif
 * @property string|null $agm_created_at
 * @property int|null $agm_created_by
 * @property string|null $agm_updated_at
 * @property int|null $agm_updated_by
 * @property string|null $agm_deleted_at
 * @property int|null $agm_deleted_by
 */
class JenisLaporan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pelaporan_jenis_laporan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['agm_nama'], 'required'],
            // [['agm_aktif', 'agm_created_by', 'agm_updated_by', 'agm_deleted_by'], 'integer'],
            // [['agm_created_at', 'agm_updated_at', 'agm_deleted_at'], 'safe'],
            // [['agm_nama'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'jl_id' => 'ID',
            'jl_nama' => 'Nama Format Laporan',
            'jl_aktif' => 'Status Aktif',
            'jl_created_at' => 'Created At',
            'jl_created_by' => 'Created By',
            'jl_updated_at' => 'Updated At',
            'jl_updated_by' => 'Updated By',
            'jl_deleted_at' => 'Deleted At',
            'jl_deleted_by' => 'Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return JenisLaporanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JenisLaporanQuery(get_called_class());
    }
}
