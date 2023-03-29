<?php
/**
 * Created by PhpStorm.
 * User: SalmanSyuhada
 * Date: 10-Jan-19
 * Time: 2:17 PM
 */

use yii\helpers\Url;

use app\models\Data;
use app\components\Helper;
use app\models\MedisMTarifKamar;

$logo1 = Url::base()."/images/dinkes.png";
$logo2 = Url::base()."/images/kampar.png";


?>

<table class="table no-padding" width="100%">
    <tr>
        <td width="10%">
            <img src="<?= $logo2 ?>" width="60px">
        </td>
        <td style="font-size:15px" width="80%">
            <center><b><?= Yii::$app->params['header']['nama_dinas'] ?></b><br/>
               <?= Yii::$app->params['header']['nama_rumah_sakit'] ?><br/>
               <?= Yii::$app->params['header']['alamat_rumah_sakit'] ?><br/>
               <?= Yii::$app->params['header']['kontak_rumah_sakit'] ?></center>
        </td>
        <td width="10%">
           <img src="<?= $logo1 ?>" width="60px">
        </td>
    </tr>
</table>

<table style="border: 1px solid black;border-left: 0px solid black;border-right: 0px solid black;" width="100%">
    <tr>
        <td>
            <center><h4 style="margin: 0; padding: 0;"><b>PERINCIAN BIAYA PERAWATAN</b></h4></center>
        </td>
    </tr>
</table>

<table style="border-bottom: 1px solid black; border-style: dashed;" width="100%">
    <tr>
        <td width="20%">
            NO. REKAM MEDIK
        </td>
        <td width="30%">: <b><?= $registrasi['reg_pasien_kode'] ?></b></td>
        <td width="15%" colspan="4"></td>
        <td width="20%">NO. REGISTER</td>
        <td width="15%" colspan="4">: <?= $registrasi['reg_kode'] ?></td>
    </tr>
    <tr>
        <td>
            NAMA PASIEN
        </td>
        <td>: <?= $biodata['nama'] ?></td>
        <td colspan="4"></td>
        <td>TGL. REGISTRASI</td>
        <td colspan="4">: <?= isset($registrasi['reg_tgl_masuk']) ?  Data::date2Ind(date("Y-m-d", strtotime($registrasi['reg_tgl_masuk'])), true) : Null ?> </td>
    </tr>
    <tr>
        <td>
            <UMUR></UMUR>
        </td>
        <td>: <?= Helper::hitung_umur($biodata['tanggalLahir']) ?></td>
        <td colspan="4"></td>
        <td>TGL. KELUAR</td>
        <td colspan="4">:
            <?php if($layanan->pl_jenis_layanan == "3"){
                echo $layanan->pl_tgl_keluar ? Data::date2Ind(date("Y-m-d", strtotime($layanan->pl_tgl_keluar))) : '';
            }else{
               echo  isset($registrasi['reg_tgl_masuk']) ? date("d M Y H:i:s", strtotime($registrasi['reg_tgl_masuk'])) : Null;
            } ?>
        </td>
    </tr>
    <tr>
        <td>ALAMAT</td>
        <td>: <?= $biodata['alamat'] ?></td>
        <td colspan="4"></td>
        <td>JENIS PASIEN</td>
        <td>: <?= $registrasi['debiturdetail']['pmdd_nama'] ?></td>
    </tr>
    <?php  if($layanan->pl_jenis_layanan == 3){ ?>
    <tr>
        <td>KELAS HAK</td>
        <td>: <?= $dataSep['sep_hak_kelas'] ?></td>
        <td colspan="4"></td>
        <td>KELAS RAWAT</td>
        <td>: <?= $dataSep['sep_kelas_rawat'] ?></td>
    </tr>
    <?php } ?>
    <tr>
        <td>NAMA DPJP</td>
        <td>: <?= $nama_dpjp != null ?  Helper::getNamaPegawai($nama_dpjp) : ''; ?></td>
        <td colspan="4"></td>
        <td>RUANGAN TERAKHIR</td>
        <td>: <?= $ruangan_akhir ? $ruangan_akhir->unit->unt_nama : '' ?></td>
    </tr>
</table>

<table style="border-top: 1px black;border-bottom: 1px solid black;" width="100%">
    <tr>
        <td align="left">
            <center><h5 style="margin: 0; padding: 0;">BIAYA S/D TANGGAL <?= date('d-m-Y') ?></h5></center>
        </td>
        <td align="right">
            <center><h5 style="margin: 0; padding: 0;">TGL. CETAK <?= date('d-m-Y H:i:s') ?></h5></center>
        </td>
    </tr>
</table>

