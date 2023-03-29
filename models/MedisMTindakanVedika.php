<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medis_m_tindakan".
 *
 * @property int $tdvdk_id
 * @property int $tdvdk_parent_id
 * @property string $tdvdk_deskripsi
 * @property int|null $tdvdk_aktif 1=y,0=n
 * @property string $tdvdk_kode_jenis
 * @property string|null $tdvdk_created_at
 * @property int|null $tdvdk_created_by
 * @property string|null $tdvdk_updated_at
 * @property int|null $tdvdk_updated_by
 * @property string|null $tdvdk_deleted_at
 * @property int|null $tdvdk_deleted_by
 */
class MedisMTindakanVedika extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis_m_tindakan_vedika';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tdvdk_id' => 'tdvdk ID',
            'tdvdk_deskripsi' => 'tdvdk Parent ID',
            'tdvdk_aktif' => 'tdvdk Deskripsi',
            'tdvdk_created_at' => 'tdvdk Created At',
            'tdvdk_created_by' => 'tdvdk Created By',
            'tdvdk_updated_at' => 'tdvdk Updated At',
            'tdvdk_updated_by' => 'tdvdk Updated By',
            'tdvdk_deleted_at' => 'tdvdk Deleted At',
            'tdvdk_deleted_by' => 'tdvdk Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return MedisMTindakanVedikaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MedisMTindakanVedikaQuery(get_called_class());
    }
}
