<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pendaftaran_m_cara_masuk_unit".
 *
 * @property string $cmu_kode
 * @property string $cmu_nama
 * @property int $cmu_aktif
 * @property string|null $cmu_created_at
 * @property int $cmu_created_by
 * @property string|null $cmu_updated_at
 * @property int|null $cmu_updated_by
 * @property string|null $cmu_deleted_at
 * @property int|null $cmu_deleted_by
 */
class PendaftaranMCaraMasukUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran_m_cara_masuk_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cmu_kode', 'cmu_nama', 'cmu_created_by'], 'required'],
            [['cmu_aktif', 'cmu_created_by', 'cmu_updated_by', 'cmu_deleted_by'], 'integer'],
            [['cmu_created_at', 'cmu_updated_at', 'cmu_deleted_at'], 'safe'],
            [['cmu_kode'], 'string', 'max' => 10],
            [['cmu_nama'], 'string', 'max' => 255],
            [['cmu_kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cmu_kode' => 'Cmu Kode',
            'cmu_nama' => 'Cmu Nama',
            'cmu_aktif' => 'Cmu Aktif',
            'cmu_created_at' => 'Cmu Created At',
            'cmu_created_by' => 'Cmu Created By',
            'cmu_updated_at' => 'Cmu Updated At',
            'cmu_updated_by' => 'Cmu Updated By',
            'cmu_deleted_at' => 'Cmu Deleted At',
            'cmu_deleted_by' => 'Cmu Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PendaftaranMCaraMasukUnitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PendaftaranMCaraMasukUnitQuery(get_called_class());
    }
}