<table style="border-top: 1px solid black;border-bottom: 1px solid black;" width="100%">
    <tr style="border-bottom: 1px solid black;">
        <td colspan="6">
            <b><center>U R A I A N</center></b>
        </td>
        <td align="right">
            <b>JUMLAH BIAYA</b>
        </td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td colspan="8" align="left">  <b><u>Prosedur Non Bedah</u> </b></td>
    </tr>
<?php
    if (count($prosedurNonBedah['data']) > 0  ) {
        foreach ($prosedurNonBedah['data'] as $pnb) {

            if($pnb['layanan']['pl_jenis_layanan'] == 2) {
                $jenis_layanan = 'RAWAT JALAN';
            } else if ($pnb['layanan']['pl_jenis_layanan'] == 1) {
                $jenis_layanan = 'IGD';
            } else if ($pnb['layanan']['pl_jenis_layanan'] == 3) {
                $jenis_layanan = 'RAWAT INAP';
            } else if ($pnb['layanan']['pl_jenis_layanan'] == 4) {
                $jenis_layanan = 'PENUNJANG';
            } else {
                 $jenis_layanan = '';
            }            
?>
        <tr>
            <td><?= date('d/m/Y H:i', strtotime($pnb['tdp_tgl'])) ?></td>
            <td colspan="5"><b><?= $jenis_layanan ?>: </b>UNIT <?= $pnb['layanan']['unit']['unt_nama'] ?></td>
            <td width="5%" ></td>
            <td width="15%" align="right"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="5"><?= isset($pnb['tarifTindakan']['tindakan']['tdk_deskripsi']) ? $pnb['tarifTindakan']['tindakan']['tdk_deskripsi'] : '' ?> </td>

            <td width="5%" >Rp. </td>
            <td width="15%" align="right"><?= number_format($pnb['tdp_subtotal'], 0, ",", ".") ?></td>
        </tr>            
<?php
        }
    }
?>    
</table>
<table width="100%" style="border-top: 1px solid black;">
    <tr>
        <td width="80%" colspan="6" align="left">
            <b>SUB TOTAL Prosedur Non Bedah</b>
        </td>        
        <td width="5%"><b>Rp.</b></td>
        <td width="15%" align="right"><b><?= number_format($prosedurNonBedah['total'], 0, ",", ".") ?></b></td>
    </tr>
</table><br/>


<table width="100%">
    <tr>
        <td colspan="8" align="left">  <b><u>Prosedur  Bedah</u> </b></td>
    </tr>
<?php
    if (count($prosedurBedah['data']) > 0  ) {
        foreach ($prosedurBedah['data'] as $pb) {

            if($pb['layanan']['pl_jenis_layanan'] == 2) {
                $jenis_layanan = 'RAWAT JALAN';
            } else if ($pb['layanan']['pl_jenis_layanan'] == 1) {
                $jenis_layanan = 'IGD';
            } else if ($pb['layanan']['pl_jenis_layanan'] == 3) {
                $jenis_layanan = 'RAWAT INAP';
            } else if ($pb['layanan']['pl_jenis_layanan'] == 4) {
                $jenis_layanan = 'PENUNJANG';
            } else {
                 $jenis_layanan = '';
            }            
?>
        <tr>
            <td><?= date('d/m/Y H:i', strtotime($pb['tdp_tgl'])) ?></td>
            <td colspan="5"><b><?= $jenis_layanan ?>: </b>UNIT <?= $pb['layanan']['unit']['unt_nama'] ?></td>
            <td width="5%" ></td>
            <td width="15%" align="right"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="5"><?= isset($pb['tarifTindakan']['tindakan']['tdk_deskripsi']) ? $pb['tarifTindakan']['tindakan']['tdk_deskripsi'] : '' ?> </td>

            <td width="5%" >Rp. </td>
            <td width="15%" align="right"><?= number_format($pb['tdp_subtotal'], 0, ",", ".") ?></td>
        </tr>            
<?php
        }
    }
?>    
</table>
<table width="100%" style="border-top: 1px solid black;">
    <tr>
        <td width="80%" colspan="6" align="left">
            <b>SUB TOTAL Prosedur Bedah</b>
        </td>        
        <td width="5%"><b>Rp.</b></td>
        <td width="15%" align="right"><b><?= number_format($prosedurBedah['total'], 0, ",", ".") ?></b></td>
    </tr>
</table><br/>

<table width="100%">
    <tr>
        <td colspan="8" align="left">  <b><u>Konsultasi</u> </b></td>
    </tr>
