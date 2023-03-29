<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pendaftaran_m_kiriman".
 *
 * @property string $pmkr_kode
 * @property string $pmkr_nama
 * @property int $pmkr_aktif
 * @property string|null $pmkr_created_at
 * @property int|null $pmkr_created_by
 * @property string|null $pmkr_updated_at
 * @property int|null $pmkr_updated_by
 * @property string|null $pmkr_deleted_at
 * @property int|null $pmkr_deleted_by
 */
class PendaftaranMKiriman extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran_m_kiriman';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pmkr_kode', 'pmkr_nama', 'pmkr_aktif'], 'required'],
            [['pmkr_aktif', 'pmkr_created_by', 'pmkr_updated_by', 'pmkr_deleted_by'], 'integer'],
            [['pmkr_created_at', 'pmkr_updated_at', 'pmkr_deleted_at'], 'safe'],
            [['pmkr_kode'], 'string', 'max' => 10],
            [['pmkr_nama'], 'string', 'max' => 255],
            [['pmkr_kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pmkr_kode' => 'Pmkr Kode',
            'pmkr_nama' => 'Pmkr Nama',
            'pmkr_aktif' => 'Pmkr Aktif',
            'pmkr_created_at' => 'Pmkr Created At',
            'pmkr_created_by' => 'Pmkr Created By',
            'pmkr_updated_at' => 'Pmkr Updated At',
            'pmkr_updated_by' => 'Pmkr Updated By',
            'pmkr_deleted_at' => 'Pmkr Deleted At',
            'pmkr_deleted_by' => 'Pmkr Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PendaftaranMKirimanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PendaftaranMKirimanQuery(get_called_class());
    }
}
