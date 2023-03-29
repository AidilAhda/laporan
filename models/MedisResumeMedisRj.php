<?php

namespace app\models;

use Yii;
use app\models\PendaftaranLayanan;
use app\models\SdmMPegawai;

/**
 * This is the model class for table "medis_resume_medis_rj".
 *
 * @property int $rmrj_id
 * @property int $rmrj_pl_id FK pendaftaran_layanan
 * @property int $rmrj_dokter_id FK sdm_pegawai
 * @property string|null $rmrj_keluhan
 * @property string|null $rmrj_riwayat_penyakit
 * @property string|null $rmrj_tanda_vital_td_darah
 * @property string|null $rmrj_tanda_vital_td_nadi
 * @property string|null $rmrj_tanda_vital_td_pernapasan
 * @property string|null $rmrj_tanda_vital_td_suhu
 * @property string|null $rmrj_vas_nyeri
 * @property string|null $rmrj_pemeriksaan_fisik
 * @property string|null $rmrj_tindakan_diagnostik_labor
 * @property string|null $rmrj_tindakan_diagnostik_radiologi
 * @property string|null $rmrj_tindakan_diagnostik_lainya
 * @property string|null $rmrj_diagnosis_utama_kode
 * @property string|null $rmrj_diagnosis_utama_deskripsi
 * @property string|null $rmrj_diagnosis_tambahan1_kode
 * @property string|null $rmrj_diagnosis_tambahan1_deskripsi
 * @property string|null $rmrj_diagnosis_tambahan2_kode
 * @property string|null $rmrj_diagnosis_tambahan2_deskripsi
 * @property string|null $rmrj_diagnosis_tambahan3_kode
 * @property string|null $rmrj_diagnosis_tambahan3_deskripsi
 * @property string|null $rmrj_diagnosis_tambahan4_kode
 * @property string|null $rmrj_diagnosis_tambahan4_deskripsi
 * @property string|null $rmrj_diagnosis_tambahan5_kode
 * @property string|null $rmrj_diagnosis_tambahan5_deskripsi
 * @property string|null $rmrj_diagnosis_tambahan6_kode
 * @property string|null $rmrj_diagnosis_tambahan6_deskripsi
 * @property string|null $rmrj_diagnosis_tambahan7_kode
 * @property string|null $rmrj_diagnosis_tambahan7_deskripsi
 * @property string|null $rmrj_diagnosis_tambahan8_kode
 * @property string|null $rmrj_diagnosis_tambahan8_deskripsi
 * @property string|null $rmrj_diagnosis_tambahan9_kode
 * @property string|null $rmrj_diagnosis_tambahan9_deskripsi
 * @property string|null $rmrj_tindakan_utama_kode
 * @property string|null $rmrj_tindakan_utama_deskripsi
 * @property string|null $rmrj_tindakan_tambahan1_kode
 * @property string|null $rmrj_tindakan_tambahan1_deskripsi
 * @property string|null $rmrj_tindakan_tambahan2_kode
 * @property string|null $rmrj_tindakan_tambahan2_deskripsi
 * @property string|null $rmrj_tindakan_tambahan3_kode
 * @property string|null $rmrj_tindakan_tambahan3_deskripsi
 * @property string|null $rmrj_tindakan_tambahan4_kode
 * @property string|null $rmrj_tindakan_tambahan4_deskripsi
 * @property string|null $rmrj_tindakan_tambahan5_kode
 * @property string|null $rmrj_tindakan_tambahan5_deskripsi
 * @property string|null $rmrj_tindakan_tambahan6_kode
 * @property string|null $rmrj_tindakan_tambahan6_deskripsi
 * @property string|null $rmrj_tindakan_tambahan7_kode
 * @property string|null $rmrj_tindakan_tambahan7_deskripsi
 * @property string|null $rmrj_tindakan_tambahan8_kode
 * @property string|null $rmrj_tindakan_tambahan8_deskripsi
 * @property string|null $rmrj_tindakan_tambahan9_kode
 * @property string|null $rmrj_tindakan_tambahan9_deskripsi
 * @property string|null $rmrj_terapi
 * @property string|null $rmrj_status_keluar
 * @property string|null $rmrj_rencana_tindak_lanjut
 * @property string|null $rmrj_keterangan_lainya
 * @property int $rmrj_final
 * @property string|null $rmrj_tgl_final
 * @property int $rmrj_batal
 * @property string|null $rmrj_tgl_batal
 * @property int|null $rmrj_mdcp_id FK medis_doc_clinical_pasien	
 * @property string $rmrj_created_at
 * @property int $rmrj_created_by
 * @property string|null $rmrj_updated_at
 * @property int|null $rmrj_updated_by
 * @property string|null $rmrj_deleted_at
 * @property int|null $rmrj_deleted_by
 */