<?php
    if (count($konsultasi['data']) > 0  ) {
        foreach ($konsultasi['data'] as $ks) {

            if($ks['layanan']['pl_jenis_layanan'] == 2) {
                $jenis_layanan = 'RAWAT JALAN';
            } else if ($ks['layanan']['pl_jenis_layanan'] == 1) {
                $jenis_layanan = 'IGD';
            } else if ($ks['layanan']['pl_jenis_layanan'] == 3) {
                $jenis_layanan = 'RAWAT INAP';
            } else if ($ks['layanan']['pl_jenis_layanan'] == 4) {
                $jenis_layanan = 'PENUNJANG';
            } else {
                 $jenis_layanan = '';
            }            
?>
        <tr>
            <td><?= date('d/m/Y H:i', strtotime($ks['tdp_tgl'])) ?></td>
            <td colspan="5"><b><?= $jenis_layanan ?>: </b>UNIT <?= $ks['layanan']['unit']['unt_nama'] ?></td>
            <td width="5%" ></td>
            <td width="15%" align="right"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="5"><?= isset($ks['tarifTindakan']['tindakan']['tdk_deskripsi']) ? $ks['tarifTindakan']['tindakan']['tdk_deskripsi'] : '' ?> </td>

            <td width="5%" >Rp. </td>
            <td width="15%" align="right"><?= number_format($ks['tdp_subtotal'], 0, ",", ".") ?></td>
        </tr>            
<?php
        }
    }
?>    
</table>
<table width="100%" style="border-top: 1px solid black;">
    <tr>
        <td width="80%" colspan="6" align="left">
            <b>SUB TOTAL Konsultasi</b>
        </td>        
        <td width="5%"><b>Rp.</b></td>
        <td width="15%" align="right"><b><?= number_format($konsultasi['total'], 0, ",", ".") ?></b></td>
    </tr>
</table><br/>

<table width="100%">
    <tr>
        <td colspan="8" align="left">  <b><u>Tenaga Ahli</u> </b></td>
    </tr>
<?php
    if (count($tenagaAhli['data']) > 0  ) {
        foreach ($tenagaAhli['data'] as $ta) {

            if($ta['layanan']['pl_jenis_layanan'] == 2) {
                $jenis_layanan = 'RAWAT JALAN';
            } else if ($ta['layanan']['pl_jenis_layanan'] == 1) {
                $jenis_layanan = 'IGD';
            } else if ($ta['layanan']['pl_jenis_layanan'] == 3) {
                $jenis_layanan = 'RAWAT INAP';
            } else if ($ta['layanan']['pl_jenis_layanan'] == 4) {
                $jenis_layanan = 'PENUNJANG';
            } else {
                 $jenis_layanan = '';
            }            
?>
        <tr>
            <td><?= date('d/m/Y H:i', strtotime($ta['tdp_tgl'])) ?></td>
            <td colspan="5"><b><?= $jenis_layanan ?>: </b>UNIT <?= $ta['layanan']['unit']['unt_nama'] ?></td>
            <td width="5%" ></td>
            <td width="15%" align="right"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="5"><?= isset($ta['tarifTindakan']['tindakan']['tdk_deskripsi']) ? $ta['tarifTindakan']['tindakan']['tdk_deskripsi'] : '' ?> </td>

            <td width="5%" >Rp. </td>
            <td width="15%" align="right"><?= number_format($ta['tdp_subtotal'], 0, ",", ".") ?></td>
        </tr>            
<?php
        }
    }
?>    
</table>
<table width="100%" style="border-top: 1px solid black;">
    <tr>
        <td width="80%" colspan="6" align="left">
            <b>SUB TOTAL Tenaga Ahli</b>
        </td>        
        <td width="5%"><b>Rp.</b></td>
        <td width="15%" align="right"><b><?= number_format($tenagaAhli['total'], 0, ",", ".") ?></b></td>
    </tr>
</table><br/>

<table width="100%">
    <tr>
        <td colspan="8" align="left">  <b><u>Keperawatan</u> </b></td>
    </tr>
<?php
    if (count($keperawatan['data']) > 0  ) {
        foreach ($keperawatan['data'] as $kp) {

            if($kp['layanan']['pl_jenis_layanan'] == 2) {
                $jenis_layanan = 'RAWAT JALAN';
            } else if ($kp['layanan']['pl_jenis_layanan'] == 1) {
                $jenis_layanan = 'IGD';
            } else if ($kp['layanan']['pl_jenis_layanan'] == 3) {
                $jenis_layanan = 'RAWAT INAP';
            } else if ($kp['layanan']['pl_jenis_layanan'] == 4) {
                $jenis_layanan = 'PENUNJANG';
            } else {
                 $jenis_layanan = '';
            }            
?>
        <tr>
            <td><?= date('d/m/Y H:i', strtotime($kp['tdp_tgl'])) ?></td>
            <td colspan="5"><b><?= $jenis_layanan ?>: </b>UNIT <?= $kp['layanan']['unit']['unt_nama'] ?></td>
            <td width="5%" ></td>
            <td width="15%" align="right"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="5"><?= isset($kp['tarifTindakan']['tindakan']['tdk_deskripsi']) ? $kp['tarifTindakan']['tindakan']['tdk_deskripsi'] : '' ?> </td>

            <td width="5%" >Rp. </td>
            <td width="15%" align="right"><?= number_format($kp['tdp_subtotal'], 0, ",", ".") ?></td>
        </tr>            
<?php
        }
    }
