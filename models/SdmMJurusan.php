<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sdm_m_jurusan".
 *
 * @property int $jur_id
 * @property string $jur_kode
 * @property string $jur_nama
 * @property int $jur_pdd_kode
 * @property int $jur_aktif 1=y,0=n
 * @property string|null $jur_created_at
 * @property int|null $jur_created_by
 * @property string|null $jur_updated_at
 * @property int|null $jur_updated_by
 * @property string|null $jur_deleted_at
 * @property int|null $jur_deleted_by
 */
class SdmMJurusan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sdm_m_jurusan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jur_kode', 'jur_nama', 'jur_pdd_kode', 'jur_aktif'], 'required'],
            [['jur_pdd_kode', 'jur_aktif', 'jur_created_by', 'jur_updated_by', 'jur_deleted_by'], 'integer'],
            [['jur_created_at', 'jur_updated_at', 'jur_deleted_at'], 'safe'],
            [['jur_kode'], 'string', 'max' => 10],
            [['jur_nama'], 'string', 'max' => 255],
            [['jur_kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'jur_id' => 'Jur ID',
            'jur_kode' => 'Jur Kode',
            'jur_nama' => 'Jur Nama',
            'jur_pdd_kode' => 'Jur Pdd Kode',
            'jur_aktif' => 'Jur Aktif',
            'jur_created_at' => 'Jur Created At',
            'jur_created_by' => 'Jur Created By',
            'jur_updated_at' => 'Jur Updated At',
            'jur_updated_by' => 'Jur Updated By',
            'jur_deleted_at' => 'Jur Deleted At',
            'jur_deleted_by' => 'Jur Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SdmMJurusanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SdmMJurusanQuery(get_called_class());
    }
}
