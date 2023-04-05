<?php
use app\models\PendaftaranLayanan;
use app\models\PendaftaranRegistrasi;
use app\models\MedisRingkasanKeluar;
use app\models\SdmMPegawai;
use app\models\SdmMUnit;
use app\models\PendaftaranPasien;
use app\models\MedisResumeMedisRj;



?>
<h3 align="center">LAPORAN DEBITUR</h3>
<h4 align="center">Tanggal : <?= date('d-M-Y', strtotime($mulai)) ?> Sampai <?= date('d-M-Y', strtotime($selesai)) ?>
</h4>
<br>
<table width="100%" border="1" cellspacing="0" style="text-align: center;vertical-align: middle;">
    <tr>
        <th>No</th>
        <th>NO RM</th>
        <th>Nama Debitur</th>
        <th>Nama Pasien</th>
        <th>Ruangan</th>
        <th>Nama DPJP</th>
        <th>Diagnosa</th>
        <th>Keluhan</th>
        <th>Terapi</th>
        <th>Tgl Masuk</th>
        <th>Tgl Keluar</th>
    </tr>

    <?php  $no = 1; foreach ($model as $val){
        
        $nama_dpjp = '';
            if($val['layananhasone']['pl_jenis_layanan'] == 3){
            $dpjp = \app\models\PjpRi::find()->joinWith(['pegawai'])->where(['pjpri_reg_kode' => $val['layananhasone']['pl_reg_kode'], 'pjpri_status' => 1])->andWhere('pjpri_deleted_at is null')->one();              
            }else{
                $dpjp = \app\models\Pjp::find()->joinWith(['pegawai'])->where(['pjp_pl_id' => $val['layananhasone']['pl_id'], 'pjp_status' => 1])->andWhere('pjp_deleted_at is null')->one();
            }
            $unit = SdmMUnit::find()->where(['unt_id' =>$val['layananhasone']['pl_unit_kode'] ])->one();
            $diagnosa = MedisResumeMedisRj::find()->where(['rmrj_pl_id'=>$val['layananhasone']['pl_id']])->one();
        ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $val['reg_pasien_kode'] ?></td>
        <td><?= $val['debiturdetail']['pmdd_nama'] ?></td>
        <td><?= $val['pasien']?$val['pasien']['ps_nama']:"-" ?></td>
        <td><?= $unit ? $unit->unt_nama: ' - '  ?></td>
        <td><?= $dpjp ? ($dpjp->pegawai ? $dpjp->pegawai->pgw_gelar_depan.' '. $dpjp->pegawai->pgw_nama.' '.$dpjp->pegawai->pgw_gelar_belakang : '-'): ' - '  ?>
        </td>
        <td> <?=$diagnosa?$diagnosa->rmrj_diagnosis_utama_deskripsi:'-'?></td>
        <td><?=$diagnosa?$diagnosa->rmrj_keluhan:'-'?></td>
        <td><?=$diagnosa?$diagnosa->rmrj_terapi:'-'?></td>
        <td><?= $val['reg_tgl_masuk'] ?></td>
        <td><?= $val['reg_tgl_keluar'] ?></td>


    </tr>
    <?php } ?>
</table>