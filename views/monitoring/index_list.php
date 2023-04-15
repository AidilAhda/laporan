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
                                     
                                     <td><?=($d['registrasi']?($d['registrasi']['pasien']?$d['registrasi']['pasien']['ps_no_identitas']:'-'):'-')?></td>
                                     <td><?=($d['registrasi']?($d['registrasi']['pasien']?$d['registrasi']['pasien']['ps_nama']:'-'):'-')?></td>

                                    
                                    <td align="center" style="display: none"><?= $d['unit']['unt_id'] ?></td><td align="center"><?= isset($d['unit']['unt_nama'])?$d['unit']['unt_nama']:'' ?></td>
                                    <?php if(isset($d['registrasi']['reg_status_bayar'])) {?><td align="center"><?= ($d['registrasi']['reg_status_bayar'] == 0 ? "<span class='label label-info'> BELUM LUNAS</span>" : ($d['registrasi']['reg_status_bayar'] == 1 ?"<span class='label label-success'> LUNAS</span>" : "<span class='label label-warning'> KOREKSI</span>")) ?></td>
                                    <?php }else{?><td>
                                        <span class='label label-success'></span>
                                        </td>
                                    <?php }?>
                                    <td align="center" style="display: none"><?= isset($d['registrasi']['reg_pmdd_kode'])?$d['registrasi']['reg_pmdd_kode'] : '' ?></td>
                                    <td align="center"><?= isset($d['registrasi']['debiturdetail']['pmdd_nama']) ? $d['registrasi']['debiturdetail']['pmdd_nama'] : '' ?></td>
                                    <td>

									<!-- <button 
                                            class="btn btn-info btn-detail-pembayaran" 
                                            id="<?php// $d['registrasi']['reg_pasien_kode'].'_'.$d['registrasi']['reg_kode'].'_'.$d['registrasi']['pasien']['ps_nama'].'_'.$d['registrasi']['reg_tgl_masuk'] ?>" 
                                            style="cursor: pointer">
                                            <i class="fa fa-book"></i> Klaim Data</button> -->
                                       <?= Html::a('<i class="fa fa-search"></i> Detail Transaksi', ['monitoring/cetak-rincian-klaim', 'NoPasien' => isset($d['registrasi']['reg_pasien_kode'])?$d['registrasi']['reg_pasien_kode']:'', 'NoDaftar' => isset($d['registrasi']['reg_kode'])?$d['registrasi']['reg_kode']:'', 'pl_id' => isset($d) ? $d['pl_id'] : ''], ['class' => 'btn btn-success', 'target'=>'_blank']) ?>

                                    <?php
                                    if ($id_pemeriksaan_labor) {?>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">Labor
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <?php $no = 1; foreach ($id_pemeriksaan_labor as $itemlab) { ?>
                                                    <li><a href="http://penunjang.rsudbangkinang.kamparkab.go.id/web/cetak/cetak-labor?id=<?= $itemlab['lab_kode'] ?>" target="_blank">Hasil <?= $no++ ?></a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    <?php } ?>

                                <?php
                                if ($id_pemeriksaan_rad) {?>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">Radiologi
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <?php $no = 1; foreach ($id_pemeriksaan_rad as $itemrad) { ?>
                                                <li><a href="http://penunjang.rsudbangkinang.kamparkab.go.id/web/cetak/cetak-radiologi?id=<?= $itemrad['rsr_kode'] ?>" target="_blank">Hasil <?= $no++ ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                <?php } ?>

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
