<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pendaftaran_m_status_keluar".
 *
 * @property string $pmsk_kode
 * @property string $pmsk_nama
 * @property int $pmsk_aktif 1=y,0=n
 * @property string|null $pmsk_created_at
 * @property int|null $pmsk_created_by
 * @property string|null $pmsk_updated_at
 * @property int|null $pmsk_updated_by
 * @property string|null $pmsk_deleted_at
 * @property int|null $pmsk_deleted_by
 */
class PendaftaranMStatusKeluar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran_m_status_keluar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pmsk_kode', 'pmsk_nama', 'pmsk_aktif'], 'required'],
            [['pmsk_aktif', 'pmsk_created_by', 'pmsk_updated_by', 'pmsk_deleted_by'], 'integer'],
            [['pmsk_created_at', 'pmsk_updated_at', 'pmsk_deleted_at'], 'safe'],
            [['pmsk_kode'], 'string', 'max' => 10],
            [['pmsk_nama'], 'string', 'max' => 255],
            [['pmsk_kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pmsk_kode' => 'Pmsk Kode',
            'pmsk_nama' => 'Pmsk Nama',
            'pmsk_aktif' => 'Pmsk Aktif',
            'pmsk_created_at' => 'Pmsk Created At',
            'pmsk_created_by' => 'Pmsk Created By',
            'pmsk_updated_at' => 'Pmsk Updated At',
            'pmsk_updated_by' => 'Pmsk Updated By',
            'pmsk_deleted_at' => 'Pmsk Deleted At',
            'pmsk_deleted_by' => 'Pmsk Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PendaftaranMStatusKeluarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PendaftaranMStatusKeluarQuery(get_called_class());
    }
}
