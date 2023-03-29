<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sdm_m_kesatuan".
 *
 * @property int $smk_id
 * @property string $smk_nama
 * @property int $smk_aktif 1=y,0=n
 * @property string|null $smk_created_at
 * @property int|null $smk_created_by
 * @property string|null $smk_updated_at
 * @property int|null $smk_updated_by
 * @property string|null $smk_deleted_at
 * @property int|null $smk_deleted_by
 */
class SdmMKesatuan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sdm_m_kesatuan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['smk_nama'], 'required'],
            [['smk_aktif', 'smk_created_by', 'smk_updated_by', 'smk_deleted_by'], 'integer'],
            [['smk_created_at', 'smk_updated_at', 'smk_deleted_at'], 'safe'],
            [['smk_nama'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'smk_id' => 'Smk ID',
            'smk_nama' => 'Smk Nama',
            'smk_aktif' => 'Smk Aktif',
            'smk_created_at' => 'Smk Created At',
            'smk_created_by' => 'Smk Created By',
            'smk_updated_at' => 'Smk Updated At',
            'smk_updated_by' => 'Smk Updated By',
            'smk_deleted_at' => 'Smk Deleted At',
            'smk_deleted_by' => 'Smk Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SdmMKesatuanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SdmMKesatuanQuery(get_called_class());
    }
}