?>    
</table>
<table width="100%" style="border-top: 1px solid black;">
    <tr>
        <td width="80%" colspan="6" align="left">
            <b>SUB TOTAL Keperawatan</b>
        </td>        
        <td width="5%"><b>Rp.</b></td>
        <td width="15%" align="right"><b><?= number_format($keperawatan['total'], 0, ",", ".") ?></b></td>
    </tr>
</table><br/>



<table width="100%">
    <tr>
        <td colspan="8" align="left">  <b><u>Penunjang</u> </b></td>
    </tr>
<?php
    if (count($penunjang['data']) > 0  ) {
        foreach ($penunjang['data'] as $pj) {

            if($pj['layanan']['pl_jenis_layanan'] == 2) {
                $jenis_layanan = 'RAWAT JALAN';
            } else if ($pj['layanan']['pl_jenis_layanan'] == 1) {
                $jenis_layanan = 'IGD';
            } else if ($pj['layanan']['pl_jenis_layanan'] == 3) {
                $jenis_layanan = 'RAWAT INAP';
            } else if ($pj['layanan']['pl_jenis_layanan'] == 4) {
                $jenis_layanan = 'PENUNJANG';
            } else {
                 $jenis_layanan = '';
            }            
?>
        <tr>
            <td><?= date('d/m/Y H:i', strtotime($pj['tdp_tgl'])) ?></td>
            <td colspan="5"><b><?= $jenis_layanan ?>: </b>UNIT <?= $pj['layanan']['unit']['unt_nama'] ?></td>
            <td width="5%" ></td>
            <td width="15%" align="right"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="5"><?= isset($pj['tarifTindakan']['tindakan']['tdk_deskripsi']) ? $pj['tarifTindakan']['tindakan']['tdk_deskripsi'] : '' ?> </td>

            <td width="5%" >Rp. </td>
            <td width="15%" align="right"><?= number_format($pj['tdp_subtotal'], 0, ",", ".") ?></td>
        </tr>            
<?php
        }
    }
?>    
</table>
<table width="100%" style="border-top: 1px solid black;">
    <tr>
        <td width="80%" colspan="6" align="left">
            <b>SUB TOTAL Penunjang</b>
        </td>        
        <td width="5%"><b>Rp.</b></td>
        <td width="15%" align="right"><b><?= number_format($penunjang['total'], 0, ",", ".") ?></b></td>
    </tr>
</table><br/>
<table width="100%">
    <tr>
        <td colspan="8" align="left">  <b><u>Radiologi</u> </b></td>
    </tr>
<?php
    if (count($radiologi['data']) > 0  ) {
        foreach ($radiologi['data'] as $rd) {

            if($rd['layanan']['pl_jenis_layanan'] == 2) {
                $jenis_layanan = 'RAWAT JALAN';
            } else if ($rd['layanan']['pl_jenis_layanan'] == 1) {
                $jenis_layanan = 'IGD';
            } else if ($rd['layanan']['pl_jenis_layanan'] == 3) {
                $jenis_layanan = 'RAWAT INAP';
            } else if ($rd['layanan']['pl_jenis_layanan'] == 4) {
                $jenis_layanan = 'PENUNJANG';
            } else {
                 $jenis_layanan = '';
            }            
?>
        <tr>
            <td><?= date('d/m/Y H:i', strtotime($rd['tdp_tgl'])) ?></td>
            <td colspan="5"><b><?= $jenis_layanan ?>: </b>UNIT <?= $rd['layanan']['unit']['unt_nama'] ?></td>
            <td width="5%" ></td>
            <td width="15%" align="right"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="5"><?= isset($rd['tarifTindakan']['tindakan']['tdk_deskripsi']) ? $rd['tarifTindakan']['tindakan']['tdk_deskripsi'] : '' ?> </td>

            <td width="5%" >Rp. </td>
            <td width="15%" align="right"><?= number_format($rd['tdp_subtotal'], 0, ",", ".") ?></td>
        </tr>            
<?php
        }
    }