class MedisResumeMedisRj extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis_resume_medis_rj';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rmrj_pl_id', 'rmrj_dokter_id', 'rmrj_created_by'], 'required'],
            [['rmrj_pl_id', 'rmrj_dokter_id', 'rmrj_final', 'rmrj_batal', 'rmrj_mdcp_id', 'rmrj_created_by', 'rmrj_updated_by', 'rmrj_deleted_by'], 'integer'],
            [['rmrj_keluhan', 'rmrj_riwayat_penyakit', 'rmrj_tanda_vital_td_darah', 'rmrj_tanda_vital_td_nadi', 'rmrj_tanda_vital_td_pernapasan', 'rmrj_tanda_vital_td_suhu', 'rmrj_vas_nyeri', 'rmrj_pemeriksaan_fisik', 'rmrj_tindakan_diagnostik_labor', 'rmrj_tindakan_diagnostik_radiologi', 'rmrj_tindakan_diagnostik_lainya', 'rmrj_diagnosis_utama_kode', 'rmrj_diagnosis_utama_deskripsi', 'rmrj_diagnosis_tambahan1_kode', 'rmrj_diagnosis_tambahan1_deskripsi', 'rmrj_diagnosis_tambahan2_kode', 'rmrj_diagnosis_tambahan2_deskripsi', 'rmrj_diagnosis_tambahan3_kode', 'rmrj_diagnosis_tambahan3_deskripsi', 'rmrj_diagnosis_tambahan4_kode', 'rmrj_diagnosis_tambahan4_deskripsi', 'rmrj_diagnosis_tambahan5_kode', 'rmrj_diagnosis_tambahan5_deskripsi', 'rmrj_diagnosis_tambahan6_kode', 'rmrj_diagnosis_tambahan6_deskripsi', 'rmrj_diagnosis_tambahan7_kode', 'rmrj_diagnosis_tambahan7_deskripsi', 'rmrj_diagnosis_tambahan8_kode', 'rmrj_diagnosis_tambahan8_deskripsi', 'rmrj_diagnosis_tambahan9_kode', 'rmrj_diagnosis_tambahan9_deskripsi', 'rmrj_tindakan_utama_kode', 'rmrj_tindakan_utama_deskripsi', 'rmrj_tindakan_tambahan1_kode', 'rmrj_tindakan_tambahan1_deskripsi', 'rmrj_tindakan_tambahan2_kode', 'rmrj_tindakan_tambahan2_deskripsi', 'rmrj_tindakan_tambahan3_kode', 'rmrj_tindakan_tambahan3_deskripsi', 'rmrj_tindakan_tambahan4_kode', 'rmrj_tindakan_tambahan4_deskripsi', 'rmrj_tindakan_tambahan5_kode', 'rmrj_tindakan_tambahan5_deskripsi', 'rmrj_tindakan_tambahan6_kode', 'rmrj_tindakan_tambahan6_deskripsi', 'rmrj_tindakan_tambahan7_kode', 'rmrj_tindakan_tambahan7_deskripsi', 'rmrj_tindakan_tambahan8_kode', 'rmrj_tindakan_tambahan8_deskripsi', 'rmrj_tindakan_tambahan9_kode', 'rmrj_tindakan_tambahan9_deskripsi', 'rmrj_terapi', 'rmrj_status_keluar', 'rmrj_rencana_tindak_lanjut', 'rmrj_keterangan_lainya'], 'string'],
            [['rmrj_tgl_final', 'rmrj_tgl_batal', 'rmrj_created_at', 'rmrj_updated_at', 'rmrj_deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rmrj_id' => 'Rmrj ID',
            'rmrj_pl_id' => 'Rmrj Pl ID',
            'rmrj_dokter_id' => 'Rmrj Dokter ID',
            'rmrj_keluhan' => 'Rmrj Keluhan',
            'rmrj_riwayat_penyakit' => 'Rmrj Riwayat Penyakit',
            'rmrj_tanda_vital_td_darah' => 'Rmrj Tanda Vital Td Darah',
            'rmrj_tanda_vital_td_nadi' => 'Rmrj Tanda Vital Td Nadi',
            'rmrj_tanda_vital_td_pernapasan' => 'Rmrj Tanda Vital Td Pernapasan',
            'rmrj_tanda_vital_td_suhu' => 'Rmrj Tanda Vital Td Suhu',
            'rmrj_vas_nyeri' => 'Rmrj Vas Nyeri',
            'rmrj_pemeriksaan_fisik' => 'Rmrj Pemeriksaan Fisik',
            'rmrj_tindakan_diagnostik_labor' => 'Rmrj Tindakan Diagnostik Labor',
            'rmrj_tindakan_diagnostik_radiologi' => 'Rmrj Tindakan Diagnostik Radiologi',
            'rmrj_tindakan_diagnostik_lainya' => 'Rmrj Tindakan Diagnostik Lainya',
            'rmrj_diagnosis_utama_kode' => 'Rmrj Diagnosis Utama Kode',
            'rmrj_diagnosis_utama_deskripsi' => 'Rmrj Diagnosis Utama Deskripsi',
            'rmrj_diagnosis_tambahan1_kode' => 'Rmrj Diagnosis Tambahan1 Kode',
            'rmrj_diagnosis_tambahan1_deskripsi' => 'Rmrj Diagnosis Tambahan1 Deskripsi',
            'rmrj_diagnosis_tambahan2_kode' => 'Rmrj Diagnosis Tambahan2 Kode',
            'rmrj_diagnosis_tambahan2_deskripsi' => 'Rmrj Diagnosis Tambahan2 Deskripsi',
            'rmrj_diagnosis_tambahan3_kode' => 'Rmrj Diagnosis Tambahan3 Kode',
            'rmrj_diagnosis_tambahan3_deskripsi' => 'Rmrj Diagnosis Tambahan3 Deskripsi',
            'rmrj_diagnosis_tambahan4_kode' => 'Rmrj Diagnosis Tambahan4 Kode',
            'rmrj_diagnosis_tambahan4_deskripsi' => 'Rmrj Diagnosis Tambahan4 Deskripsi',
            'rmrj_diagnosis_tambahan5_kode' => 'Rmrj Diagnosis Tambahan5 Kode',
            'rmrj_diagnosis_tambahan5_deskripsi' => 'Rmrj Diagnosis Tambahan5 Deskripsi',
            'rmrj_diagnosis_tambahan6_kode' => 'Rmrj Diagnosis Tambahan6 Kode',
            'rmrj_diagnosis_tambahan6_deskripsi' => 'Rmrj Diagnosis Tambahan6 Deskripsi',
            'rmrj_diagnosis_tambahan7_kode' => 'Rmrj Diagnosis Tambahan7 Kode',
            'rmrj_diagnosis_tambahan7_deskripsi' => 'Rmrj Diagnosis Tambahan7 Deskripsi',
            'rmrj_diagnosis_tambahan8_kode' => 'Rmrj Diagnosis Tambahan8 Kode',
            'rmrj_diagnosis_tambahan8_deskripsi' => 'Rmrj Diagnosis Tambahan8 Deskripsi',
            'rmrj_diagnosis_tambahan9_kode' => 'Rmrj Diagnosis Tambahan9 Kode',
            'rmrj_diagnosis_tambahan9_deskripsi' => 'Rmrj Diagnosis Tambahan9 Deskripsi',
            'rmrj_tindakan_utama_kode' => 'Rmrj Tindakan Utama Kode',
            'rmrj_tindakan_utama_deskripsi' => 'Rmrj Tindakan Utama Deskripsi',
            'rmrj_tindakan_tambahan1_kode' => 'Rmrj Tindakan Tambahan1 Kode',
            'rmrj_tindakan_tambahan1_deskripsi' => 'Rmrj Tindakan Tambahan1 Deskripsi',
            'rmrj_tindakan_tambahan2_kode' => 'Rmrj Tindakan Tambahan2 Kode',
            'rmrj_tindakan_tambahan2_deskripsi' => 'Rmrj Tindakan Tambahan2 Deskripsi',
            'rmrj_tindakan_tambahan3_kode' => 'Rmrj Tindakan Tambahan3 Kode',
            'rmrj_tindakan_tambahan3_deskripsi' => 'Rmrj Tindakan Tambahan3 Deskripsi',
            'rmrj_tindakan_tambahan4_kode' => 'Rmrj Tindakan Tambahan4 Kode',
            'rmrj_tindakan_tambahan4_deskripsi' => 'Rmrj Tindakan Tambahan4 Deskripsi',
            'rmrj_tindakan_tambahan5_kode' => 'Rmrj Tindakan Tambahan5 Kode',
            'rmrj_tindakan_tambahan5_deskripsi' => 'Rmrj Tindakan Tambahan5 Deskripsi',
            'rmrj_tindakan_tambahan6_kode' => 'Rmrj Tindakan Tambahan6 Kode',
            'rmrj_tindakan_tambahan6_deskripsi' => 'Rmrj Tindakan Tambahan6 Deskripsi',
            'rmrj_tindakan_tambahan7_kode' => 'Rmrj Tindakan Tambahan7 Kode',
            'rmrj_tindakan_tambahan7_deskripsi' => 'Rmrj Tindakan Tambahan7 Deskripsi',
            'rmrj_tindakan_tambahan8_kode' => 'Rmrj Tindakan Tambahan8 Kode',
            'rmrj_tindakan_tambahan8_deskripsi' => 'Rmrj Tindakan Tambahan8 Deskripsi',
            'rmrj_tindakan_tambahan9_kode' => 'Rmrj Tindakan Tambahan9 Kode',
            'rmrj_tindakan_tambahan9_deskripsi' => 'Rmrj Tindakan Tambahan9 Deskripsi',
            'rmrj_terapi' => 'Rmrj Terapi',
            'rmrj_status_keluar' => 'Rmrj Status Keluar',
            'rmrj_rencana_tindak_lanjut' => 'Rmrj Rencana Tindak Lanjut',
            'rmrj_keterangan_lainya' => 'Rmrj Keterangan Lainya',
            'rmrj_final' => 'Rmrj Final',
            'rmrj_tgl_final' => 'Rmrj Tgl Final',
            'rmrj_batal' => 'Rmrj Batal',
            'rmrj_tgl_batal' => 'Rmrj Tgl Batal',
            'rmrj_mdcp_id' => 'Rmrj Mdcp ID',
            'rmrj_created_at' => 'Rmrj Created At',
            'rmrj_created_by' => 'Rmrj Created By',
            'rmrj_updated_at' => 'Rmrj Updated At',
            'rmrj_updated_by' => 'Rmrj Updated By',
            'rmrj_deleted_at' => 'Rmrj Deleted At',
            'rmrj_deleted_by' => 'Rmrj Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return MedisMQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MedisMQuery(get_called_class());
    }

    function getLayanan()
    {
        return $this->hasOne(PendaftaranLayanan::className(),['pl_id' => 'rmrj_pl_id']);
    }
    function getDokter()
    {
        return $this->hasOne(SdmMPegawai::className(),['pgw_id' => 'rmrj_dokter_id']);
    }

}