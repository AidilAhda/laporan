<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medis_m_kamar".
 *
 * @property int $kmr_id
 * @property int $kmr_unt_id PK sdm_m_unit
 * @property string $kmr_kr_kode PK pendaftaran_m_kelas_rawat
 * @property string $kmr_no_kamar
 * @property string $kmr_no_kasur
 * @property int|null $kmr_aktif 1=y,0=n
 * @property string|null $kmr_created_at
 * @property int|null $kmr_created_by
 * @property string|null $kmr_updated_at
 * @property int|null $kmr_updated_by
 * @property string|null $kmr_deleted_at
 * @property int|null $kmr_deleted_by
 */
class MedisMKamar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis_m_kamar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kmr_unt_id', 'kmr_kr_kode', 'kmr_no_kamar', 'kmr_no_kasur'], 'required'],
            [['kmr_unt_id', 'kmr_aktif', 'kmr_created_by', 'kmr_updated_by', 'kmr_deleted_by'], 'integer'],
            [['kmr_created_at', 'kmr_updated_at', 'kmr_deleted_at'], 'safe'],
            [['kmr_kr_kode'], 'string', 'max' => 3],
            [['kmr_no_kamar', 'kmr_no_kasur'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kmr_id' => 'Kmr ID',
            'kmr_unt_id' => 'Kmr Unt ID',
            'kmr_kr_kode' => 'Kmr Kr Kode',
            'kmr_no_kamar' => 'Kmr No Kamar',
            'kmr_no_kasur' => 'Kmr No Kasur',
            'kmr_aktif' => 'Kmr Aktif',
            'kmr_created_at' => 'Kmr Created At',
            'kmr_created_by' => 'Kmr Created By',
            'kmr_updated_at' => 'Kmr Updated At',
            'kmr_updated_by' => 'Kmr Updated By',
            'kmr_deleted_at' => 'Kmr Deleted At',
            'kmr_deleted_by' => 'Kmr Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return MedisMKamarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MedisMKamarQuery(get_called_class());
    }
    function getTarifkamar()
    {
        return $this->hasOne(MedisMTarifKamar::className(),['tkr_kmr_id'=>'kmr_id']);
    }    
}