?>    
</table>
<table width="100%" style="border-top: 1px solid black;">
    <tr>
        <td width="80%" colspan="6" align="left">
            <b>SUB TOTAL Radiologi</b>
        </td>        
        <td width="5%"><b>Rp.</b></td>
        <td width="15%" align="right"><b><?= number_format($radiologi['total'], 0, ",", ".") ?></b></td>
    </tr>
</table><br/>
<table width="100%">
    <tr>
        <td colspan="8" align="left">  <b><u>Laboratorium</u> </b></td>
    </tr>
<?php
    if (count($laboratorium['data']) > 0  ) {
        foreach ($laboratorium['data'] as $lab) {

            if($lab['layanan']['pl_jenis_layanan'] == 2) {
                $jenis_layanan = 'RAWAT JALAN';
            } else if ($lab['layanan']['pl_jenis_layanan'] == 1) {
                $jenis_layanan = 'IGD';
            } else if ($lab['layanan']['pl_jenis_layanan'] == 3) {
                $jenis_layanan = 'RAWAT INAP';
            } else if ($lab['layanan']['pl_jenis_layanan'] == 4) {
                $jenis_layanan = 'PENUNJANG';
            } else {
                 $jenis_layanan = '';
            }            
?>
        <tr>
            <td><?= date('d/m/Y H:i', strtotime($lab['tdp_tgl'])) ?></td>
            <td colspan="5"><b><?= $jenis_layanan ?>: </b>UNIT <?= $lab['layanan']['unit']['unt_nama'] ?></td>
            <td width="5%" ></td>
            <td width="15%" align="right"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="5"><?= isset($lab['tarifTindakan']['tindakan']['tdk_deskripsi']) ? $lab['tarifTindakan']['tindakan']['tdk_deskripsi'] : '' ?> </td>

            <td width="5%" >Rp. </td>
            <td width="15%" align="right"><?= number_format($lab['tdp_subtotal'], 0, ",", ".") ?></td>
        </tr>            
<?php
        }
    }
?>    
</table>
<table width="100%" style="border-top: 1px solid black;">
    <tr>
        <td width="80%" colspan="6" align="left">
            <b>SUB TOTAL Laboratorium</b>
        </td>        
        <td width="5%"><b>Rp.</b></td>
        <td width="15%" align="right"><b><?= number_format($laboratorium['total'], 0, ",", ".") ?></b></td>
    </tr>
</table><br/>
<table width="100%">
    <tr>
        <td colspan="8" align="left">  <b><u>Rehabilitasi</u> </b></td>
    </tr>
<?php
    if (count($rehabilitasi['data']) > 0  ) {
        foreach ($rehabilitasi['data'] as $rehab) {

            if($rehab['layanan']['pl_jenis_layanan'] == 2) {
                $jenis_layanan = 'RAWAT JALAN';
            } else if ($rehab['layanan']['pl_jenis_layanan'] == 1) {
                $jenis_layanan = 'IGD';
            } else if ($rehab['layanan']['pl_jenis_layanan'] == 3) {
                $jenis_layanan = 'RAWAT INAP';
            } else if ($rehab['layanan']['pl_jenis_layanan'] == 4) {
                $jenis_layanan = 'PENUNJANG';
            } else {
                 $jenis_layanan = '';
            }            
?>
        <tr>
            <td><?= date('d/m/Y H:i', strtotime($rehab['tdp_tgl'])) ?></td>
            <td colspan="5"><b><?= $jenis_layanan ?>: </b>UNIT <?= $rehab['layanan']['unit']['unt_nama'] ?></td>
            <td width="5%" ></td>
            <td width="15%" align="right"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="5"><?= isset($rehab['tarifTindakan']['tindakan']['tdk_deskripsi']) ? $rehab['tarifTindakan']['tindakan']['tdk_deskripsi'] : '' ?> </td>

            <td width="5%" >Rp. </td>
            <td width="15%" align="right"><?= number_format($rehab['tdp_subtotal'], 0, ",", ".") ?></td>
        </tr>            
<?php
        }
    }
?>    
</table>
<table width="100%" style="border-top: 1px solid black;">
    <tr>
        <td width="80%" colspan="6" align="left">
            <b>SUB TOTAL Rehabilitasi</b>
        </td>        
        <td width="5%"><b>Rp.</b></td>
        <td width="15%" align="right"><b><?= number_format($rehabilitasi['total'], 0, ",", ".") ?></b></td>
    </tr>
</table><br/>

<table width="100%">
    <tr>
        <td colspan="8" align="left"><b><u>Kamar/ Akomodasi</u> </b></td>
    </tr>
