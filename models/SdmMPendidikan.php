<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sdm_m_pendidikan".
 *
 * @property int $pdd_id
 * @property int $pdd_kode
 * @property string $pdd_nama
 * @property int $pdd_aktif
 * @property string|null $pdd_created_at
 * @property int|null $pdd_created_by
 * @property string|null $pdd_updated_at
 * @property int|null $pdd_updated_by
 * @property string|null $pdd_deleted_at
 * @property int|null $pdd_deleted_by
 */
class SdmMPendidikan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sdm_m_pendidikan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pdd_kode', 'pdd_nama', 'pdd_aktif'], 'required'],
            [['pdd_kode', 'pdd_aktif', 'pdd_created_by', 'pdd_updated_by', 'pdd_deleted_by'], 'integer'],
            [['pdd_created_at', 'pdd_updated_at', 'pdd_deleted_at'], 'safe'],
            [['pdd_nama'], 'string', 'max' => 100],
            [['pdd_kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pdd_id' => 'Pdd ID',
            'pdd_kode' => 'Pdd Kode',
            'pdd_nama' => 'Pdd Nama',
            'pdd_aktif' => 'Pdd Aktif',
            'pdd_created_at' => 'Pdd Created At',
            'pdd_created_by' => 'Pdd Created By',
            'pdd_updated_at' => 'Pdd Updated At',
            'pdd_updated_by' => 'Pdd Updated By',
            'pdd_deleted_at' => 'Pdd Deleted At',
            'pdd_deleted_by' => 'Pdd Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SdmMPendidikanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SdmMPendidikanQuery(get_called_class());
    }
}
