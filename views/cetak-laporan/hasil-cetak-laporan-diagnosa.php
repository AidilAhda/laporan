<?php
use app\models\PendaftaranLayanan;
use app\models\PendaftaranRegistrasi;
use app\models\MedisRingkasanKeluar;
use app\models\SdmMPegawai;
use app\models\SdmMUnit;
use app\models\PendaftaranPasien;
?>
<h3 align="center">Laporan Diagnosa </h3>
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
        <th>Pemeriksaan Fisik</th>
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
        <td><?= $val['rmrj_diagnosis_utama_kode']?>
        </td>
        <td><?= $pasien?$pasien->ps_nama:' - '; ?></td>
        <td><?= $dpjp ? $dpjp->pgw_gelar_depan .''. $dpjp->pgw_nama .' '.$dpjp->pgw_gelar_belakang : ' - '  ?></td>
        <td><?= $unit ? $unit->unt_nama: ' - '  ?></td>
        <td><?=($val['rmrj_diagnosis_utama_deskripsi']?$val['rmrj_diagnosis_utama_deskripsi'].'(Diagnosa Utama)': '')?>
        </td>
        <td><?= $val['rmrj_keluhan']?></td>
        <td><?= $val['rmrj_riwayat_penyakit'] ?$val['rmrj_riwayat_penyakit']: ' - ' ?></td>
        <td><?= $val['rmrj_pemeriksaan_fisik']?$val['rmrj_pemeriksaan_fisik']:'- '?></td>
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