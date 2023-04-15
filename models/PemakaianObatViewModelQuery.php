<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PemakaianObatViewModel extends Model
{
    // Define the properties that correspond to the fields in your SELECT clause.
    public $pnj_resep_id;
    public $unt_nama;
    public $pnj_no_rm;
    public $pnj_nama_pasien;
    public $pnj_no_daftar;
    public $pnj_nik;
    public $pnj_tanggal_lahir;
    public $pnj_umur;
    public $pnj_jenis_kelamin;
    public $pnj_riwayat_alergi;
    public $pnj_alamat;
    public $pnj_jam_resep;
    public $pnj_tanggal_resep;
    public $pnj_nama_dokter;
    public $pnj_penjamin;
    public $pnj_no_sep;
    public $pnj_diagnosis;
    public $pnj_status;
    public $pnj_created_at;
    public $pnj_updated_at;
    public $pnj_asal_rujukan;
    public $pnj_no_hp;
    public $bar_id;
    public $bar_nama;
    public $pens_satuan;
    public $pens_jumlah;
    public $pens_biaya_layanan;
    public $pens_harga_satuan;
    public $pens_harga_jual;
    public $pnj_total_retur;
    public $pens_subtotal;

    public function rules()
    {
        return [
            // Define the validation rules for your properties
            [['pnj_resep_id','unt_nama', 'pnj_no_rm', 'pnj_nama_pasien', 'pnj_no_daftar', 'pnj_nik','pnj_tanggal_lahir','pnj_umur','pnj_jenis_kelamin','pnj_riwayat_alergi','pnj_alamat','pnj_alamat','pnj_jam_resep','pnj_tanggal_resep','pnj_nama_dokter','pnj_penjamin','pnj_no_sep','pnj_diagnosis','pnj_status','pnj_created_at','pnj_updated_at','pnj_asal_rujukan','pnj_no_hp','bar_id','bar_nama','pens_satuan','pens_jumlah','pens_biaya_layanan','pens_harga_satuan','pens_harga_jual','pnj_total_retur','pens_subtotal'], 'safe'],
        ];
    }

    public function search($params)
    {
        // Define your SELECT clause
        $query = Yii::$app->db->createCommand("
        select pnj_resep_id, d.unt_nama as deponama, pnj_no_rm, pnj_nama_pasien ,pnj_no_daftar ,pnj_nik, pnj_tanggal_lahir,pnj_umur, pnj_jenis_kelamin, pnj_riwayat_alergi, pnj_alamat,pnj_jam_resep, pnj_tanggal_resep, pnj_nama_dokter,pnj_penjamin, pnj_no_sep, pnj_diagnosis, pnj_status,pnj_created_at,pnj_updated_at,pnj_asal_rujukan,pnj_no_hp,bar_id, bar_nama, pens_satuan, pens_jumlah, pens_biaya_layanan,pens_harga_satuan, pens_harga_jual,pnj_total_retur, pens_subtotal, u.unt_nama as unitnama from farmasi_penjualan_detail_sub LEFT JOIN farmasi_penjualan_detail on pjd_id = pens_pend_id LEFT JOIN farmasi_penjualan on pnj_id = pjd_pnj_id LEFT JOIN farmasi_m_barang on pens_bar_id = bar_id LEFT JOIN sdm_m_unit u on pnj_unit_id = u.unt_id LEFT JOIN sdm_m_unit d on pnj_depo_id = d.unt_id LEFT JOIN farmasi_retur_penjualan on rep_no_daftar = pnj_no_daftar LEFT JOIN farmasi_retur_penjualan_detail on repd_rep_id = rep_id where pnj_deleted_at is null")
    }