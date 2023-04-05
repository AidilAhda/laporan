<?php
use app\models\PendaftaranLayanan;
use app\models\PendaftaranRegistrasi;
use app\models\MedisRingkasanKeluar;
use app\models\SdmMPegawai;
use app\models\SdmMUnit;
use app\models\PendaftaranPasien;

$instalasi = '';
if ($layanan == 1) {
    $instalasi = 'INSTALASI GAWAT DARURAT';
} elseif ($layanan == 2) {  
    $instalasi = 'INSTALASI RAWAT JALAN';
} elseif ($layanan == 3) {
    $instalasi = 'INSTALASI RAWAT INAP';
}else{
    $instalasi = '';
}

?>
<h3 align="center">LAPORAN DIAGNOSA <?=$instalasi?$instalasi:''?></h3>
<h4 align="center">Tanggal : <?= date('d-M-Y', strtotime($mulai)) ?> Sampai <?= date('d-M-Y', strtotime($selesai)) ?>
</h4>
<br>
<table width="100%" border="1" cellspacing="0" style="text-align: center;vertical-align: middle;">
    <tr>
        <th>No</th>
        <th>NO RM</th>
        <th>Kode Diagnosa</th>
        <th>Nama Pasien</th>
        <th>Nama DPJP</th>
        <th>Ruangan</th>
        <th>Diagnosa</th>
        <th>Keluhan</th>
        <th>Riwayat Penyakit</th>
        <!-- <th>Pemeriksaan Fisik</th> -->
        <th>Terapi</th>
        <th>Tgl Masuk</th>

        <th>Tgl Keluar</th>
    </tr>

    <?php  $no = 1; foreach ($model as $val){
        $registrasi = PendaftaranRegistrasi::find()->where(['reg_kode' => $val['layanan']['pl_reg_kode']])->one();
        // $nama_dpjp = '';
        //     if($val['pl_jenis_layanan'] == 3){
        //      $dpjp = \app\models\PjpRi::find()->joinWith(['pegawai'])->where(['pjpri_reg_kode' => $val['pl_reg_kode'], 'pjpri_status' => 1])->andWhere('pjpri_deleted_at is null')->one();              
        //     }else{
        //         $dpjp = \app\models\Pjp::find()->joinWith(['pegawai'])->where(['pjp_pl_id' => $val['pl_id'], 'pjp_status' => 1])->andWhere('pjp_deleted_at is null')->one();
        //     }
        $dpjp = SdmMPegawai::find()->where(['pgw_id' => $val['rmrj_dokter_id']])->one();
        $pasien = PendaftaranPasien::find()->where(['ps_kode' =>$registrasi->reg_pasien_kode ])->one();
        $unit = SdmMUnit::find()->where(['unt_id' =>$val['layanan']['pl_unit_kode'] ])->one();
        
       // Tuberculous Peripheral Lymphadenopathy
        //Benign Lipomatous Neoplasm Of Skin And Subcutaneous Tissue Of Limb
        
        ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $registrasi->reg_pasien_kode; ?></td>
        <td><?= ($val['rmrj_diagnosis_utama_kode']?$val['rmrj_diagnosis_utama_kode']:'').'<BR>'.($val['rmrj_diagnosis_tambahan1_kode']?$val['rmrj_diagnosis_tambahan1_kode']:'').'<BR>'.($val['rmrj_diagnosis_tambahan2_kode']?$val['rmrj_diagnosis_tambahan2_kode']:'').'<BR>'.($val['rmrj_diagnosis_tambahan3_kode']?$val['rmrj_diagnosis_tambahan3_kode']:'').'<BR>'.($val['rmrj_diagnosis_tambahan4_kode']?$val['rmrj_diagnosis_tambahan4_kode']:'').'<BR>'.($val['rmrj_diagnosis_tambahan5_kode']?$val['rmrj_diagnosis_tambahan5_kode']:'').'<BR>'.($val['rmrj_diagnosis_tambahan6_kode']?$val['rmrj_diagnosis_tambahan6_kode']:'').'<BR>'.($val['rmrj_diagnosis_tambahan7_kode']?$val['rmrj_diagnosis_tambahan7_kode']:'').'<BR>'.($val['rmrj_diagnosis_tambahan8_kode']?$val['rmrj_diagnosis_tambahan8_kode']:'').'<BR>'.($val['rmrj_diagnosis_tambahan9_kode']?$val['rmrj_diagnosis_tambahan9_kode']:'')?>
        </td>
        <td><?= $pasien?$pasien->ps_nama:' - '; ?></td>
        <td><?= $dpjp ? $dpjp->pgw_gelar_depan .''. $dpjp->pgw_nama .' '.$dpjp->pgw_gelar_belakang : ' - '  ?></td>
        <td><?= $unit ? $unit->unt_nama: ' - '  ?></td>
        <td><?=($val['rmrj_diagnosis_utama_deskripsi']?$val['rmrj_diagnosis_utama_deskripsi'].'(Diagnosa Utama)': '').'<BR>'.($val['rmrj_diagnosis_tambahan1_deskripsi']?$val['rmrj_diagnosis_tambahan1_deskripsi'].'(Diagnosa Tambahan 1)':'').'<BR>'.($val['rmrj_diagnosis_tambahan2_deskripsi']?$val['rmrj_diagnosis_tambahan2_deskripsi'].'(Diagnosa Tambahan 2)':'').'<BR>'.($val['rmrj_diagnosis_tambahan3_deskripsi']?$val['rmrj_diagnosis_tambahan3_deskripsi'].'(Diagnosa Tambahan 3)':'').'<BR>'.($val['rmrj_diagnosis_tambahan4_deskripsi']?$val['rmrj_diagnosis_tambahan4_deskripsi'].'(Diagnosa Tambahan 4)':'').'<BR>'.($val['rmrj_diagnosis_tambahan5_deskripsi']?$val['rmrj_diagnosis_tambahan5_deskripsi'].'(Diagnosa Tambahan 5)':'').'<BR>'.($val['rmrj_diagnosis_tambahan6_deskripsi']?$val['rmrj_diagnosis_tambahan6_deskripsi'].'(Diagnosa Tambahan 6)':'').'<BR>'.($val['rmrj_diagnosis_tambahan7_deskripsi']?$val['rmrj_diagnosis_tambahan7_deskripsi'].'(Diagnosa Tambahan 7)':'').'<BR>'.($val['rmrj_diagnosis_tambahan8_deskripsi']?$val['rmrj_diagnosis_tambahan8_deskripsi'].'(Diagnosa Tambahan 8)':'').'<BR>'.($val['rmrj_diagnosis_tambahan9_deskripsi']?$val['rmrj_diagnosis_tambahan9_deskripsi'].'(Diagnosa Tambahan 9)':'')?>
        </td>
        <td><?= $val['rmrj_keluhan']?></td>
        <td><?= $val['rmrj_riwayat_penyakit'] ?$val['rmrj_riwayat_penyakit']: ' - ' ?></td>

        <td><?= $val['rmrj_terapi']?></td>
        <td><?= $registrasi->reg_tgl_masuk ? date('d-M-Y H:i:s', strtotime($registrasi->reg_tgl_masuk)) : ' - '  ?></td>
        <td><?= $registrasi->reg_tgl_keluar ? date('d-M-Y H:i:s', strtotime($registrasi->reg_tgl_keluar)) : ' - '  ?>
        </td>


        </td>
    </tr>
    <?php } ?>
    <tr>
        <td></td>
        <td><strong>Total diagnosa</strong></td>
        <td><strong><?=$total?></strong></td>
    </tr>
</table>