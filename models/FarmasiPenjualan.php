<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "farmasi_penjualan".
 *
 * @property int $pnj_id
 * @property int $pnj_depo_id
 * @property string $pnj_no_rm
 * @property string $pnj_nama_pasien
 * @property string|null $pnj_nik
 * @property string|null $pnj_jenis_kelamin
 * @property string|null $pnj_tanggal_lahir
 * @property string|null $pnj_umur
 * @property int|null $pnj_berat_badan
 * @property int|null $pnj_tinggi_badan
 * @property string|null $pnj_riwayat_alergi
 * @property string|null $pnj_alamat
 * @property string $pnj_status_pasien
 * @property string|null $pnj_no_daftar
 * @property string|null $pnj_is_id_baru
 * @property string|null $pnj_is_backdate
 * @property int|null $pnj_resep_id
 * @property string $pnj_tanggal_resep
 * @property int $pnj_unit_id
 * @property int $pnj_dokter_id
 * @property string $pnj_dokter_sip
 * @property int|null $pnj_penjamin_id
 * @property string $pnj_nama_dokter
 * @property string $pnj_no_sep
 * @property int $pnj_tipe_pembayaran
 * @property string|null $pnj_is_kronis
 * @property int|null $pnj_bayar_id
 * @property string|null $pnj_tgl_pembayaran
 * @property int $pnj_total_penjualan
 * @property int|null $pnj_total_dijamin
 * @property int|null $pnj_total_dibayar
 * @property int|null $pnj_total_retur
 * @property string|null $pnj_racikan
 * @property string|null $pnj_catatan
 * @property string|null $pnj_diagnosis
 * @property int|null $pnj_status
 * @property string|null $pnj_created_at
 * @property int $pnj_created_by
 * @property string|null $pnj_updated_at
 * @property int|null $pnj_updated_by
 * @property string|null $pnj_deleted_at
 * @property int|null $pnj_deleted_by
 * @property string|null $pnj_no_transaksi
 * @property string|null $pnj_jam_resep
 */
class FarmasiPenjualan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'farmasi_penjualan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pnj_depo_id', 'pnj_no_rm', 'pnj_nama_pasien', 'pnj_status_pasien', 'pnj_tanggal_resep', 'pnj_unit_id', 'pnj_dokter_id', 'pnj_dokter_sip', 'pnj_nama_dokter', 'pnj_no_sep', 'pnj_tipe_pembayaran', 'pnj_total_penjualan'], 'required'],
            [['pnj_depo_id', 'pnj_berat_badan', 'pnj_tinggi_badan', 'pnj_resep_id', 'pnj_unit_id', 'pnj_dokter_id', 'pnj_penjamin_id', 'pnj_tipe_pembayaran', 'pnj_bayar_id', 'pnj_total_penjualan', 'pnj_total_dijamin', 'pnj_total_dibayar', 'pnj_total_retur', 'pnj_status', 'pnj_created_by', 'pnj_updated_by', 'pnj_deleted_by'], 'integer'],
            [['pnj_tanggal_lahir', 'pnj_tanggal_resep', 'pnj_tgl_pembayaran', 'pnj_created_at', 'pnj_updated_at', 'pnj_deleted_at', 'pnj_jam_resep'], 'safe'],
            [['pnj_alamat', 'pnj_is_id_baru', 'pnj_is_backdate', 'pnj_is_kronis', 'pnj_racikan', 'pnj_catatan', 'pnj_diagnosis'], 'string'],
            [['pnj_no_rm', 'pnj_nama_pasien', 'pnj_nik', 'pnj_jenis_kelamin', 'pnj_umur', 'pnj_riwayat_alergi', 'pnj_status_pasien', 'pnj_no_daftar', 'pnj_dokter_sip', 'pnj_nama_dokter', 'pnj_no_sep', 'pnj_no_transaksi'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pnj_id' => 'Pnj ID',
            'pnj_depo_id' => 'Pnj Depo ID',
            'pnj_no_rm' => 'Pnj No Rm',
            'pnj_nama_pasien' => 'Pnj Nama Pasien',
            'pnj_nik' => 'Pnj Nik',
            'pnj_jenis_kelamin' => 'Pnj Jenis Kelamin',
            'pnj_tanggal_lahir' => 'Pnj Tanggal Lahir',
            'pnj_umur' => 'Pnj Umur',
            'pnj_berat_badan' => 'Pnj Berat Badan',
            'pnj_tinggi_badan' => 'Pnj Tinggi Badan',
            'pnj_riwayat_alergi' => 'Pnj Riwayat Alergi',
            'pnj_alamat' => 'Pnj Alamat',
            'pnj_status_pasien' => 'Pnj Status Pasien',
            'pnj_no_daftar' => 'Pnj No Daftar',
            'pnj_is_id_baru' => 'Pnj Is Id Baru',
            'pnj_is_backdate' => 'Pnj Is Backdate',
            'pnj_resep_id' => 'Pnj Resep ID',
            'pnj_tanggal_resep' => 'Pnj Tanggal Resep',
            'pnj_unit_id' => 'Pnj Unit ID',
            'pnj_dokter_id' => 'Pnj Dokter ID',
            'pnj_dokter_sip' => 'Pnj Dokter Sip',
            'pnj_penjamin_id' => 'Pnj Penjamin ID',
            'pnj_nama_dokter' => 'Pnj Nama Dokter',
            'pnj_no_sep' => 'Pnj No Sep',
            'pnj_tipe_pembayaran' => 'Pnj Tipe Pembayaran',
            'pnj_is_kronis' => 'Pnj Is Kronis',
            'pnj_bayar_id' => 'Pnj Bayar ID',
            'pnj_tgl_pembayaran' => 'Pnj Tgl Pembayaran',
            'pnj_total_penjualan' => 'Pnj Total Penjualan',
            'pnj_total_dijamin' => 'Pnj Total Dijamin',
            'pnj_total_dibayar' => 'Pnj Total Dibayar',
            'pnj_total_retur' => 'Pnj Total Retur',
            'pnj_racikan' => 'Pnj Racikan',
            'pnj_catatan' => 'Pnj Catatan',
            'pnj_diagnosis' => 'Pnj Diagnosis',
            'pnj_status' => 'Pnj Status',
            'pnj_created_at' => 'Pnj Created At',
            'pnj_created_by' => 'Pnj Created By',
            'pnj_updated_at' => 'Pnj Updated At',
            'pnj_updated_by' => 'Pnj Updated By',
            'pnj_deleted_at' => 'Pnj Deleted At',
            'pnj_deleted_by' => 'Pnj Deleted By',
            'pnj_no_transaksi' => 'Pnj No Transaksi',
            'pnj_jam_resep' => 'Pnj Jam Resep',
        ];
    }

    /**
     * {@inheritdoc}
     * @return FarmasiPenjualanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FarmasiPenjualanQuery(get_called_class());
    }

    function getDepo()
    {
        return $this->hasOne(SdmMUnit::className(),['unt_id'=>'pnj_depo_id']);
    }

    function getPoli()
    {
        return $this->hasOne(SdmMUnit::className(),['unt_id'=>'pnj_unit_id']);
    }

    function getDetail()
    {
        return $this->hasOne(FarmasiPenjualanDetail::className(),['pjd_pnj_id'=>'pnj_id']);
    }

    function getDokter()
    {
        return $this->hasone(SdmMPegawai::className(),['pgw_id'=>'pnj_dokter_id']);
    }
}