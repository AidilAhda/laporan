<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pendaftaran_m_penyakit".
 *
 * @property int $pmp_id
 * @property string $pmp_nama
 * @property int $pmp_aktif
 * @property string|null $pmp_created_at
 * @property int|null $pmp_created_by
 * @property string|null $pmp_updated_at
 * @property int|null $pmp_updated_by
 * @property string|null $pmp_deleted_at
 * @property int|null $pmp_deleted_by
 */
class PendaftaranMPenyakit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran_m_penyakit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pmp_nama'], 'required'],
            [['pmp_aktif', 'pmp_created_by', 'pmp_updated_by', 'pmp_deleted_by'], 'integer'],
            [['pmp_created_at', 'pmp_updated_at', 'pmp_deleted_at'], 'safe'],
            [['pmp_nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pmp_id' => 'Pmp ID',
            'pmp_nama' => 'Pmp Nama',
            'pmp_aktif' => 'Pmp Aktif',
            'pmp_created_at' => 'Pmp Created At',
            'pmp_created_by' => 'Pmp Created By',
            'pmp_updated_at' => 'Pmp Updated At',
            'pmp_updated_by' => 'Pmp Updated By',
            'pmp_deleted_at' => 'Pmp Deleted At',
            'pmp_deleted_by' => 'Pmp Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PendaftaranMPenyakitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PendaftaranMPenyakitQuery(get_called_class());
    }
}