<?php
    foreach ($akomodasi as $akom) {

		$tanggal_hari_ini= date('d-m-Y H:i');        
        $lama_akomodasi =0;
        $checkout = null;

        if ($akom['pl_tgl_keluar'] == null) {

            $selish_tanggal = date_diff(date_create($tanggal_hari_ini), date_create($akom['pl_tgl_masuk']));
            $checkout=' Hari ini '. $tanggal_hari_ini." (<b>Belum Checkout</b>) ";

        }else{
            $selish_tanggal = date_diff(date_create($akom['pl_tgl_keluar']), date_create($akom['pl_tgl_masuk']));                
            $checkout = $akom['pl_tgl_keluar'];
        }

        $lama_akomodasi = $selish_tanggal->d;

        $tarif_per_hari = $akom['kamar']['tarifkamar']['tkr_biaya'];

        if ($selish_tanggal->h >= 6) {
            $sub_biaya_akomodasi = ($lama_akomodasi + 1) * $tarif_per_hari;
        }else{
            $sub_biaya_akomodasi = $lama_akomodasi * $tarif_per_hari;
        }
?>
	<tr>
        <td colspan="6">KAMAR <?= isset($akom['kamar']) ? $akom['kamar']['kmr_no_kamar'] : '' ?> 
		No Kasur : <?= isset($akom['kamar']) ? $akom['kamar']['kmr_no_kasur'] : '' ?>
	    </td>
        <td width="5%"> </td>
        <td width="15%" align="right"></td>
    </tr>
    <tr>
        <td colspan="6">dari tanggal :  <?= $akom['pl_tgl_masuk'] ?> s/d <?= $checkout ?>   </td>
        <td width="5%" ></td>
        <td width="15%" align="right"></td>
    </tr>
    <tr>
        <td colspan="6" style="border-bottom: 1px solid black;">JUMLAH HARI (<?= $lama_akomodasi ." Hari ".$selish_tanggal->h." Jam X ".number_format($tarif_per_hari, 0, ",", ".")   ?>) </td>
        <td width="5%" style="border-bottom: 1px solid black;">Rp.</td>
        <td width="15%" align="right" style="border-bottom: 1px solid black;"><?= number_format($sub_biaya_akomodasi, 0, ",", ".") ?></td>
    </tr>

<?php
    }
?>    
</table>
<table width="100%" style="border-top: 1px solid black;">
    <tr>
        <td width="80%" colspan="6" align="left">
            <b>SUB TOTAL Kamar/ Akomodasi</b>
        </td>
        <td width="5%"><b>Rp.</b></td>
        <td width="15%" align="right"><b></b></td>
    </tr>
</table><br/>

<table width="100%">
    <tr>
        <td colspan="8" align="left"><b><u>Ruang Intensif</u> </b></td>
    </tr>
<?php
    foreach ($ruangIntensif as $inten) {

		$tanggal_hari_ini= date('d-m-Y H:i');        
        $lama_inten =0;
        $checkout = null;
        $sub_biaya_inten = 0;

        if ($inten['pl_tgl_keluar'] == null) {

            $selish_tanggal = date_diff(date_create($tanggal_hari_ini), date_create($inten['pl_tgl_masuk']));
            $checkout=' Hari ini '. $tanggal_hari_ini." (<b>Belum Checkout</b>) ";

        }else{
            $selish_tanggal = date_diff(date_create($inten['pl_tgl_keluar']), date_create($inten['pl_tgl_masuk']));                
            $checkout = $inten['pl_tgl_keluar'];
        }

        $lama_inten = $selish_tanggal->d;

        $tarif_per_hari = $inten['kamar']['tarifkamar']['tkr_biaya'];

        if ($selish_tanggal->h >= 6) {
            $sub_biaya_inten = ($lama_inten + 1) * $tarif_per_hari;
        }else{
            $sub_biaya_inten = $lama_inten * $tarif_per_hari;
        }

        // $sub_biaya_akomodasi = $lama_inten * $tarif_per_hari;
?>
	<tr>
        <td colspan="6">KAMAR <?= isset($inten['kamar']) ? $inten['kamar']['kmr_no_kamar'] : '' ?> 
		No Kasur : <?= isset($inten['kamar']) ? $inten['kamar']['kmr_no_kasur'] : '' ?>
	    </td>
        <td width="5%"> </td>
        <td width="15%" align="right"></td>
    </tr>
    <tr>
        <td colspan="6">dari tanggal :  <?= $inten['pl_tgl_masuk'] ?> s/d <?= $checkout ?>   </td>
        <td width="5%" ></td>
        <td width="15%" align="right"></td>
    </tr>
    <tr>
        <td colspan="6" style="border-bottom: 1px solid black;">JUMLAH HARI (<?= $lama_inten ." Hari ".$selish_tanggal->h." Jam X ".number_format($tarif_per_hari, 0, ",", ".")   ?>) </td>
        <td width="5%" style="border-bottom: 1px solid black;">Rp.</td>
        <td width="15%" align="right" style="border-bottom: 1px solid black;"><?= number_format($sub_biaya_inten, 0, ",", ".") ?></td>
    </tr>

<?php
    }
