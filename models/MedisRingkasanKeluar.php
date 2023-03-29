<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medis_ringkasan_keluar".
 *
 * @property int $mrk_id
 * @property int $mrk_pl_id
 * @property int $mrk_dokter_pgw_id
 * @property string|null $mrk_pasien_keluarga
 * @property int|null $mrk_ruangan_id
 * @property string|null $mrk_tanggal_masuk
 * @property string|null $mrk_tanggal_keluar
 * @property string|null $mrk_diagnosa_pasien_masuk
 * @property string|null $mrk_anamnesa_masuk
 * @property string|null $mrk_pemeriksaan_fisik
 * @property string|null $mrk_hasil_pemeriksaan_penunjang
 * @property string|null $mrk_diagnosa_utama
 * @property string|null $mrk_diagnosa_tambahan1
 * @property string|null $mrk_diagnosa_tambahan2
 * @property string|null $mrk_diagnosa_tambahan3
 * @property string|null $mrk_diagnosa_tambahan4
 * @property string|null $mrk_diagnosa_tambahan5
 * @property string|null $mrk_diagnosa_utama_deskripsi
 * @property string|null $mrk_diagnosa_tambahan1_deskripsi
 * @property string|null $mrk_diagnosa_tambahan2_deskripsi
 * @property string|null $mrk_diagnosa_tambahan3_deskripsi
 * @property string|null $mrk_diagnosa_tambahan4_deskripsi
 * @property string|null $mrk_diagnosa_tambahan5_deskripsi
 * @property string|null $mrk_tindakan_utama
 * @property string|null $mrk_tindakan_tambahan1
 * @property string|null $mrk_tindakan_tambahan2
 * @property string|null $mrk_tindakan_tambahan3
 * @property string|null $mrk_tindakan_tambahan4
 * @property string|null $mrk_tindakan_tambahan5
 * @property string|null $mrk_tindakan_utama_deskripsi
 * @property string|null $mrk_tindakan_tambahan1_deskripsi
 * @property string|null $mrk_tindakan_tambahan2_deskripsi
 * @property string|null $mrk_tindakan_tambahan3_deskripsi
 * @property string|null $mrk_tindakan_tambahan4_deskripsi
 * @property string|null $mrk_tindakan_tambahan5_deskripsi
 * @property string|null $mrk_obat_selama_dirawat_dirs
 * @property string|null $mrk_kondisi_pulang
 * @property string|null $mrk_cara_keluar
 * @property string|null $mrk_obat_untuk_dirumah
 * @property string|null $mrk_instruksi_tindak_lanjut
 * @property int|null $mrk_final
 * @property string|null $mrk_tgl_final
 * @property int|null $mrk_batal
 * @property string|null $mrk_tgl_batal
 * @property int|null $mrk_mdcp_id
 * @property string|null $mrk_created_at
 * @property int|null $mrk_created_by
 * @property string|null $mrk_updated_at
 * @property int|null $mrk_updated_by
 * @property string|null $mrk_deleted_at
 * @property int|null $mrk_deleted_by
 */
