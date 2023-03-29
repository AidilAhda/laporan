<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medis_m_tarif_tindakan".
 *
 * @property int $tft_id
 * @property string $tft_tindakan_id
 * @property string $tft_kelas_rawat_kode
 * @property string $tft_sk_tarif_id
 * @property int $tft_js_adm
 * @property int $tft_js_sarana
 * @property int $tft_js_bhp
 * @property int $tft_js_dokter_operator
 * @property int $tft_js_dokter_lainya
 * @property int $tft_js_dokter_anastesi
 * @property int $tft_js_penata_anastesi
 * @property int $tft_js_paramedis
 * @property int $tft_js_lainya
 * @property int $tft_js_adm_cto
 * @property int $tft_js_sarana_cto
 * @property int $tft_js_bhp_cto
 * @property int $tft_js_dokter_operator_cto
 * @property int $tft_js_dokter_lainya_cto
 * @property int $tft_js_dokter_anastesi_cto
 * @property int $tft_js_penata_anastesi_cto
 * @property int $tft_js_paramedis_cto
 * @property int $tft_js_lainya_cto
 * @property string|null $tft_created_at
 * @property int|null $tft_created_by
 * @property string|null $tft_updated_at
 * @property int|null $tft_updated_by
 * @property string|null $tft_deleted_at
 * @property int|null $tft_deleted_by
 */
class MedisMTarifTindakan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis_m_tarif_tindakan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tft_tindakan_id', 'tft_kelas_rawat_kode', 'tft_sk_tarif_id'], 'required'],
            [['tft_js_adm', 'tft_js_sarana', 'tft_js_bhp', 'tft_js_dokter_operator', 'tft_js_dokter_lainya', 'tft_js_dokter_anastesi', 'tft_js_penata_anastesi', 'tft_js_paramedis', 'tft_js_lainya', 'tft_js_adm_cto', 'tft_js_sarana_cto', 'tft_js_bhp_cto', 'tft_js_dokter_operator_cto', 'tft_js_dokter_lainya_cto', 'tft_js_dokter_anastesi_cto', 'tft_js_penata_anastesi_cto', 'tft_js_paramedis_cto', 'tft_js_lainya_cto', 'tft_created_by', 'tft_updated_by', 'tft_deleted_by'], 'integer'],
            [['tft_created_at', 'tft_updated_at', 'tft_deleted_at'], 'safe'],
            [['tft_tindakan_id', 'tft_kelas_rawat_kode', 'tft_sk_tarif_id'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tft_id' => 'Tft ID',
            'tft_tindakan_id' => 'Tft Tindakan ID',
            'tft_kelas_rawat_kode' => 'Tft Kelas Rawat Kode',
            'tft_sk_tarif_id' => 'Tft Sk Tarif ID',
            'tft_js_adm' => 'Tft Js Adm',
            'tft_js_sarana' => 'Tft Js Sarana',
            'tft_js_bhp' => 'Tft Js Bhp',
            'tft_js_dokter_operator' => 'Tft Js Dokter Operator',
            'tft_js_dokter_lainya' => 'Tft Js Dokter Lainya',
            'tft_js_dokter_anastesi' => 'Tft Js Dokter Anastesi',
            'tft_js_penata_anastesi' => 'Tft Js Penata Anastesi',
            'tft_js_paramedis' => 'Tft Js Paramedis',
            'tft_js_lainya' => 'Tft Js Lainya',
            'tft_js_adm_cto' => 'Tft Js Adm Cto',
            'tft_js_sarana_cto' => 'Tft Js Sarana Cto',
            'tft_js_bhp_cto' => 'Tft Js Bhp Cto',
            'tft_js_dokter_operator_cto' => 'Tft Js Dokter Operator Cto',
            'tft_js_dokter_lainya_cto' => 'Tft Js Dokter Lainya Cto',
            'tft_js_dokter_anastesi_cto' => 'Tft Js Dokter Anastesi Cto',
            'tft_js_penata_anastesi_cto' => 'Tft Js Penata Anastesi Cto',
            'tft_js_paramedis_cto' => 'Tft Js Paramedis Cto',
            'tft_js_lainya_cto' => 'Tft Js Lainya Cto',
            'tft_created_at' => 'Tft Created At',
            'tft_created_by' => 'Tft Created By',
            'tft_updated_at' => 'Tft Updated At',
            'tft_updated_by' => 'Tft Updated By',
            'tft_deleted_at' => 'Tft Deleted At',
            'tft_deleted_by' => 'Tft Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return MedisMTarifTindakanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MedisMTarifTindakanQuery(get_called_class());
    }

    function getTindakan()
    {
        return $this->hasOne(MedisMTindakan::className(),['tdk_id'=>'tft_tindakan_id']);
    }

}
