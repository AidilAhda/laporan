<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pendaftaran_biaya_rawatjalan".
 *
 * @property int $pbr_id
 * @property int $pbr_unt_id PK sdm_m_unit
 * @property int $pbr_tft_id PK medis_m_tarif_tindakan
 * @property int $pbr_aktif 1=y,0=n
 * @property string|null $pbr_created_at
 * @property int|null $pbr_created_by
 * @property string|null $pbr_updated_at
 * @property int|null $pbr_updated_by
 * @property string|null $pbr_deleted_at
 * @property int|null $pbr_deleted_by
 */
class PendaftaranBiayaRawatjalan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran_biaya_rawatjalan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pbr_unt_id', 'pbr_tft_id', 'pbr_aktif'], 'required'],
            [['pbr_unt_id', 'pbr_tft_id', 'pbr_aktif', 'pbr_created_by', 'pbr_updated_by', 'pbr_deleted_by'], 'integer'],
            [['pbr_created_at', 'pbr_updated_at', 'pbr_deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pbr_id' => 'Pbr ID',
            'pbr_unt_id' => 'Pbr Unt ID',
            'pbr_tft_id' => 'Pbr Tft ID',
            'pbr_aktif' => 'Pbr Aktif',
            'pbr_created_at' => 'Pbr Created At',
            'pbr_created_by' => 'Pbr Created By',
            'pbr_updated_at' => 'Pbr Updated At',
            'pbr_updated_by' => 'Pbr Updated By',
            'pbr_deleted_at' => 'Pbr Deleted At',
            'pbr_deleted_by' => 'Pbr Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PendaftaranBiayaRawatjalanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PendaftaranBiayaRawatjalanQuery(get_called_class());
    }

    function getUnit()
    {
        return $this->hasOne(SdmMUnit::className(),['unt_id'=>'pbr_unt_id']);
    }

    function getTarifTindakan()
    {
        return $this->hasOne(MedisMTarifTindakan::className(),['tft_id'=>'pbr_tft_id']);
    }
}
