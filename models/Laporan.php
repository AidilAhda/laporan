<?php
/**
 * Created by PhpStorm.
 * User: Salman
 * Date: 22/02/2021
 * Time: 11.28
 */

namespace app\models;

use yii\base\Model;
use yii\db\ActiveRecord;

use app\models\PendaftaranLayanan;
use app\models\EbsPembayaranPasien;
use app\models\EbsPembayaranPlafon;

set_time_limit(0);

class Laporan extends Model
{
     public function getLaporanPendapatanPerLoket($tanggal,$sampai,$loket)
    {


        $QueryPembayaran = EbsPembayaranPasien::find()
        ->joinWith([ 'debiturdetail', 'kodebayar'],true)
        ->andWhere(['between','byr_tanggal', $tanggal, $sampai]);

        if(!empty($loket)){
            
            $DataPembayaran = $QueryPembayaran->andWhere(['byr_lob_id'=>$loket])
            ->andWhere('byr_deleted_at is null')->asArray()->all();

        } else {
            
            $DataPembayaran = $QueryPembayaran
            ->andWhere('byr_deleted_at is null')->asArray()->all();
        }

     
        return $DataPembayaran;
    }

    public function getLaporanKunjunganPerUnit($tanggal,$sampai,$unit)
    {

        $QueryKunjungan = PendaftaranLayanan::find()
        // ->joinWith(['unit','registrasi'], true)
        ->joinWith([
            'unit',
            'registrasi'=>function($q){
                $q->joinWith(['pasien', 'pasienluar','debiturdetail','kirimandetail'],true);
            }
        ],true)
        ->andWhere(['between','pl_tgl_masuk', $tanggal, $sampai]);

        if(!empty($unit)){
            
            $DataKunjungan = $QueryKunjungan->andWhere(['pl_unit_kode'=>$unit])
            ->andWhere('pl_deleted_at is null')->asArray()->all();

        } else {
            
            $DataKunjungan = $QueryKunjungan
            ->andWhere('pl_deleted_at is null')->asArray()->all();
        }

     
        return $DataKunjungan;
    }

    public function getLaporanPembayaranTunai($tanggal,$sampai)
    {
   
        $DataPembayaran = EbsPembayaranPasien::find()
        ->joinWith([ 'debiturdetail', 'kodebayar'],true)
        ->andWhere(['between','byr_tanggal', $tanggal, $sampai])
        ->andWhere('byr_deleted_at is null')->asArray()->all();
     
        return $DataPembayaran;
    }

     public function getLaporanPembayaranPlafon($tanggal,$sampai)
    {
   
        $DataPembayaran = EbsPembayaranPlafon::find()
        ->joinWith([ 'debiturdetail', 'kodebayar'],true)
        ->andWhere(['between','byp_tanggal', $tanggal, $sampai])
        ->andWhere('byp_deleted_at is null')->asArray()->all();
     
        return $DataPembayaran;
    }
	
	public function getLaporanPendapatanPerPengguna($tanggal,$sampai,$pengguna)
    {

        $QueryPembayaran = EbsPembayaranPasien::find()
        ->select(['ebs_pembayaran_pasien.*','sdm_m_pegawai.pgw_nama','pendaftaran_m_debitur_detail.pmdd_nama', 'ebs_m_kode_pembayaran.kob_nama'])
        ->joinWith([ 'debiturdetail', 'kodebayar','kasir'],false)
        ->andWhere(['between','byr_tanggal', $tanggal, $sampai]);

        if(!empty($loket)){
            
            $DataPembayaran = $QueryPembayaran->andWhere(['byr_created_by'=>$pengguna])
            ->andWhere('byr_deleted_at is null')->asArray()->all();

        } else {
            
            $DataPembayaran = $QueryPembayaran
            ->andWhere('byr_deleted_at is null')->asArray()->all();
        }

     
        return $DataPembayaran;
    }
	
	public function getLaporanPendapatanPerShift($tanggal,$sampai,$shift)
    {

        $QueryPembayaran = EbsPembayaranPasien::find()
        ->select(['ebs_pembayaran_pasien.*','sdm_m_pegawai.pgw_nama','pendaftaran_m_debitur_detail.pmdd_nama', 'ebs_m_kode_pembayaran.kob_nama'
        , 'ebs_m_shift.shf_nama'])
        ->joinWith([ 'debiturdetail','kodebayar','kasir','shift'],false)
        ->andWhere(['between','byr_tanggal', $tanggal, $sampai]);

        if(!empty($shift)){
            
            $DataPembayaran = $QueryPembayaran->andWhere(['byr_shf_id'=>$shift])
            ->andWhere('byr_deleted_at is null')->asArray()->all();

        } else {
            
            $DataPembayaran = $QueryPembayaran
            ->andWhere('byr_deleted_at is null')->asArray()->all();
        }

     
        return $DataPembayaran;
    }

}