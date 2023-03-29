<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sdm_m_kelurahan_desa".
 *
 * @property int $kel_kode
 * @property string|null $kel_nama
 * @property int $kel_kec_kode
 * @property int $kel_aktif
 * @property string|null $kel_created_at
 * @property int|null $kel_created_by
 * @property string|null $kel_updated_at
 * @property int|null $kel_updated_by
 * @property string|null $kel_deleted_at
 * @property int|null $kel_deleted_by
 */
class SdmMKelurahanDesa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sdm_m_kelurahan_desa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kel_kode', 'kel_kec_kode', 'kel_aktif'], 'required'],
            [['kel_kode', 'kel_kec_kode', 'kel_aktif', 'kel_created_by', 'kel_updated_by', 'kel_deleted_by'], 'integer'],
            [['kel_created_at', 'kel_updated_at', 'kel_deleted_at'], 'safe'],
            [['kel_nama'], 'string', 'max' => 100],
            [['kel_kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kel_kode' => 'Kel Kode',
            'kel_nama' => 'Kel Nama',
            'kel_kec_kode' => 'Kel Kec Kode',
            'kel_aktif' => 'Kel Aktif',
            'kel_created_at' => 'Kel Created At',
            'kel_created_by' => 'Kel Created By',
            'kel_updated_at' => 'Kel Updated At',
            'kel_updated_by' => 'Kel Updated By',
            'kel_deleted_at' => 'Kel Deleted At',
            'kel_deleted_by' => 'Kel Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SdmMKelurahanDesaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SdmMKelurahanDesaQuery(get_called_class());
    }
       function getKecamatan()
    {
        return $this->hasOne(SdmMKecamatan::className(),['kec_kode'=>'kel_kec_kode']);
    }
}

