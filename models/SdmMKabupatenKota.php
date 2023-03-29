<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sdm_m_kabupaten_kota".
 *
 * @property int $kab_kode
 * @property string|null $kab_nama
 * @property int $kab_prv_kode
 * @property int $kab_aktif
 * @property string|null $kab_created_at
 * @property int|null $kab_created_by
 * @property string|null $kab_updated_at
 * @property int|null $kab_updated_by
 * @property string|null $kab_deleted_at
 * @property int|null $kab_deleted_by
 */
class SdmMKabupatenKota extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sdm_m_kabupaten_kota';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kab_kode', 'kab_prv_kode', 'kab_aktif'], 'required'],
            [['kab_kode', 'kab_prv_kode', 'kab_aktif', 'kab_created_by', 'kab_updated_by', 'kab_deleted_by'], 'integer'],
            [['kab_created_at', 'kab_updated_at', 'kab_deleted_at'], 'safe'],
            [['kab_nama'], 'string', 'max' => 100],
            [['kab_kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kab_kode' => 'Kab Kode',
            'kab_nama' => 'Kab Nama',
            'kab_prv_kode' => 'Kab Prv Kode',
            'kab_aktif' => 'Kab Aktif',
            'kab_created_at' => 'Kab Created At',
            'kab_created_by' => 'Kab Created By',
            'kab_updated_at' => 'Kab Updated At',
            'kab_updated_by' => 'Kab Updated By',
            'kab_deleted_at' => 'Kab Deleted At',
            'kab_deleted_by' => 'Kab Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SdmMKabupatenKotaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SdmMKabupatenKotaQuery(get_called_class());
    }

    public function getProvinsi()
    {
        return $this->hasOne(SdmMProvinsi::className(), ['prv_kode' => 'kab_prv_kode']);
    }
    public function getKecamatan()
    {
        return $this->hasMany(SdmMKecamatan::className(), ['kec_kab_kode' => 'kab_kode']);
    }
}
