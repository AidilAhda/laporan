<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sdm_m_kecamatan".
 *
 * @property int $kec_kode
 * @property string|null $kec_nama
 * @property int $kec_kab_kode
 * @property int $kec_aktif
 * @property string|null $kec_created_at
 * @property int|null $kec_created_by
 * @property string|null $kec_updated_at
 * @property int|null $kec_updated_by
 * @property string|null $kec_deleted_at
 * @property int|null $kec_deleted_by
 */
class SdmMKecamatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sdm_m_kecamatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kec_kode', 'kec_kab_kode', 'kec_aktif'], 'required'],
            [['kec_kode', 'kec_kab_kode', 'kec_aktif', 'kec_created_by', 'kec_updated_by', 'kec_deleted_by'], 'integer'],
            [['kec_created_at', 'kec_updated_at', 'kec_deleted_at'], 'safe'],
            [['kec_nama'], 'string', 'max' => 100],
            [['kec_kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kec_kode' => 'Kec Kode',
            'kec_nama' => 'Kec Nama',
            'kec_kab_kode' => 'Kec Kab Kode',
            'kec_aktif' => 'Kec Aktif',
            'kec_created_at' => 'Kec Created At',
            'kec_created_by' => 'Kec Created By',
            'kec_updated_at' => 'Kec Updated At',
            'kec_updated_by' => 'Kec Updated By',
            'kec_deleted_at' => 'Kec Deleted At',
            'kec_deleted_by' => 'Kec Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SdmMKecamatanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SdmMKecamatanQuery(get_called_class());
    }

    function getKabupaten()
    {
        return $this->hasOne(SdmMKabupatenKota::className(),['kab_kode'=>'kec_kab_kode']);
    }
    function getKelurahan()
    {
        return $this->hasOne(SdmMKelurahanDesa::className(),['kel_kec_kode'=>'kec_kode']);
    }
}
