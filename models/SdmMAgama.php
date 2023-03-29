<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sdm_m_agama".
 *
 * @property int $agm_id
 * @property string $agm_nama
 * @property int $agm_aktif
 * @property string|null $agm_created_at
 * @property int|null $agm_created_by
 * @property string|null $agm_updated_at
 * @property int|null $agm_updated_by
 * @property string|null $agm_deleted_at
 * @property int|null $agm_deleted_by
 */
class SdmMAgama extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sdm_m_agama';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['agm_nama', 'agm_aktif'], 'required'],
            [['agm_aktif', 'agm_created_by', 'agm_updated_by', 'agm_deleted_by'], 'integer'],
            [['agm_created_at', 'agm_updated_at', 'agm_deleted_at'], 'safe'],
            [['agm_nama'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'agm_id' => 'ID',
            'agm_nama' => 'Agama',
            'agm_aktif' => 'Status Aktif',
            'agm_created_at' => 'Agm Created At',
            'agm_created_by' => 'Agm Created By',
            'agm_updated_at' => 'Agm Updated At',
            'agm_updated_by' => 'Agm Updated By',
            'agm_deleted_at' => 'Agm Deleted At',
            'agm_deleted_by' => 'Agm Deleted By',
        ];
    }
}
