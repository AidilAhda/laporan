<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pendaftaran_m_kiriman_detail".
 *
 * @property string $pmkd_kode
 * @property string $pmkd_pmkr_kode PK pendaftaran_m_kiriman
 * @property string $pmkd_nama
 * @property int $pmkd_aktif
 * @property string|null $pmkd_created_at
 * @property int|null $pmkd_created_by
 * @property string|null $pmkd_updated_at
 * @property int|null $pmkd_updated_by
 * @property string|null $pmkd_deleted_at
 * @property int|null $pmkd_deleted_by
 */
class PendaftaranMKirimanDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran_m_kiriman_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pmkd_kode', 'pmkd_pmkr_kode', 'pmkd_nama', 'pmkd_aktif'], 'required'],
            [['pmkd_aktif', 'pmkd_created_by', 'pmkd_updated_by', 'pmkd_deleted_by'], 'integer'],
            [['pmkd_created_at', 'pmkd_updated_at', 'pmkd_deleted_at'], 'safe'],
            [['pmkd_kode', 'pmkd_pmkr_kode'], 'string', 'max' => 10],
            [['pmkd_nama'], 'string', 'max' => 255],
            [['pmkd_kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pmkd_kode' => 'Pmkd Kode',
            'pmkd_pmkr_kode' => 'Pmkd Pmkr Kode',
            'pmkd_nama' => 'Pmkd Nama',
            'pmkd_aktif' => 'Pmkd Aktif',
            'pmkd_created_at' => 'Pmkd Created At',
            'pmkd_created_by' => 'Pmkd Created By',
            'pmkd_updated_at' => 'Pmkd Updated At',
            'pmkd_updated_by' => 'Pmkd Updated By',
            'pmkd_deleted_at' => 'Pmkd Deleted At',
            'pmkd_deleted_by' => 'Pmkd Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PendaftaranMKirimanDetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PendaftaranMKirimanDetailQuery(get_called_class());
    }
}
