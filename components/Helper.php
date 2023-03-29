<?php 

namespace app\components;

use app\models\MedisMIcd10cm;
use app\models\MedisMIcd9cm;
use app\models\MedisMIntervensiKeperawatan;
use app\models\MedisMItemPemeriksaanPenunjang;
use app\models\MedisMMasalahKeperawatan;
use app\models\MedisMSkTarif;
use app\models\MedisMTindakan;
use app\models\PendaftaranMKelasRawat;
use app\models\SdmMAgama;
use app\models\SdmMJabatanUnit;
use app\models\SdmMJenisCuti;
use app\models\SdmMJenisIssueKet;
use app\models\SdmMJenisJabatan;
use app\models\SdmMJenisKenaikanPangkat;
use app\models\SdmMJurusan;
use app\models\SdmMKabupatenKota;
use app\models\SdmMKecamatan;
use app\models\SdmMKelurahanDesa;
use app\models\SdmMPangkat;
use app\models\SdmMPangkatDetail;
use app\models\SdmMPegawai;
use app\models\SdmMPendidikan;
use app\models\SdmMProvinsi;
use app\models\SdmMRumpun;
use app\models\SdmMStatusKepegawaian;
use app\models\SdmMStatusPerkawinan;
use app\models\SdmMSubRumpun;
use app\models\SdmMSubRumpunJenis;
use app\models\SdmMUnit;
use app\widgets\AuthUser;
use DateTime;
use Yii;

class Helper{

