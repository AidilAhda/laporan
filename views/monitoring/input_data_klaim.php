<?php
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
?>

<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Form Data Klaim</h4>
        </div>
        <div class="modal-body">
            <?php $form = ActiveForm::begin(['id'=>'input-data-klaim']); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="bynce_pasien_kode">No. Rekam Medis</label>
                            <input type="text" class="form-control" readonly value="<?= $kodePasien ?>" />

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="bynce_pasien_kode">No. Pendaftaran</label>
                            <input type="text" class="form-control" readonly value="<?= $kodeRegistrasi ?>" />

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="bynce_pasien_kode">Nama Pasien</label>
                            <input type="text" class="form-control" readonly value="<?= $namaPasien ?>" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="bynce_pasien_kode">Tanggal Daftar</label>
                            <input type="text" class="form-control" readonly value="<?= $tglDaftar ?>" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="bynce_pasien_kode">Kode Klaim</label>
                            <?php echo $form->field($model, 'pdk_kode_klaim')->textInput()->label(false); ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="search-rm">Status Klaim</label>                            
                            <?= Html::dropDownList('pdk_status_klaim', $model,['0'=>' Belum Diklaim', '1'=>'Sudah Diklaim', '2'=>'Klaim Pending'], [ 'class'=>'form-control']); ?>
                        </div>
                    </div>                    
                    <div class="col-md-12">
                        <div class="form-group" style="margin-top:25px;">
                            <button type="submit" class="btn btn-block btn-flat btn-sm btn-success btn-submit" title="klik untuk simpan data Klaim"><i class="fa fa-plus"></i> Simpan</button>
                        </div>
                    </div>
                                                            
                </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm btn-flat" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
        </div>
    </div>
</div>