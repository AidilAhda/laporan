<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medis_tindakan_pasien".
 *
 * @property int $tdp_id
 * @property int $tdp_pl_id FK pendaftaran_pelayanan
 * @property int $tdp_pgw_id pelaksana tindakan, FK sdm_m_pegawai
 * @property int $tdp_tft_id FK medis_m_tarif_tindakan
 * @property string $tdp_tgl
 * @property int $tdp_cyto default 0, jika 1 => cyto
 * @property int $tdp_jumlah
 * @property int $tdp_harga
 * @property int $tdp_subtotal
 * @property string|null $tdp_icd9_kode
 * @property string|null $tdp_icd9_deskripsi
 * @property string|null $tdp_ket
 * @property string|null $tdp_byr_kode bila sudah ada pembayaran maka update byr_kode FK tabel ebs_pembayaran_pasien
 * @property string $tdp_created_at
 * @property int $tdp_created_by
 * @property string|null $tdp_updated_at
 * @property int|null $tdp_updated_by
 * @property string|null $tdp_deleted_at
 * @property int|null $tdp_deleted_by
 */
class MedisTindakanPasien extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis_tindakan_pasien';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tdp_pl_id', 'tdp_pgw_id', 'tdp_tft_id', 'tdp_jumlah', 'tdp_harga', 'tdp_subtotal', 'tdp_created_by'], 'required'],
            [['tdp_pl_id', 'tdp_pgw_id', 'tdp_tft_id', 'tdp_cyto', 'tdp_jumlah', 'tdp_harga', 'tdp_subtotal', 'tdp_created_by', 'tdp_updated_by', 'tdp_deleted_by'], 'integer'],
            [['tdp_tgl', 'tdp_created_at', 'tdp_updated_at', 'tdp_deleted_at'], 'safe'],
            [['tdp_icd9_deskripsi', 'tdp_ket'], 'string'],
            [['tdp_icd9_kode'], 'string', 'max' => 100],
            [['tdp_byr_kode'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tdp_id' => 'Tdp ID',
            'tdp_pl_id' => 'Tdp Pl ID',
            'tdp_pgw_id' => 'Tdp Pgw ID',
            'tdp_tft_id' => 'Tdp Tft ID',
            'tdp_tgl' => 'Tdp Tgl',
            'tdp_cyto' => 'Tdp Cyto',
            'tdp_jumlah' => 'Tdp Jumlah',
            'tdp_harga' => 'Tdp Harga',
            'tdp_subtotal' => 'Tdp Subtotal',
            'tdp_icd9_kode' => 'Tdp Icd9 Kode',
            'tdp_icd9_deskripsi' => 'Tdp Icd9 Deskripsi',
            'tdp_ket' => 'Tdp Ket',
            'tdp_byr_kode' => 'Tdp Byr Kode',
            'tdp_created_at' => 'Tdp Created At',
            'tdp_created_by' => 'Tdp Created By',
            'tdp_updated_at' => 'Tdp Updated At',
            'tdp_updated_by' => 'Tdp Updated By',
            'tdp_deleted_at' => 'Tdp Deleted At',
            'tdp_deleted_by' => 'Tdp Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return MedisTindakanPasienQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MedisTindakanPasienQuery(get_called_class());
    }
    function getLayanan()
    {
        return $this->hasOne(PendaftaranLayanan::className(),['pl_id'=>'tdp_pl_id']);
    }
      function getTarifTindakan()
    {
        return $this->hasOne(MedisMTarifTindakan::className(),['tft_id'=>'tdp_tft_id']);
    }

      function getUser()
    {
        return $this->hasOne(SdmMPegawai::className(),['pgw_id'=>'tdp_pgw_id']);
    }
}