    // static function getUnit($p)
    // {
    //     $v = UNIT::findOne($p);
    //     return $v;
    // }    
    static function getDataPengguna($pgw_id)
    {            
        $data = \Yii::$app->db->createCommand('SELECT
                    a.akp_id,a.akp_pgw_id,a.akp_apl_id,a.akp_all_id,
                    b.pgw_nomor,b.pgw_gelar_depan,b.pgw_nama,b.pgw_gelar_belakang,b.pgw_username,b.pgw_password_hash,
                    c.all_nama,d.apl_kode,d.apl_nama
                FROM sdm_m_akses_aplikasi a
                    INNER JOIN sdm_m_pegawai b ON a.akp_pgw_id=b.pgw_id
                    INNER JOIN sdm_m_aplikasi_level c ON a.akp_all_id=c.all_id
                    INNER JOIN sdm_m_aplikasi d ON a.akp_apl_id=d.apl_id
                WHERE b.pgw_id='.$pgw_id.' AND b.pgw_aktif=1 AND d.apl_id=10
                ORDER BY b.pgw_created_at DESC')->queryOne();
    
        return $data;
    }

    public static function getNamaPegawai($pegawai)
    {
        return ($pegawai->pgw_gelar_depan ? $pegawai->pgw_gelar_depan . ' ' : NULL) . $pegawai->pgw_nama . ($pegawai->pgw_gelar_belakang ? ', ' . $pegawai->pgw_gelar_belakang : null);
    }

    static function bln_thn_indo($tanggal){
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);
        
        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun
    
        return $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

    // Hitung Umur
    static function hitung_umur($tanggal_lahir){
        $birthDate = new DateTime($tanggal_lahir);
        $today = new DateTime("today");
        if ($birthDate > $today) { 
            exit("0 tahun 0 bulan 0 hari");
        }
        $y = $today->diff($birthDate)->y;
        $m = $today->diff($birthDate)->m;
        $d = $today->diff($birthDate)->d;
        return $y." tahun ".$m." bulan ".$d." hari";
    }

//Data Pegawai
    static function getPegawai($p)
    {
        $v = SdmMPegawai::findOne($p);
        return $v;
    }  
	
//Data Pangkat
    static function getPangkat($p)
    {
        if(!empty($p)){
            $v = SdmMPangkat::findOne($p);
            return $v['smp_id'] = $v['smp_nama'];
        } else {
            return $v['smp_id'] = '';
        }    
    }

//Data Pangkat
    static function getPangkatDetail($p)
    {
        if(!empty($p)){
            $v = SdmMPangkatDetail::findOne($p);
            return $v['smpd_id'] = $v['smpd_nama'];
        } else {
            return $v['smpd_id'] = '';
        }    
    }

//Data Jenis Kenaikan Pangkat
static function getJnsKenaikanPangkat($p)
{
    if(!empty($p)){
        $v = SdmMJenisKenaikanPangkat::findOne($p);
        return $v['jkp_id'] = $v['jkp_nama_jenis_kp'];
    } else {
        return $v['jkp_id'] = '';
    }    
}

//Data Jabatan
    static function getJnsJabatan($p)
    {
        if(!empty($p)){
            $v = SdmMJenisJabatan::findOne($p);
            return $v['jjb_id'] = $v['jjb_nama'];
        } else {
            return $v['jjb_id'] = '';
        }    
    }

    static function getJabatan($p)
    {
        if(!empty($p)){
            $v = SdmMJabatanUnit::findOne($p);
            return $v['jbu_id'] = $v['jbu_nama'];
        } else {
            return $v['jbu_id'] = '';
        }    
    }

    static function getStatusKepegawaian($p)
    {
        if(!empty($p)){
            $v = SdmMStatusKepegawaian::findOne($p);
            return $v['skp_id'] = $v['skp_nama'];
        } else {
            return $v['skp_id'] = '';
        }  
    }

    static function getRumpunSDMK($p)
    {
        if(!empty($p)){
            $v = SdmMRumpun::findOne($p);
            return $v['rpn_id'] = $v['rpn_nama'];
        } else {
            return $v['rpn_id'] = '';
        }  
    }

    static function getSubRumpunSDMK($p)
    {
        if(!empty($p)){
            $v = SdmMSubRumpun::findOne($p);
            return $v['srp_id'] = $v['srp_nama'];
        } else {
            return $v['srp_id'] = '';
        }  
    }

    static function getSubRumpunJenisSDMK($p)
    {
        if(!empty($p)){
            $v = SdmMSubRumpunJenis::findOne($p);
            return $v['srj_id'] = $v['srj_nama'];
        } else {
            return $v['srj_id'] = '';
        }  
    }

    static function getAgama($p)
    {
        if(!empty($p)){
            $v = SdmMAgama::findOne($p);
            return $v['agm_id'] = $v['agm_nama'];
        } else {
            return $v['agm_id'] = '';
        }  
    }

    static function getStatusPerkawinan($p)
    {
        if(!empty($p)){
            $v = SdmMStatusPerkawinan::findOne($p);
            return $v['stp_id'] = $v['stp_nama'];
        } else {
            return $v['stp_id'] = '';
        }  
    }

    static function getUnitPenempatan($p)
    {
        if(!empty($p)){
            $v = SdmMUnit::findOne($p);
            return $v['unt_id'] = $v['unt_nama'];
        } else {
            return $v['unt_id'] = '';
        }  
    }

    static function getProvinsi($p)
    {
        if(!empty($p)){
            $v = SdmMProvinsi::findOne($p);
            return $v['prv_kode'] = $v['prv_nama'];
        } else {
            return $v['prv_kode'] = '';
        }  
    }

    static function getKabupaten($p)
    {
        if(!empty($p)){
            $v = SdmMKabupatenKota::findOne($p);
            return $v['kab_kode'] = $v['kab_nama'];
        } else {
            return $v['kab_kode'] = '';
        }  
    }

    static function getKecamatan($p)
    {
        if(!empty($p)){
            $v = SdmMKecamatan::findOne($p);
            return $v['kec_kode'] = $v['kec_nama'];
        } else {
            return $v['kec_kode'] = '';
        }  
    }


    static function getKelurahan($p)
    {
        if(!empty($p)){
            $v = SdmMKelurahanDesa::findOne($p);
            return $v['kel_kode'] = $v['kel_nama'];
        } else {
            return $v['kel_kode'] = '';
        }  
    }

    static function getJnsIssue($p)
    {
        if(!empty($p)){
            $v = SdmMJenisIssueKet::findOne($p);
            return $v['jik_id'] = $v['jik_nama'];
        } else {
            return $v['jik_id'] = '';
        }    
    }

    static function getPendidikan($p)
    {
        if(!empty($p)){
            $v = SdmMPendidikan::findOne($p);
            return $v['pdd_id'] = $v['pdd_nama'];
        } else {
            return $v['pdd_id'] = '';
        }  
    }  
    
    static function getJurusan($p)
    {
        if(!empty($p)){
            $v = SdmMJurusan::findOne($p);
            return $v['jur_id'] = $v['jur_nama'];
        } else {
            return $v['jur_id'] = '';
        }  
    } 

    //Data Jabatan
    static function getJnsCuti($p)
    {
        if(!empty($p)){
            $v = SdmMJenisCuti::findOne($p);
            return $v['jnc_id'] = $v['jnc_nama'];
        } else {
            return $v['jnc_id'] = '';
        }    
    }
    
   static function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
     
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
     }
}