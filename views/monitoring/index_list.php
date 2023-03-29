<?php
use yii\helpers\Html;
?>
<style type="text/css">
     .tableFixHead {
        overflow-y: auto;
        height: 580px;
    }

    .tableFixHead table {
        border-collapse: collapse;
        width: 100%;
    }

    .tableFixHead th,
    .tableFixHead td {
        padding: 8px 16px;
    }

    .tableFixHead th {
        position: sticky;
        top: 0;
        background: #eee;
    }
</style>
<div class="col-md-12">
    <div class="box box-success">
        <div class="box-header with-border">
            <div class="box-body table-responsive tableFixHead" style="overflow-y: scroll; height:500px; overflow-x: hidden;">
                <table id="TabelDaftar" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>
                                <center><b>No.</b></center>
                            </th>
                            <th>
                                <center><b>Tanggal Masuk</b></center>
                            </th>
                            <th>
                                <center><b>No. Registrasi </b></center>
                            </th>
                            <th>
                                <center><b>No. RM</b></center>
                            </th>
                            <th>
                                <center><b>NIK</b></center>
                            </th>
                            <th>
                                <center><b>Nama </b></center>
                            </th>
                            <th>
                                <center><b>Unit Pelayanan </b></center>
                            </th>
                            <th>
                                <center><b>STATUS PEMBAYARAN</b></center>
                            </th>
                             <th>
                                <center><b>Cara Bayar </b></center>
                            </th>
                            <th>
                                <center><b>Aksi </b></center>
                            </th>
                       </tr>
                   </thead>
                   <tbody>
                    <!-- Data -->
                        <?php         
                            if($data != Null) {
                            $no=1;
                            foreach ($data as $d) {
//                            echo var_dump($d['registrasi']['reg_pasien_kode']);
//                            echo var_dump($d['registrasi']['reg_kode']);
//
//                            exit();
                                $connection = \Yii::$app->getDb();
                                isset($model->pgw_tanggal_lahir) ? Helper::hitung_umur($model->pgw_tanggal_lahir) : "Tanggal Lahir Kosong";
                                isset($d['registrasi']['reg_pasien_kode']) ? $d['registrasi']['reg_pasien_kode'] : '';
                                if(isset($d['registrasi'])){
                                    $command = $connection
                                        ->createCommand("SELECT lab_kode FROM ess_result_labor WHERE lab_pasien_kode ='".$d['registrasi']['reg_pasien_kode']."' AND lab_hasil_status='3' AND lab_reg_kode='".$d['registrasi']['reg_kode']."'");
                                    $id_pemeriksaan_labor= $command->queryAll();

                                    $commandrad = $connection
                                        ->createCommand("SELECT rsr_kode FROM ess_result_radiologi WHERE rsr_pasien_kode ='".$d['registrasi']['reg_pasien_kode']."' AND rsr_reg_kode='".$d['registrasi']['reg_kode']."' and rsr_resume_status > 2");
                                    $id_pemeriksaan_rad= $commandrad->queryAll();
                                }


                        ?>
                                 <tr style="<?= ($d['pl_deleted_at'] != null ? 'background-color:red; color:white;' : '') ?>">
                                    <td align="center"><?=  $no++; ?></td>
                                    <td align="center"><?= date("d-m-Y H:i:s", strtotime($d['pl_tgl_masuk'])); ?></td>
                                    <td align="center"><?= $d['registrasi']  ? $d['registrasi']['reg_kode'] : '' ?></td>
                                     <td align="center"><?= $d['registrasi'] ? $d['registrasi']['reg_pasien_kode'] : '' ?></td>
                                     <td align="center"><?= $d['registrasi'] ?  ($d['registrasi']['pasien']['ps_no_identitas'] ? $d['registrasi']['pasien']['ps_no_identitas'] : '') : '' ?></td>

                                    <td align="center"><?= $d['registrasi'] ? $d['registrasi']['pasien']['ps_nama'] : '' ?> </td>
                                    <td align="center" style="display: none"><?= $d['unit']['unt_id'] ?></td>
                                    <td align="center"><?= $d['unit']['unt_nama'] ?></td>
                                    <td align="center"><?php
                                    if($d['registrasi']) {
                                        if ($d['registrasi']['reg_status_bayar'] == 0) {
                                            echo "<span class='label label-info'> BELUM LUNAS</span>";
                                        } elseif ($d['registrasi']['reg_status_bayar'] == 1) {
                                            echo "<span class='label label-success'> LUNAS</span>";
                                        } else {
                                            echo "<span class='label label-warning'> KOREKSI</span>";
                                        }
                                    }
                                    ?>
                                    </td>
                                    <td align="center" style="display: none"><?= $d['registrasi'] ? $d['registrasi']['reg_pmdd_kode'] : '' ?></td>
                                    <td align="center"><?= $d['registrasi'] ? $d['registrasi']['debiturdetail']['pmdd_nama'] : ''?></td>
                                    <td>

									<!-- <button 
                                            class="btn btn-info btn-detail-pembayaran" 
                                            id="<?php// $d['registrasi']['reg_pasien_kode'].'_'.$d['registrasi']['reg_kode'].'_'.$d['registrasi']['pasien']['ps_nama'].'_'.$d['registrasi']['reg_tgl_masuk'] ?>" 
                                            style="cursor: pointer">
                                            <i class="fa fa-book"></i> Klaim Data</button> -->
<?php if($d['registrasi']){ ?>
                                    <?= Html::a('<i class="fa fa-search"></i> Detail Transaksi', ['monitoring/cetak-rincian-klaim', 'NoPasien' => $d['registrasi']['reg_pasien_kode'], 'NoDaftar' => $d['registrasi']['reg_kode']], ['class' => 'btn btn-success', 'target'=>'_blank']) ?>

<?php }?>
<?php
                                    if (isset($id_pemeriksaan_labor)) {

                                        foreach ($id_pemeriksaan_labor as $itemlab) {


?>
                                    <a class="btn btn-info btn-sm" href="http://penunjang.rsudbangkinang.kamparkab.go.id/web/cetak/cetak-labor?id=<?= $itemlab['lab_kode'] ?>" target="_blank">Hasil Labor</a>
<?php
                                                                            }
                                    }
?>

<?php
                                    if (isset($id_pemeriksaan_rad)) {
                foreach ($id_pemeriksaan_rad as $itemrad) {


?>
                                    <a class="btn btn-warning btn-sm" href="http://penunjang.rsudbangkinang.kamparkab.go.id/web/cetak/cetak-radiologi?id=<?= $itemrad['rsr_kode'] ?>" target="_blank">Hasil Radiologi
<?php
                                    }}
?>

									</td>
                                </tr>
                                <?php
                                    }

                                } else {
                                ?>
                                <tr>
                                    <td colspan="11"><span class="success"> Tidak Ada Data</span></td>
                                </tr>
                                <?php
                                }
                                ?>
                   </tbody>
               </table>
          </div>
        </div>
    </div>
</div>
