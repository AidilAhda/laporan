<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pendaftaran_m_cara_keluar".
 *
 * @property string $pmck_kode
 * @property string $pmck_nama
 * @property int $pmck_aktif 1=y,0=n
 * @property string|null $pmck_created_at
 * @property int|null $pmck_created_by
 * @property string|null $pmck_updated_at
 * @property int|null $pmck_updated_by
 * @property string|null $pmck_deleted_at
 * @property int|null $pmck_deleted_by
 */
class PendaftaranMCaraKeluar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran_m_cara_keluar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pmck_kode', 'pmck_nama', 'pmck_aktif'], 'required'],
            [['pmck_aktif', 'pmck_created_by', 'pmck_updated_by', 'pmck_deleted_by'], 'integer'],
            [['pmck_created_at', 'pmck_updated_at', 'pmck_deleted_at'], 'safe'],
            [['pmck_kode'], 'string', 'max' => 10],
            [['pmck_nama'], 'string', 'max' => 255],
            [['pmck_kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pmck_kode' => 'Pmck Kode',
            'pmck_nama' => 'Pmck Nama',
            'pmck_aktif' => 'Pmck Aktif',
            'pmck_created_at' => 'Pmck Created At',
            'pmck_created_by' => 'Pmck Created By',
            'pmck_updated_at' => 'Pmck Updated At',
            'pmck_updated_by' => 'Pmck Updated By',
            'pmck_deleted_at' => 'Pmck Deleted At',
            'pmck_deleted_by' => 'Pmck Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PendaftaranMCaraKeluarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PendaftaranMCaraKeluarQuery(get_called_class());
    }
}
