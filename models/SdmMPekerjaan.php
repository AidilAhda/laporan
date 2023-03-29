<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sdm_m_pekerjaan".
 *
 * @property int $pkj_id
 * @property string|null $pkj_nama
 * @property int $pkj_aktif
 * @property string|null $pkj_created_at
 * @property int|null $pkj_created_by
 * @property string|null $pkj_updated_at
 * @property int|null $pkj_updated_by
 * @property string|null $pkj_deleted_at
 * @property int|null $pkj_deleted_by
 */
class SdmMPekerjaan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sdm_m_pekerjaan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pkj_aktif'], 'required'],
            [['pkj_aktif', 'pkj_created_by', 'pkj_updated_by', 'pkj_deleted_by'], 'integer'],
            [['pkj_created_at', 'pkj_updated_at', 'pkj_deleted_at'], 'safe'],
            [['pkj_nama'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pkj_id' => 'Pkj ID',
            'pkj_nama' => 'Pkj Nama',
            'pkj_aktif' => 'Pkj Aktif',
            'pkj_created_at' => 'Pkj Created At',
            'pkj_created_by' => 'Pkj Created By',
            'pkj_updated_at' => 'Pkj Updated At',
            'pkj_updated_by' => 'Pkj Updated By',
            'pkj_deleted_at' => 'Pkj Deleted At',
            'pkj_deleted_by' => 'Pkj Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SdmMPekerjaanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SdmMPekerjaanQuery(get_called_class());
    }
}