?>    
</table>
<table width="100%" style="border-top: 1px solid black;">
    <tr>
        <td width="80%" colspan="6" align="left">
            <b>SUB TOTAL Ruang Intensif</b>
        </td>
        <td width="5%"><b>Rp.</b></td>
        <td width="15%" align="right"><b></b></td>
    </tr>
</table><br/>

<table width="100%">
    <tr>
        <td colspan="8" align="left">
            <b><u>BIAYA OBAT-OBATAN</u></b>
        </td>
    </tr>
	<tr>
		<td colspan="8" style="border-top: 1px solid black;"></td>
	</tr>
	<tr>
		<td></td>
        <td><b>Deskripsi Layanan</b></td>
		<td><center><b>Tarif Service</b></center></td>
		<td colspan="2"><center><b>Tarif Obat</b></center></td>
        <td width="5%" ></td>
        <td width="10%" align="right"><center><b>Total</b></center></td>
    </tr>
	<tr>
		<td colspan="8" style="border-bottom: 1px solid black;"></td>
	</tr>
	<?php
	$TotalBiayaObat = 0;
    if($biayaObat['dataObat'] != Null) {
		foreach($biayaObat['dataObat'] as $r) {
	
			$TotalBiayaObat += $r['total_biaya'];
			
	?>
	<tr>
        <td width="80%" colspan="6" align="left">
            <b><?= $r['nama_depo'] ?></b>
        </td>
        <td width="5%"><b>Rp.</b></td>
        <td width="15%" align="right"><b><?= number_format($r['total_biaya'], 0, ",", ".") ?></b></td>
    </tr>
	<?php
			if($r['penjualan'] != null) {
				foreach($r['penjualan'] as $p) {
					
	?>
	<tr>
		<td width="5%"></td>
        <td width="75%" colspan="5" align="left">
            <b><?= date('d/m/Y', strtotime($p['pnj_tanggal_resep'])).' '.$p['pnj_jam_resep'] ?></b>
        </td>
        <td width="5%"><b>Rp.</b></td>
        <td width="15%" align="right"><?= number_format($p['pnj_total_penjualan'], 0, ",", ".") ?></td>
    </tr>
	<?php
					if(isset($p['detail'])) {
						$Subtotal = 0;
						foreach($p['detail'] as $d) {
							
	?>
	<tr>
		<td></td>
        <td><?= $d['nama_barang'] ?></td>
		<td><?= ' 1 x '.number_format($d['biaya_layanan'], 0, ",", ".") ?></td>
		<td colspan="2"><?= $d['jumlah'].' '.$d['satuan']. ' x '.number_format($d['harga'], 0, ",", ".") ?></td>
        <td width="5%" >: Rp.</td>
        <td width="10%" align="right"><?= number_format(($d['jumlah']*$d['harga']+$d['biaya_layanan']), 0, ",", ".") ?></td>
    </tr>
	<?php
						$Subtotal +=  $d['subtotal'];
						}
						?>
	<tr>
		<td></td>
        <td><b> SUBTOTAL </b></td>
		<td colspan="3">  </td>
        <td width="5%" >: Rp.</td>
        <td width="10%" align="right"><?= number_format($Subtotal, 0, ",", ".") ?></td>
    </tr>
						<?php
					}
				}
			}
		}
	}
    ?>
</table>
<table width="100%" style="border-top: 1px solid black;">
    <tr>
        <td width="80%" colspan="6" align="left">
            <b>SUB TOTAL BIAYA OBAT</b>
        </td>
        <td width="5%"><b>Rp.</b></td>
        <td width="15%" align="right"><b><?= number_format($TotalBiayaObat, 0, ",", ".") ?></b></td>
    </tr>
</table><br/>

<table width="100%">
    <tr>
        <td colspan="8" align="left">  <b><u>Pemakaian Alat Medis</u> </b></td>
    </tr>
