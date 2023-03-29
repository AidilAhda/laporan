<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medis_m_tarif_kamar".
 *
 * @property int $tkr_id
 * @property int $tkr_kmr_id PK medis_kamar
 * @property int $tkr_skt_id PK medis_sk_tarif
 * @property int $tkr_biaya
 * @property string|null $tkr_created_at
 * @property int|null $tkr_created_by
 * @property string|null $tkr_updated_at
 * @property int|null $tkr_updated_by
 * @property string|null $tkr_deleted_at
 * @property int|null $tkr_deleted_by
 */
class MedisMTarifKamar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis_m_tarif_kamar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tkr_kmr_id', 'tkr_skt_id', 'tkr_biaya'], 'required'],
            [['tkr_kmr_id', 'tkr_skt_id', 'tkr_biaya', 'tkr_created_by', 'tkr_updated_by', 'tkr_deleted_by'], 'integer'],
            [['tkr_created_at', 'tkr_updated_at', 'tkr_deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tkr_id' => 'Tkr ID',
            'tkr_kmr_id' => 'Tkr Kmr ID',
            'tkr_skt_id' => 'Tkr Skt ID',
            'tkr_biaya' => 'Tkr Biaya',
            'tkr_created_at' => 'Tkr Created At',
            'tkr_created_by' => 'Tkr Created By',
            'tkr_updated_at' => 'Tkr Updated At',
            'tkr_updated_by' => 'Tkr Updated By',
            'tkr_deleted_at' => 'Tkr Deleted At',
            'tkr_deleted_by' => 'Tkr Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return MedisMTarifKamarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MedisMTarifKamarQuery(get_called_class());
    }
}
