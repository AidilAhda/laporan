<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pendaftaran_m_kelompok_unit_layanan".
 *
 * @property int $kul_id
 * @property int $kul_unit_id
 * @property int $kul_type 1=> IGD; 2=> RJ;3=>RAWATINAP;4=>PENUNJANG
 * @property int $kul_aktif 1=y,0=n
 * @property string $kul_tarif_tindakan_id
 * @property string|null $kul_created_at
 * @property int|null $kul_created_by
 * @property string|null $kul_updated_at
 * @property int|null $kul_updated_by
 * @property string|null $kul_deleted_at
 * @property int|null $kul_deleted_by
 */
class PendaftaranMKelompokUnitLayanan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran_m_kelompok_unit_layanan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kul_unit_id', 'kul_type', 'kul_aktif', 'kul_tarif_tindakan_id'], 'required'],
            [['kul_unit_id', 'kul_type', 'kul_aktif', 'kul_created_by', 'kul_updated_by', 'kul_deleted_by'], 'integer'],
            [['kul_tarif_tindakan_id'], 'string'],
            [['kul_created_at', 'kul_updated_at', 'kul_deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kul_id' => 'Kul ID',
            'kul_unit_id' => 'Kul Unit ID',
            'kul_type' => 'Kul Type',
            'kul_aktif' => 'Kul Aktif',
            'kul_tarif_tindakan_id' => 'Kul Tarif Tindakan ID',
            'kul_created_at' => 'Kul Created At',
            'kul_created_by' => 'Kul Created By',
            'kul_updated_at' => 'Kul Updated At',
            'kul_updated_by' => 'Kul Updated By',
            'kul_deleted_at' => 'Kul Deleted At',
            'kul_deleted_by' => 'Kul Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PendaftaranMKelompokUnitLayananQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PendaftaranMKelompokUnitLayananQuery(get_called_class());
    }
}