<?php

    if (count($alatMedis['data']) > 0  ) {
        foreach ($alatMedis['data'] as $am) {

            if($am['layanan']['pl_jenis_layanan'] == 2) {
                $jenis_layanan = 'RAWAT JALAN';
            } else if ($am['layanan']['pl_jenis_layanan'] == 1) {
                $jenis_layanan = 'IGD';
            } else if ($am['layanan']['pl_jenis_layanan'] == 3) {
                $jenis_layanan = 'RAWAT INAP';
            } else if ($am['layanan']['pl_jenis_layanan'] == 4) {
                $jenis_layanan = 'PENUNJANG';
            } else {
                 $jenis_layanan = '';
            }            
?>
        <tr>
            <td><?= date('d/m/Y H:i', strtotime($am['tdp_tgl'])) ?></td>
            <td colspan="5"><b><?= $jenis_layanan ?>: </b>UNIT <?= $am['layanan']['unit']['unt_nama'] ?></td>
            <td width="5%" ></td>
            <td width="15%" align="right"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="5"><?= isset($am['tarifTindakan']['tindakan']['tdk_deskripsi']) ? $am['tarifTindakan']['tindakan']['tdk_deskripsi'] : '' ?> </td>

            <td width="5%" >Rp. </td>
            <td width="15%" align="right"><?= number_format($am['tdp_subtotal'], 0, ",", ".") ?></td>
        </tr>            
<?php
        }
    }
?>    
</table>
<table width="100%" style="border-top: 1px solid black;">
    <tr>
        <td width="80%" colspan="6" align="left">
            <b>SUB TOTAL Pemakaian Alat Medis</b>
        </td>        
        <td width="5%"><b>Rp.</b></td>
        <td width="15%" align="right"><b><?= number_format($alatMedis['total'], 0, ",", ".") ?></b></td>
    </tr>
</table><br/>



<table width="100%">
    <tr>
        <td colspan="8" align="left">  <b><u>Tindakan/ Biaya Lain</u> </b></td>
    </tr>
<?php
    if (count($tindakanLain['data']) > 0  ) {
        foreach ($tindakanLain['data'] as $tl) {

            if($tl['layanan']['pl_jenis_layanan'] == 2) {
                $jenis_layanan = 'RAWAT JALAN';
            } else if ($tl['layanan']['pl_jenis_layanan'] == 1) {
                $jenis_layanan = 'IGD';
            } else if ($tl['layanan']['pl_jenis_layanan'] == 3) {
                $jenis_layanan = 'RAWAT INAP';
            } else if ($tl['layanan']['pl_jenis_layanan'] == 4) {
                $jenis_layanan = 'PENUNJANG';
            } else {
                 $jenis_layanan = '';
            }            
?>
        <tr>
            <td><?= date('d/m/Y H:i', strtotime($tl['tdp_tgl'])) ?></td>
            <td colspan="5"><b><?= $jenis_layanan ?>: </b>UNIT <?= $tl['layanan']['unit']['unt_nama'] ?></td>
            <td width="5%" ></td>
            <td width="15%" align="right"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="5"><?= isset($tl['tarifTindakan']['tindakan']['tdk_deskripsi']) ? $tl['tarifTindakan']['tindakan']['tdk_deskripsi'] : '' ?> </td>

            <td width="5%" >Rp. </td>
            <td width="15%" align="right"><?= number_format($tl['tdp_subtotal'], 0, ",", ".") ?></td>
        </tr>            
<?php
        }
    }
?>    
</table>
<table width="100%" style="border-top: 1px solid black;">
    <tr>
        <td width="80%" colspan="6" align="left">
            <b>SUB TOTAL Biaya Lain</b>
        </td>        
        <td width="5%"><b>Rp.</b></td>
        <td width="15%" align="right"><b><?= number_format($tindakanLain['total'], 0, ",", ".") ?></b></td>
    </tr>
</table><br/>

<table width="100%" style="border-top: 1px solid black;">
    <tr>
        <td width="80%" colspan="6" align="left">
            <b>Total Keseluruhan</b>
        </td>
        <td width="5%"><b>Rp.</b></td>
        <td width="15%" align="right"><b>
                <?php $total = (isset($prosedurNonBedah['total']) ? $prosedurNonBedah['total'] : 0) + (isset($prosedurBedah['total']) ? $prosedurBedah['total'] : 0) + (isset($konsultasi['total']) ? $konsultasi['total'] : 0) + (isset($tenagaAhli['total']) ? $tenagaAhli['total'] : 0) + (isset($keperawatan['total']) ? $keperawatan['total'] : 0) + (isset($penunjang['total']) ? $penunjang['total'] : 0) + (isset($radiologi['total']) ? $radiologi['total'] : 0) + (isset($laboratorium['total']) ? $laboratorium['total'] : 0) + (isset($rehabilitasi['total']) ? $rehabilitasi['total'] : 0) + (isset($sub_biaya_akomodasi) ? $sub_biaya_akomodasi : 0)  + (isset($TotalBiayaObat) ? $TotalBiayaObat : 0) + (isset($alatMedis['total']) ? $alatMedis['total'] : 0) + (isset($tindakanLain['total']) ? $tindakanLain['total'] : 0); ?>
                <?= number_format($total, 0, ",",".") ?></b></td>
    </tr>
</table><br/>