class MedisRingkasanKeluar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis_ringkasan_keluar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mrk_pl_id', 'mrk_dokter_pgw_id'], 'required'],
            [['mrk_pl_id', 'mrk_dokter_pgw_id', 'mrk_ruangan_id', 'mrk_final', 'mrk_batal', 'mrk_mdcp_id', 'mrk_created_by', 'mrk_updated_by', 'mrk_deleted_by'], 'integer'],
            [['mrk_pasien_keluarga', 'mrk_diagnosa_pasien_masuk', 'mrk_anamnesa_masuk', 'mrk_pemeriksaan_fisik', 'mrk_hasil_pemeriksaan_penunjang', 'mrk_diagnosa_utama', 'mrk_diagnosa_tambahan1', 'mrk_diagnosa_tambahan2', 'mrk_diagnosa_tambahan3', 'mrk_diagnosa_tambahan4', 'mrk_diagnosa_tambahan5', 'mrk_diagnosa_utama_deskripsi', 'mrk_diagnosa_tambahan1_deskripsi', 'mrk_diagnosa_tambahan2_deskripsi', 'mrk_diagnosa_tambahan3_deskripsi', 'mrk_diagnosa_tambahan4_deskripsi', 'mrk_diagnosa_tambahan5_deskripsi', 'mrk_tindakan_utama', 'mrk_tindakan_tambahan1', 'mrk_tindakan_tambahan2', 'mrk_tindakan_tambahan3', 'mrk_tindakan_tambahan4', 'mrk_tindakan_tambahan5', 'mrk_tindakan_utama_deskripsi', 'mrk_tindakan_tambahan1_deskripsi', 'mrk_tindakan_tambahan2_deskripsi', 'mrk_tindakan_tambahan3_deskripsi', 'mrk_tindakan_tambahan4_deskripsi', 'mrk_tindakan_tambahan5_deskripsi', 'mrk_obat_selama_dirawat_dirs', 'mrk_kondisi_pulang', 'mrk_cara_keluar', 'mrk_obat_untuk_dirumah', 'mrk_instruksi_tindak_lanjut'], 'string'],
            [['mrk_tanggal_masuk', 'mrk_tanggal_keluar', 'mrk_tgl_final', 'mrk_tgl_batal', 'mrk_created_at', 'mrk_updated_at', 'mrk_deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mrk_id' => 'Mrk ID',
            'mrk_pl_id' => 'Mrk Pl ID',
            'mrk_dokter_pgw_id' => 'Mrk Dokter Pgw ID',
            'mrk_pasien_keluarga' => 'Mrk Pasien Keluarga',
            'mrk_ruangan_id' => 'Mrk Ruangan ID',
            'mrk_tanggal_masuk' => 'Mrk Tanggal Masuk',
            'mrk_tanggal_keluar' => 'Mrk Tanggal Keluar',
            'mrk_diagnosa_pasien_masuk' => 'Mrk Diagnosa Pasien Masuk',
            'mrk_anamnesa_masuk' => 'Mrk Anamnesa Masuk',
            'mrk_pemeriksaan_fisik' => 'Mrk Pemeriksaan Fisik',
            'mrk_hasil_pemeriksaan_penunjang' => 'Mrk Hasil Pemeriksaan Penunjang',
            'mrk_diagnosa_utama' => 'Mrk Diagnosa Utama',
            'mrk_diagnosa_tambahan1' => 'Mrk Diagnosa Tambahan1',
            'mrk_diagnosa_tambahan2' => 'Mrk Diagnosa Tambahan2',
            'mrk_diagnosa_tambahan3' => 'Mrk Diagnosa Tambahan3',
            'mrk_diagnosa_tambahan4' => 'Mrk Diagnosa Tambahan4',
            'mrk_diagnosa_tambahan5' => 'Mrk Diagnosa Tambahan5',
            'mrk_diagnosa_utama_deskripsi' => 'Mrk Diagnosa Utama Deskripsi',
            'mrk_diagnosa_tambahan1_deskripsi' => 'Mrk Diagnosa Tambahan1 Deskripsi',
            'mrk_diagnosa_tambahan2_deskripsi' => 'Mrk Diagnosa Tambahan2 Deskripsi',
            'mrk_diagnosa_tambahan3_deskripsi' => 'Mrk Diagnosa Tambahan3 Deskripsi',
            'mrk_diagnosa_tambahan4_deskripsi' => 'Mrk Diagnosa Tambahan4 Deskripsi',
            'mrk_diagnosa_tambahan5_deskripsi' => 'Mrk Diagnosa Tambahan5 Deskripsi',
            'mrk_tindakan_utama' => 'Mrk Tindakan Utama',
            'mrk_tindakan_tambahan1' => 'Mrk Tindakan Tambahan1',
            'mrk_tindakan_tambahan2' => 'Mrk Tindakan Tambahan2',
            'mrk_tindakan_tambahan3' => 'Mrk Tindakan Tambahan3',
            'mrk_tindakan_tambahan4' => 'Mrk Tindakan Tambahan4',
            'mrk_tindakan_tambahan5' => 'Mrk Tindakan Tambahan5',
            'mrk_tindakan_utama_deskripsi' => 'Mrk Tindakan Utama Deskripsi',
            'mrk_tindakan_tambahan1_deskripsi' => 'Mrk Tindakan Tambahan1 Deskripsi',
            'mrk_tindakan_tambahan2_deskripsi' => 'Mrk Tindakan Tambahan2 Deskripsi',
            'mrk_tindakan_tambahan3_deskripsi' => 'Mrk Tindakan Tambahan3 Deskripsi',
            'mrk_tindakan_tambahan4_deskripsi' => 'Mrk Tindakan Tambahan4 Deskripsi',
            'mrk_tindakan_tambahan5_deskripsi' => 'Mrk Tindakan Tambahan5 Deskripsi',
            'mrk_obat_selama_dirawat_dirs' => 'Mrk Obat Selama Dirawat Dirs',
            'mrk_kondisi_pulang' => 'Mrk Kondisi Pulang',
            'mrk_cara_keluar' => 'Mrk Cara Keluar',
            'mrk_obat_untuk_dirumah' => 'Mrk Obat Untuk Dirumah',
            'mrk_instruksi_tindak_lanjut' => 'Mrk Instruksi Tindak Lanjut',
            'mrk_final' => 'Mrk Final',
            'mrk_tgl_final' => 'Mrk Tgl Final',
            'mrk_batal' => 'Mrk Batal',
            'mrk_tgl_batal' => 'Mrk Tgl Batal',
            'mrk_mdcp_id' => 'Mrk Mdcp ID',
            'mrk_created_at' => 'Mrk Created At',
            'mrk_created_by' => 'Mrk Created By',
            'mrk_updated_at' => 'Mrk Updated At',
            'mrk_updated_by' => 'Mrk Updated By',
            'mrk_deleted_at' => 'Mrk Deleted At',
            'mrk_deleted_by' => 'Mrk Deleted By',
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
}
