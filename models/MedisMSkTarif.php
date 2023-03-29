<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medis_m_sk_tarif".
 *
 * @property int $stf_id
 * @property string $stf_nomor
 * @property string $stf_tanggal
 * @property string $stf_keterangan
 * @property int|null $stf_aktif 1=y,0=n
 * @property string|null $stf_created_at
 * @property int|null $stf_created_by
 * @property string|null $stf_updated_at
 * @property int|null $stf_updated_by
 * @property string|null $stf_deleted_at
 * @property int|null $stf_deleted_by
 */
class MedisMSkTarif extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis_m_sk_tarif';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['stf_nomor', 'stf_tanggal', 'stf_keterangan'], 'required'],
            [['stf_tanggal', 'stf_created_at', 'stf_updated_at', 'stf_deleted_at'], 'safe'],
            [['stf_aktif', 'stf_created_by', 'stf_updated_by', 'stf_deleted_by'], 'integer'],
            [['stf_nomor', 'stf_keterangan'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'stf_id' => 'Stf ID',
            'stf_nomor' => 'Stf Nomor',
            'stf_tanggal' => 'Stf Tanggal',
            'stf_keterangan' => 'Stf Keterangan',
            'stf_aktif' => 'Stf Aktif',
            'stf_created_at' => 'Stf Created At',
            'stf_created_by' => 'Stf Created By',
            'stf_updated_at' => 'Stf Updated At',
            'stf_updated_by' => 'Stf Updated By',
            'stf_deleted_at' => 'Stf Deleted At',
            'stf_deleted_by' => 'Stf Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return MedisMSkTarifQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MedisMSkTarifQuery(get_called_class());
    }
}
