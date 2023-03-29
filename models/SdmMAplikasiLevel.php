<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sdm_m_aplikasi_level".
 *
 * @property int $all_id
 * @property int $all_apl_id
 * @property string $all_nama
 * @property string|null $all_created_at
 * @property int|null $all_created_by
 * @property string|null $all_updated_at
 * @property int|null $all_updated_by
 * @property string|null $all_deleted_at
 * @property int|null $all_deleted_by
 */
class SdmMAplikasiLevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sdm_m_aplikasi_level';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['all_apl_id', 'all_nama'], 'required'],
            [['all_apl_id', 'all_created_by', 'all_updated_by', 'all_deleted_by'], 'integer'],
            [['all_created_at', 'all_updated_at', 'all_deleted_at'], 'safe'],
            [['all_nama'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'all_id' => 'All ID',
            'all_apl_id' => 'All Apl ID',
            'all_nama' => 'All Nama',
            'all_created_at' => 'All Created At',
            'all_created_by' => 'All Created By',
            'all_updated_at' => 'All Updated At',
            'all_updated_by' => 'All Updated By',
            'all_deleted_at' => 'All Deleted At',
            'all_deleted_by' => 'All Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SdmMAplikasiLevelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SdmMAplikasiLevelQuery(get_called_class());
    }
}
