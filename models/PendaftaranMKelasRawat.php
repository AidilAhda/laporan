<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pendaftaran_m_kelas_rawat".
 *
 * @property string $kr_kode
 * @property string $kr_nama
 * @property int $kr_aktif
 * @property string|null $kr_created_at
 * @property int|null $kr_created_by
 * @property string|null $kr_updated_at
 * @property int|null $kr_updated_by
 * @property string|null $kr_deleted_at
 * @property int|null $kr_deleted_by
 */
class PendaftaranMKelasRawat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran_m_kelas_rawat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kr_kode', 'kr_nama', 'kr_aktif'], 'required'],
            [['kr_aktif', 'kr_created_by', 'kr_updated_by', 'kr_deleted_by'], 'integer'],
            [['kr_created_at', 'kr_updated_at', 'kr_deleted_at'], 'safe'],
            [['kr_kode'], 'string', 'max' => 3],
            [['kr_nama'], 'string', 'max' => 30],
            [['kr_kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kr_kode' => 'Kr Kode',
            'kr_nama' => 'Kr Nama',
            'kr_aktif' => 'Kr Aktif',
            'kr_created_at' => 'Kr Created At',
            'kr_created_by' => 'Kr Created By',
            'kr_updated_at' => 'Kr Updated At',
            'kr_updated_by' => 'Kr Updated By',
            'kr_deleted_at' => 'Kr Deleted At',
            'kr_deleted_by' => 'Kr Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PendaftaranMKelasRawatQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PendaftaranMKelasRawatQuery(get_called_class());
    }

    static public function getListKelas()
    {
        $data  = self::find()->select('kr_kode as id,kr_nama as kelas')->andWhere(['kr_aktif'=>1])->andWhere('kr_deleted_at is null')->asArray()->all();
        return $data;   
    }
}
