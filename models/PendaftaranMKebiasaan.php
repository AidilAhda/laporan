<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pendaftaran_m_kebiasaan".
 *
 * @property int $pmk_id
 * @property string $pmk_nama
 * @property int $pmk_aktif
 * @property string|null $pmk_created_at
 * @property int|null $pmk_created_by
 * @property string|null $pmk_updated_at
 * @property int|null $pmk_updated_by
 * @property string|null $pmk_deleted_at
 * @property int|null $pmk_deleted_by
 */
class PendaftaranMKebiasaan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran_m_kebiasaan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pmk_nama', 'pmk_aktif'], 'required'],
            [['pmk_aktif', 'pmk_created_by', 'pmk_updated_by', 'pmk_deleted_by'], 'integer'],
            [['pmk_created_at', 'pmk_updated_at', 'pmk_deleted_at'], 'safe'],
            [['pmk_nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pmk_id' => 'Pmk ID',
            'pmk_nama' => 'Pmk Nama',
            'pmk_aktif' => 'Pmk Aktif',
            'pmk_created_at' => 'Pmk Created At',
            'pmk_created_by' => 'Pmk Created By',
            'pmk_updated_at' => 'Pmk Updated At',
            'pmk_updated_by' => 'Pmk Updated By',
            'pmk_deleted_at' => 'Pmk Deleted At',
            'pmk_deleted_by' => 'Pmk Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PendaftaranMKebiasaanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PendaftaranMKebiasaanQuery(get_called_class());
    }
}
