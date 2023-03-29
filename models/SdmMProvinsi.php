<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sdm_m_provinsi".
 *
 * @property int $prv_kode
 * @property string|null $prv_nama
 * @property int $prv_aktif
 * @property string|null $prv_created_at
 * @property int|null $prv_created_by
 * @property string|null $prv_updated_at
 * @property int|null $prv_updated_by
 * @property string|null $prv_deleted_at
 * @property int|null $prv_deleted_by
 */
class SdmMProvinsi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sdm_m_provinsi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prv_kode', 'prv_aktif'], 'required'],
            [['prv_kode', 'prv_aktif', 'prv_created_by', 'prv_updated_by', 'prv_deleted_by'], 'integer'],
            [['prv_created_at', 'prv_updated_at', 'prv_deleted_at'], 'safe'],
            [['prv_nama'], 'string', 'max' => 100],
            [['prv_kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'prv_kode' => 'Prv Kode',
            'prv_nama' => 'Prv Nama',
            'prv_aktif' => 'Prv Aktif',
            'prv_created_at' => 'Prv Created At',
            'prv_created_by' => 'Prv Created By',
            'prv_updated_at' => 'Prv Updated At',
            'prv_updated_by' => 'Prv Updated By',
            'prv_deleted_at' => 'Prv Deleted At',
            'prv_deleted_by' => 'Prv Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SdmMProvinsiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SdmMProvinsiQuery(get_called_class());
    }
}
