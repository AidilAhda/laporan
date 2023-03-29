<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medis_m_tarif_tindakan_unit".
 *
 * @property int $ttu_id
 * @property int $ttu_tarif_tindakan_id
 * @property int $ttu_unit_id
 * @property int|null $ttu_jenis_tindakan 1=registrasi,2=konsultasi,3=tindakan
 * @property int|null $ttu_aktif 1=y,0=n
 * @property string|null $ttu_created_at
 * @property int|null $ttu_created_by
 * @property string|null $ttu_updated_at
 * @property int|null $ttu_updated_by
 * @property string|null $ttu_deleted_at
 * @property int|null $ttu_deleted_by
 */
class MedisMTarifTindakanUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis_m_tarif_tindakan_unit';
    }

     /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ttu_tarif_tindakan_id', 'ttu_unit_id'], 'required'],
            [['ttu_tarif_tindakan_id', 'ttu_unit_id', 'ttu_jenis_tindakan', 'ttu_aktif', 'ttu_created_by', 'ttu_updated_by', 'ttu_deleted_by'], 'integer'],
            [['ttu_created_at', 'ttu_updated_at', 'ttu_deleted_at'], 'safe'],
            [['ttu_tarif_tindakan_id', 'ttu_unit_id'], 'unique', 'targetAttribute' => ['ttu_tarif_tindakan_id', 'ttu_unit_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ttu_id' => 'Ttu ID',
            'ttu_tarif_tindakan_id' => 'Ttu Tarif Tindakan ID',
            'ttu_unit_id' => 'Ttu Unit ID',
            'ttu_jenis_tindakan' => 'Ttu Jenis Tindakan',
            'ttu_aktif' => 'Ttu Aktif',
            'ttu_created_at' => 'Ttu Created At',
            'ttu_created_by' => 'Ttu Created By',
            'ttu_updated_at' => 'Ttu Updated At',
            'ttu_updated_by' => 'Ttu Updated By',
            'ttu_deleted_at' => 'Ttu Deleted At',
            'ttu_deleted_by' => 'Ttu Deleted By',
        ];
    }
    /**
     * {@inheritdoc}
     * @return MedisMTarifTindakanUnitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MedisMTarifTindakanUnitQuery(get_called_class());
    }

    function getTarifTindakan()
    {
        return $this->hasOne(MedisMTarifTindakan::className(),['tft_id'=>'ttu_tarif_tindakan_id']);
    }
    function getUnit()
    {
        return $this->hasOne(SdmMUnit::className(),['unt_id'=>'ttu_unit_id']);
    }
}
