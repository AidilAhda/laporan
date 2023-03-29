<?php
use yii\helpers\Url;
use app\models\SdmMPegawai;

$logo1 = Url::base()."/images/dinkes.png";
$logo2 = Url::base()."/images/kampar.png";

function getDokter($gelar_depan, $gelar_belakang){

$data = SdmMPegawai::find()->select([
                                        "COUNT(IF(pgw_jenis_kelamin='Perempuan', 1,null)) 'pgw_perempuan', 
                                        COUNT(IF(pgw_jenis_kelamin='Laki-laki', 1,null)) 'pgw_pria'"])
                            ->andWhere(['=','pgw_gelar_depan',$gelar_depan])
                            ->andWhere(['=','pgw_gelar_belakang', $gelar_belakang])
                            ->one();        
    return $data;
}
?>

<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    .style-field-number {
        text-align:center;
    }
</style>
<table style="border: 0px !important;" class="table no-padding" width="100%">
    <tr style="border: 0px !important;">
        <td width="10%" style="border: 0px !important;">
            <img src="<?= $logo2 ?>" width="60px">
        </td>
        <td style="font-size:15px; border: 0px !important;" width="80%">
            <b>Formulir RL 1.2</b><br/>
            <b>KETENAGAAN</b>
        </td>
        <td width="10%" style="border: 0px !important;">
           <img src="<?= $logo1 ?>" width="60px">
        </td>
    </tr>
</table>
<hr style="height:5px; color:black;"/>

<table>
    <tr>
        <td><b>Kode RS</b></td>
        <td>:</td>
        <td></td>
    </tr>
    <tr>
        <td><b>Nama RS</b></td>
        <td>:</td>
        <td></td>
    </tr>    
    <tr>
        <td><b>Tahun</b></td>
        <td>:</td>
        <td> <?= $tahun_laporan ?></td>
    </tr>    
</table>
<table>
    <thead>
        <tr>
            <td rowspan="2"><center><b>NO KODE</b></center></td>
            <td rowspan="2"><center><b>KUALIFIKASI PENDIDIKAN</b></center></td>
            <td colspan="2"><center><b>KEADAAN</b></center></td>
            <td colspan="2"><center><b>KEBUTUHAN</b></center></td>
            <td colspan="2"><center><b>KEKURANGAN</b></center></td>
        </tr>
        <tr>
            <td><center><b>Laki-laki</b></center></td>
            <td><center><b>Perempuan</b></center></td>
            <td><center><b>Laki-laki</b></center></td>
            <td><center><b>Perempuan</b></center></td>
            <td><center><b>Laki-laki</b></center></td>
            <td><center><b>Perempuan</b></center></td>                        
        </tr>        
    </thead>
    <tr>
        <td colspan="8"><b>TENAGA KESEHATAN</b></n></td>
    </tr>
    <tr>
        <td><center>1</center></td>
        <td>Tenaga Medis</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>                        
    </tr>
    <tr> 
<?php
    $dr_umum = SdmMPegawai::find()->select([
                                            "COUNT(IF(pgw_jenis_kelamin='Perempuan', 1,null)) 'pgw_perempuan', COUNT(IF(pgw_jenis_kelamin='Laki-laki', 1,null)) 'pgw_pria'"])
                                ->andWhere(['=','pgw_gelar_depan','dr.'])
                                ->andWhere('pgw_gelar_belakang IS NULL')     
                                ->one();
?>        
        <td><center>1 1 </center></td>
        <td>Dokter Umum</td>
        <td class="style-field-number">
            <?= $dr_umum->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_umum->pgw_perempuan ?>
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr> 
<?php
    $dr_bedah = getDokter('dr.','sp.b');
?>        
        <td><center>1 2 </center></td>
        <td>Dokter PPDS</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>   
    <tr> 
<?php
    $dr_bedah = getDokter('dr.','sp.b');
?>        
        <td><center>1 3 </center></td>
        <td>Dokter Spes Bedah</td>
        <td class="style-field-number">
            <?= $dr_bedah->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_bedah->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>        
    <tr> 
<?php
    $dr_penyakit_dalam = getDokter('dr.','sp.pd');
?>        
        <td><center>1 4 </center></td>
        <td>Dokter Spes Penyakit Dalam</td>
        <td class="style-field-number">
            <?= $dr_penyakit_dalam->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_penyakit_dalam->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>        
    <tr>
    <tr> 
<?php
    $dr_anak = getDokter('dr.','sp.a');
?>        
        <td><center>1 5 </center></td>
        <td>Dokter Spes Kes. Anak</td>
        <td class="style-field-number">
            <?= $dr_anak->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_anak->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>        
    <tr>         
<?php
    $dr_obgin = getDokter('dr.','sp.og');
?>        
        <td><center>1 6 </center></td>
        <td>Dokter Spes Obgin</td>
        <td class="style-field-number">
            <?= $dr_obgin->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_obgin->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr> 
<?php
    $dr_radiologi = getDokter('dr.','sp.rad');
?>        
        <td><center>1 7 </center></td>
        <td>Dokter Spes Radiologi</td>
        <td class="style-field-number">
            <?= $dr_radiologi->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_radiologi->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr> 
<?php
    $dr_onko_radiasi = getDokter('dr.','sp.onk.rad');                
?>        
        <td><center>1 8 </center></td>
        <td>Dokter Spes Onkologi Radiasi</td>
        <td class="style-field-number">
            <?= $dr_onko_radiasi->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_onko_radiasi->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr> 
<?php
        $dr_nuklir = getDokter('dr.','sp.kn');                           
?>        
        <td><center>1 9 </center></td>
        <td>Dokter Spes Ked. Nuklir</td>
        <td class="style-field-number">
            <?= $dr_nuklir->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_nuklir->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr> 
<?php
    $dr_anestesi = getDokter('dr.','sp.an'); 

?>        
        <td><center>1 10 </center></td>
        <td>Dokter Spes Anestesi</td>
        <td class="style-field-number">
            <?= $dr_anestesi->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_anestesi->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr> 
<?php
    $dr_patologi_klinik = getDokter('dr.','sp.pk');

?>        
        <td><center>1 11 </center></td>
        <td>Dokter Spes Patologi Klinik</td>
        <td class="style-field-number">
            <?= $dr_patologi_klinik->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_patologi_klinik->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr> 
<?php
    $dr_jiwa = getDokter('dr.','sp.kj');                                
?>        
        <td><center>1 12 </center></td>
        <td>Dokter Spes Jiwa</td>
        <td class="style-field-number">
            <?= $dr_jiwa->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_jiwa->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr> 
<?php
    $dr_mata = getDokter('dr.','sp.m');                                                                     
?>        
        <td><center>1 13 </center></td>
        <td>Dokter Spes Mata</td>
        <td class="style-field-number">
            <?= $dr_mata->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_mata->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr> 
<?php
    $dr_tht =  getDokter('dr.','sp.tht-kl');
?>        
        <td><center>1 14 </center></td>
        <td>Dokter Spes THT-KL</td>
        <td class="style-field-number">
            <?= $dr_tht->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_tht->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr> 
<?php
    $dr_kulit_kelamin = getDokter('dr.','sp.dv');
?>        
        <td><center>1 15 </center></td>
        <td>Dokter Spes Kulit Kelamin</td>
        <td class="style-field-number">
            <?= $dr_kulit_kelamin->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_kulit_kelamin->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr> 
<?php
    $dr_kardio = getDokter('dr.','sp.jp');
?>        
        <td><center>1 16 </center></td>
        <td>Dokter Spes Kardio</td>
        <td class="style-field-number">
            <?= $dr_kardio->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_kardio->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr> 
<?php
    $dr_paru = getDokter('dr.','sp.p');
?>        
        <td><center>1 17 </center></td>
        <td>Dokter Spes Paru</td>
        <td class="style-field-number">
            <?= $dr_paru->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_paru->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>        
    <tr> 
<?php
        $dr_saraf = getDokter('dr.','sp.s');                                                          
?>        
        <td><center>1 18 </center></td>
        <td>Dokter Spes Saraf</td>
        <td class="style-field-number">
            <?= $dr_saraf->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_saraf->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr> 
<?php
        $dr_bedah_saraf = getDokter('dr.','sp.bs');                      
?>        
        <td><center>1 19 </center></td>
        <td>Dokter Spes Bedah Saraf</td>
        <td class="style-field-number">
            <?= $dr_bedah_saraf->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_bedah_saraf->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr> 
<?php
        $dr_bedah_orthopedi = getDokter('dr.','sp.ot');                  
?>        
        <td><center>1 20 </center></td>
        <td>Dokter Spes Bedah Ortho</td>
        <td class="style-field-number">
            <?= $dr_bedah_orthopedi->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_bedah_orthopedi->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr> 
<?php
        $dr_urologi =  getDokter('dr.','sp.u');
?>        
        <td><center>1 21 </center></td>
        <td>Dokter Spes Urologi</td>
        <td class="style-field-number">
            <?= $dr_urologi->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_urologi->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr> 
<?php
        $dr_patologi_anatomi =  getDokter('dr.','sp.pa');        
?>        
        <td><center>1 22 </center></td>
        <td>Dokter Spes Patologi Anatomi</td>
        <td class="style-field-number">
            <?= $dr_patologi_anatomi->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_patologi_anatomi->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr> 
<?php
        $dr_patologi_forensik =  getDokter('dr.','sp.f');  
?>        
        <td><center>1 23 </center></td>
        <td>Dokter Spes Patologi Forensi</td>
        <td class="style-field-number">
            <?= $dr_patologi_forensik->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_patologi_forensik->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr> 
<?php
        $dr_rehab_medis =  getDokter('dr.','sp.kfr');                        
?>        
        <td><center>1 24 </center></td>
        <td>Dokter Spes Rehab Medik</td>
        <td class="style-field-number">
            <?= $dr_rehab_medis->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_rehab_medis->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr> 
<?php
        $dr_bedah_plastik =  getDokter('dr.','sp.bp');
?>        
        <td><center>1 25 </center></td>
        <td>Dokter Spes Bedah Plastik</td>
        <td class="style-field-number">
            <?= $dr_bedah_plastik->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_bedah_plastik->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr> 
<?php
        $dr_olahraga =  getDokter('dr.','sp.ko');
?>        
        <td><center>1 26 </center></td>
        <td>Dokter Spes Ked. Olahraga</td>
        <td class="style-field-number">
            <?= $dr_olahraga->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_olahraga->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr> 
<?php
        $dr_mikrobiologi_klinik =  getDokter('dr.','sp.mk');
?>        
        <td><center>1 27 </center></td>
        <td>Dokter Spes Mikrobiologi Klinik</td>
        <td class="style-field-number">
            <?= $dr_mikrobiologi_klinik->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_mikrobiologi_klinik->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>            
    <tr> 
<?php
        $dr_parasitologi_klinik =  getDokter('dr.','sp.park');
?>        
        <td><center>1 28 </center></td>
        <td>Dokter Spes Parasitologi Klinik</td>
        <td class="style-field-number">
            <?= $dr_parasitologi_klinik->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_parasitologi_klinik->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr> 
<?php
        $dr_gizi_medik =  getDokter('dr.','sp.gk');
?>        
        <td><center>1 29 </center></td>
        <td>Dokter Spes Gizi Medik</td>
        <td class="style-field-number">
            <?= $dr_gizi_medik->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_gizi_medik->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr> 
<?php
        $dr_farma_klinik =  getDokter('dr.','sp.fk');                 
?>        
        <td><center>1 30 </center></td>
        <td>Dokter Spes Farma Klinik</td>
        <td class="style-field-number">
            <?= $dr_farma_klinik->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_farma_klinik->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr> 
<?php
        $dr_gigi =  getDokter('drg.','');                 
?>        
        <td><center>1 33 </center></td>
        <td>Dokter Gigi</td>
        <td class="style-field-number">
            <?= $dr_gigi->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_gigi->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr> 
<?php
        $dr_gigi_spesialis =  getDokter('drg.','sp.kg');
?>        
        <td><center>1 34 </center></td>
        <td>Dokter Gigi Spesialis</td>
        <td class="style-field-number">
            <?= $dr_gigi_spesialis->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $dr_gigi_spesialis->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td>
            <center>2</center>
        </td>
        <td colspan="7">
            <b>TENAGA KEPERAWATAN</b>
        </td>
    </tr>
    <tr> 
        <td><center>2 1 </center></td>
        <td>S3 Keperawatan</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr> 
        <td><center>2 2 </center></td>
        <td>S2 Keperawatan</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr> 
    <tr> 
<?php
        $s1_keperawatan = getDokter('','s.kep');
?>        
        <td><center>2 3 </center></td>
        <td>S1 Keperawatan</td>
        <td class="style-field-number">
            <?= $s1_keperawatan->pgw_pria ?>            
        </td>
        <td class="style-field-number">
            <?= $s1_keperawatan->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>     
    <tr> 
<?php
    $d4_keperawatan = getDokter('','s.tr.kep');
?>        
        <td><center>2 4 </center></td>
        <td>D4 Keperawatan</td>
        <td class="style-field-number">
            <?= $d4_keperawatan->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $d4_keperawatan->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr> 
<?php
    $d4_keperawatan = getDokter('','s.tr.kep');
?>        
        <td><center>2 4 </center></td>
        <td>D4 Keperawatan</td>
        <td class="style-field-number">
            <?= $d4_keperawatan->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $d4_keperawatan->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr> 
        <td><center>2 5 </center></td>
        <td>Perawat Vokasional</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>                   
    <tr> 
<?php
    $perawat_spesialis = getDokter('','sp.kep');
?>        
        <td><center>2 6 </center></td>
        <td>D4 Keperawatan</td>
        <td class="style-field-number">
            <?= $d4_keperawatan->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $d4_keperawatan->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr> 
        <td><center>2 7 </center></td>
        <td>Pemabantu Keperawatan</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr> 
        <td><center>2 8 </center></td>
        <td>S3 Kebidanan</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr> 
<?php
    $s2_bidan = getDokter('','m.keb');
?>        
        <td><center>2 9 </center></td>
        <td>S2 Kebidanan</td>
        <td class="style-field-number">
            <?= $s2_bidan->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $s2_bidan->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr> 
<?php
    $s1_bidan = getDokter('','s.keb');
?>        
        <td><center>2 10 </center></td>
        <td>S2 Kebidanan</td>
        <td class="style-field-number">
            <?= $s1_bidan->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $s1_bidan->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr> 
<?php
    $d3_bidan = getDokter('','a.md.keb');
?>        
        <td><center>2 11 </center></td>
        <td>D3 Kebidanan</td>
        <td class="style-field-number">
            <?= $d3_bidan->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $d3_bidan->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td>
            <center><b>3</b></center>
        </td>
        <td colspan="7"><b>KEFARMASIAN</b></td>
    </tr>             
    <tr> 
        <td><center>3 1 </center></td>
        <td>S3 Farmasi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>           
    <tr> 
        <td><center>3 2 </center></td>
        <td> S2 Farmasi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr> 
<?php
    $apoteker = SdmMPegawai::find()->select([
                                        "COUNT(IF(pgw_jenis_kelamin='Perempuan', 1,null)) 'pgw_perempuan', 
                                        COUNT(IF(pgw_jenis_kelamin='Laki-laki', 1,null)) 'pgw_pria'"])
                            ->andWhere(['LIKE','pgw_gelar_belakang', 'apt'])
                            ->one();
?>        
        <td><center>3 3 </center></td>
        <td>Apoteker</td>
        <td class="style-field-number">
            <?= $apoteker->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $apoteker->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr> 
<?php
    $s1_farmasi = SdmMPegawai::find()->select([
                                        "COUNT(IF(pgw_jenis_kelamin='Perempuan', 1,null)) 'pgw_perempuan', 
                                        COUNT(IF(pgw_jenis_kelamin='Laki-laki', 1,null)) 'pgw_pria'"])
                            ->andWhere(['LIKE','pgw_gelar_belakang', 's.farm'])
                            ->andWhere(['NOT LIKE','pgw_gelar_belakang', 'apt'])                            
                            ->one();
?>        
        <td><center>3 4 </center></td>
        <td>S1 Farmasi</td>
        <td class="style-field-number">
            <?= $s1_farmasi->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $s1_farmasi->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>        
    <tr>
        <td><center>3 5 </center></td>
        <td>AKAFARMA</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>3 6 </center></td>
        <td>AKFAR</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>        
    <tr>
        <td><center>3 7 </center></td>
        <td>Analis Farmasi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr>
        <td><center>3 8 </center></td>
        <td>Asisten Apoteker</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>        
    <tr>
        <td><center>3 7 </center></td>
        <td>Analis Farmasi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>3 8 </center></td>
        <td>Asisten Apoteker</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>      
    <tr>
        <td><center>3 9 </center></td>
        <td>ST lab Kimia Farmasi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>      
    <tr>
        <td>
            <center><b>4</b></center>
        </td>
        <td colspan="7">
            <b>KESEHATAN MASYARAKAT</b>
        </td>
    </tr>
    <tr>
        <td><center>4 1</center></td>
        <td>S3 Kesehatan Masyarakat</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr>
        <td><center>4 2</center></td>
        <td>S3 Epidemiologi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>4 3</center></td>
        <td>S3 Psikologi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>            
    <tr>
<?php
    $s2_kesehatan_masyarakat = SdmMPegawai::find()->select([
                                        "COUNT(IF(pgw_jenis_kelamin='Perempuan', 1,null)) 'pgw_perempuan', 
                                        COUNT(IF(pgw_jenis_kelamin='Laki-laki', 1,null)) 'pgw_pria'"])
                            ->andWhere(['NOT LIKE','pgw_gelar_belakang', 's.km'])
                            ->andFilterWhere(['OR',
                                            ['LIKE','pgw_gelar_belakang', 'm.km'], 
                                            ['LIKE','pgw_gelar_belakang', 'mph'],                                             
                            ])                            
                            ->one();        
?>        
        <td><center>4 4</center></td>
        <td>S2 Kesehatan Masyarakat</td>
        <td class="style-field-number">
            <?= $s2_kesehatan_masyarakat->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $s2_kesehatan_masyarakat->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr>
<?php
    $s2_epidemiologi = getDokter('','m.epid')        
?>        
        <td><center>4 5</center></td>
        <td>S2 Epidemiologi</td>
        <td class="style-field-number">
            <?= $s2_epidemiologi->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $s2_epidemiologi->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
<?php
    $s2_biomedik = getDokter('','m.biomed')        
?>        
        <td><center>4 6</center></td>
        <td>S2 Biomedik</td>
        <td class="style-field-number">
            <?= $s2_biomedik->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $s2_biomedik->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
<?php
    $s2_psikologi = getDokter('','m.psi')        
?>        
        <td><center>4 7</center></td>
        <td>S2 Psikologi</td>
        <td class="style-field-number">
            <?= $s2_psikologi->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $s2_psikologi->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>                
    <tr>
<?php

    $s1_kesehatan_masyarakat = SdmMPegawai::find()->select([
                                        "COUNT(IF(pgw_jenis_kelamin='Perempuan', 1,null)) 'pgw_perempuan', 
                                        COUNT(IF(pgw_jenis_kelamin='Laki-laki', 1,null)) 'pgw_pria'"])
                            ->andWhere(['LIKE','pgw_gelar_belakang', 's.km'])
                            ->andWhere(['NOT LIKE','pgw_gelar_belakang', 'm.km'])                            
                            ->one();            
?>        
        <td><center>4 8</center></td>
        <td>S1 Kesehatan Masyarakat</td>
        <td class="style-field-number">
            <?= $s1_kesehatan_masyarakat->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $s1_kesehatan_masyarakat->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>                    
    <tr>
<?php

    $s1_psikologi = SdmMPegawai::find()->select([
                                        "COUNT(IF(pgw_jenis_kelamin='Perempuan', 1,null)) 'pgw_perempuan', 
                                        COUNT(IF(pgw_jenis_kelamin='Laki-laki', 1,null)) 'pgw_pria'"])
                            ->andWhere(['LIKE','pgw_gelar_belakang', 's.psi'])
                            ->andWhere(['NOT LIKE','pgw_gelar_belakang', 'm.psi'])                            
                            ->one();            
?>        
        <td><center>4 9</center></td>
        <td>S1 Psikologi</td>
        <td class="style-field-number">
            <?= $s1_psikologi->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $s1_psikologi->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>4 10</center></td>
        <td>D3 Kesehatan Masyarakat</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>4 11</center></td>
        <td>D3 Sanitarian</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>4 12</center></td>
        <td>D1 Sanitarian</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>                                    
    <tr>
        <td><center><b>5</b></center></td>
        <td colspan="7"><b>GIZI</b></td>
    </tr>
    <tr>
        <td><center>5 1</center></td>
        <td>S3 Gizi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>5 2</center></td>
        <td>S2 Gizi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
<?php
    $s1_gizi = getDokter('','s.gz');
?>        
        <td><center>5 3</center></td>
        <td>S1 Gizi</td>
        <td class="style-field-number">
            <?= $s1_gizi->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $s1_gizi->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
<?php
    $d4_gizi = getDokter('','s.tr.gz');
?>        
        <td><center>5 4</center></td>
        <td>D4 Gizi</td>
        <td class="style-field-number">
            <?= $d4_gizi->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $d4_gizi->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
<?php
    $d3_gizi = getDokter('','A.Md.Gz');
?>        
        <td><center>5 5</center></td>
        <td>D3 Gizi</td>
        <td class="style-field-number">
            <?= $d3_gizi->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $d3_gizi->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
<?php
    $d1_gizi = getDokter('','a.p.gz');
?>        
        <td><center>5 6</center></td>
        <td>D1 Gizi</td>
        <td class="style-field-number">
            <?= $d1_gizi->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $d1_gizi->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td>
            <center><b>6</b></center>
        </td>
        <td colspan="7"> KETERAPIAN FISIK </td>
    </tr>
    <tr>
<?php
    $s1_fisio = getDokter('','SST, FT');
?>        
        <td><center>6 1</center></td>
        <td>S1 Fisioterapi</td>
        <td class="style-field-number">
            <?= $s1_fisio->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $s1_fisio->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr>
<?php
    $d3_fisio = getDokter('','Amd.Ftr');
?>        
        <td><center>6 2</center></td>
        <td>D3 Fisioterapi</td>
        <td class="style-field-number">
            <?= $d3_fisio->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $d3_fisio->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>        
    <tr>
        <td><center>6 3</center></td>
        <td>D3 Okupasi Terapis</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>6 4</center></td>
        <td>D3 Terapi Wicara</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>        
    <tr>
        <td><center>6 5</center></td>
        <td>D3 Orthopedi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>6 6</center></td>
        <td>D3 Akupuntur</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr>
        <td><center><b>7</b></center></td>
        <td colspan="7"><b>KETEKNISIAN MEDIS</b></td>
    </tr>
    <tr>
        <td><center>7 1</center></td>
        <td>S3 Opto Elektronika</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>7 2</center></td>
        <td>S2 Opto Elektronika</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
<?php
    $radiografer = getDokter('','AMR');
?>        
        <td><center>7 3</center></td>
        <td>Radiografer</td>
        <td class="style-field-number">
            <?= $radiografer->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $radiografer->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>7 4</center></td>
        <td>Radioterapis (Non Dokter)</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>7 5</center></td>
        <td>D4 Fisika Medik</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>7 6</center></td>
        <td>D3 Teknik Gigi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>7 7</center></td>
        <td>D3 Teknik Radiologi & Radioterapi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>7 8</center></td>
        <td>D3 Refraksionis Optisien</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
<?php

    $d3_rekam_medis = getDokter('','Amd.RM');
?>        
        <td><center>7 9</center></td>
        <td>D3 Perekam Medis</td>
        <td class="style-field-number">
            <?= $d3_rekam_medis->pgw_pria ?>
        </td>
        <td class="style-field-number">
            <?= $d3_rekam_medis->pgw_perempuan ?>            
        </td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>7 10</center></td>
        <td>D3 Teknik Elektromedik</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>7 11</center></td>
        <td>D3 Analis Kesehatan</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>7 12</center></td>
        <td>D3 Informasi Kesehatan</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>7 13</center></td>
        <td>D3 Kardiovaskular</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>7 14</center></td>
        <td>D3 Orthotik Prostetik</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>7 15</center></td>
        <td>D1 Teknik Transfusi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>7 16</center></td>
        <td>Teknisi Gigi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>7 17</center></td>
        <td>Tenaga IT dengan Teknologi Nano</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>7 18</center></td>
        <td>Teknisi Patologi Anatomi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>7 19</center></td>
        <td>Teknisi Kardiovaskuler</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>7 20</center></td>
        <td>Teknisi Elektromedis</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>7 21</center></td>
        <td>Akupuntur Terapi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>7 22</center></td>
        <td>Analis Kesehatan</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr>
        <td><center><b>II</b></center></td>
        <td colspan="7">TENAGA NON KESEHATAN</td>
    </tr>
    <tr>
        <td><center><b>8</b></center></td>
        <td colspan="7">DOKTORAN</td>
    </tr>
    <tr>
        <td><center>8 1</center></td>
        <td>S3 Biologi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>8 2</center></td>
        <td>S3 Kimia</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>8 3</center></td>
        <td>S3 Ekonomi/Akuntansi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr>
        <td><center>8 4</center></td>
        <td>S3 Administrasi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>8 5</center></td>
        <td>S3 Hukum</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>8 6</center></td>
        <td>S3 Teknik</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>8 7</center></td>
        <td>S3 Kes. Sosial</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>8 8</center></td>
        <td>S3 Fisika</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>8 9</center></td>
        <td>S3 Komputer</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>8 10</center></td>
        <td>S3 Statistik</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr>
        <td><center><b>9</b></center></td>
        <td colspan="7"><b>PASCA SARJANA</b></td>
    </tr>
    <tr>
        <td><center>9 1</center></td>
        <td>S2 Biologi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr>
        <td><center>9 2</center></td>
        <td>S2 Kimia</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>        
    <tr>
        <td><center>9 3</center></td>
        <td>S2 Ekonomi/ Akuntansi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>        
    <tr>
        <td><center>9 4</center></td>
        <td>S2 Administrasi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>        
    <tr>
        <td><center>9 5</center></td>
        <td>S2 Hukum</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>        
    <tr>
        <td><center>9 6</center></td>
        <td>S2 Teknik</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>        
    <tr>
        <td><center>9 7</center></td>
        <td>S2 Kesejahteraan Sosial</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>        
    <tr>
        <td><center>9 8</center></td>
        <td>S2 Fisika</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>        
    <tr>
        <td><center>9 9</center></td>
        <td>S2 Komputer</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>        
    <tr>
        <td><center>9 10</center></td>
        <td>S2 Statistik</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>        
    <tr>
        <td><center>9 11</center></td>
        <td>S2 Adm. Kes. Masy</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>        
    <tr>
        <td><center><b>10</b></center></td>
        <td><b>SARJANA</b></td>
    </tr>
    <tr>
        <td><center>10 1</center></td>
        <td>Sarjana Biologi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>10 2</center></td>
        <td>Sarjana Kimia</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>            
    <tr>
        <td><center>10 3</center></td>
        <td>Sarjana Eko/Akun</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr>
        <td><center>10 4</center></td>
        <td>Sarjana Adminstrasi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>10 5</center></td>
        <td>Sarjana Hukum</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>10 6</center></td>
        <td>Sarjana Teknik</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>10 7</center></td>
        <td>Sarjana Kes. Sosial</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>10 8</center></td>
        <td>Sarjana Fisika</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>10 9</center></td>
        <td>Sarjana Komputer</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>10 10</center></td>
        <td>Sarjana Statistik</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center><b>11</b></center></td>
        <td colspan="7" ><b>SARJANA MUDA</b></td>
    </tr>
    <tr>
        <td><center>11 1</center></td>
        <td>Sarjana Muda Biologi</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>11 2</center></td>
        <td>Sarjana Muda Kimia</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>        
    <tr>
        <td><center>11 3</center></td>
        <td>Sarjana Muda Eko/Akun</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr>
        <td><center>11 4</center></td>
        <td>Sarjana Muda Adm</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr>
        <td><center>11 5</center></td>
        <td>Sarjana Muda Hukum</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>    
    <tr>
        <td><center>11 6</center></td>
        <td>Sarjana Muda Teknik</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>11 7</center></td>
        <td>Sarjana Muda Kes. Sosial</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>11 8</center></td>
        <td>Sarjana Muda Statistik</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>11 9</center></td>
        <td>Sarjana Muda Komputer</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>11 10</center></td>
        <td>Sarjana Muda Sekretaris</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center><b>12</b></center></td>
        <td colspan="7"><center><b>SMU SEDERAJAT/DIBAWAHNYA</b></center></td>
    </tr>
    <tr>
        <td><center>12 1</center></td>
        <td>SMA/ SMU</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>
    <tr>
        <td><center>12 2</center></td>
        <td>SMEA</td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>
        <td class="style-field-number"></td>                        
    </tr>





</table>