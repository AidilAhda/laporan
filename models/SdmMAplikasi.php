<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sdm_m_aplikasi".
 *
 * @property int $apl_id
 * @property string $apl_nama
 * @property string|null $apl_created_at
 * @property int|null $apl_created_by
 * @property string|null $apl_updated_at
 * @property int|null $apl_updated_by
 * @property string|null $apl_deleted_at
 * @property int|null $apl_deleted_by
 */
class SdmMAplikasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sdm_m_aplikasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apl_nama'], 'required'],
            [['apl_created_at', 'apl_updated_at', 'apl_deleted_at'], 'safe'],
            [['apl_created_by', 'apl_updated_by', 'apl_deleted_by'], 'integer'],
            [['apl_nama'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'apl_id' => 'Apl ID',
            'apl_nama' => 'Apl Nama',
            'apl_created_at' => 'Apl Created At',
            'apl_created_by' => 'Apl Created By',
            'apl_updated_at' => 'Apl Updated At',
            'apl_updated_by' => 'Apl Updated By',
            'apl_deleted_at' => 'Apl Deleted At',
            'apl_deleted_by' => 'Apl Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SdmMAplikasiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SdmMAplikasiQuery(get_called_class());
    }
}
