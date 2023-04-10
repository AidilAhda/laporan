<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>

<!-- LAPORAN PEMAKAIAN OBAT PERDEPO -->
<div class="card-body">
    <div class="alert alert-default  alert-dismissible">
        <div class="jenis-laporan-form box box-success">
            <h3 class="text-center">REKAP PEMAKAIAN OBAT </h3>
            <?php $form = ActiveForm::begin([
                'action' => ['cetak-laporan/laporan-farmasi-excel'],
                'method' => 'post',
                'options' => [
                    'target' => '_blank',
                    'autocomplete' => 'off'
                ],
            ]); ?>

            <div class="col-md-4">
                <label>Tanggal Mulai</label>
                <?= DatePicker::widget([
                            'name' => 'tanggal_mulai',
                            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                            'value' => date('d-M-Y'),
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-M-yyyy'
                            ]
                        ]);
                        ?>
            </div>
            <div class="col-md-4">
                <label>Tanggal Selesai</label>
                <?= DatePicker::widget([
                            'name' => 'tanggal_selesai',
                            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                            'value' => date('d-M-Y'),
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-M-yyyy'
                            ]
                        ]);
                        ?>
            </div>
            <div class="col-md-4">
                <label>Pilih Depo</label>
                <?=  Select2::widget([
                            'name' => 'farmasi_depo',
                            'data' => ArrayHelper::map(\app\models\SdmMUnit::find()->where(' unt_id = 48 or unt_id = 49 or unt_id =50')->all(), 'unt_id', 'unt_nama'),
                            'options' => ['placeholder' => 'Select a state ...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]);?>
            </div>
            <div class="box-footer" style="margin-top: 10px;">
                <?= Html::submitButton('Cetak Excel', ['class' => 'btn btn-success btn-flat']) ?>
            </div>


            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>
<div class="help-block"></div>

<!-- LAPORAN PEMAKAIAN OBAT PERDEPO -->
<div class="card-body">
    <div class="alert alert-default  alert-dismissible">
        <div class="jenis-laporan-form box box-success">
            <h3 class="text-center">LAPORAN PEMAKAIAN OBAT OLEH DEPO</h3>
            <?php $form = ActiveForm::begin([
                'action' => ['cetak-laporan/cetak-laporan-farmasi-depo'],
                'method' => 'post',
                'options' => [
                    'target' => '_blank',
                    'autocomplete' => 'off'
                ],
            ]); ?>

            <div class="col-md-4">
                <label>Tanggal Mulai</label>
                <?= DatePicker::widget([
                            'name' => 'tanggal_mulai',
                            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                            'value' => date('d-M-Y'),
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-M-yyyy'
                            ]
                        ]);
                        ?>
            </div>
            <div class="col-md-4">
                <label>Tanggal Selesai</label>
                <?= DatePicker::widget([
                            'name' => 'tanggal_selesai',
                            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                            'value' => date('d-M-Y'),
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-M-yyyy'
                            ]
                        ]);
                        ?>
            </div>
            <div class="col-md-4">
                <label>Pilih Depo</label>
                <?=  Select2::widget([
                            'name' => 'farmasi_depo',
                            'data' => ArrayHelper::map(\app\models\SdmMUnit::find()->where(' unt_id = 48 or unt_id = 49 or unt_id =50')->all(), 'unt_id', 'unt_nama'),
                            'options' => ['placeholder' => 'Select a state ...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]);?>
            </div>
            <div class="box-footer" style="margin-top: 10px;">
                <?= Html::submitButton('Cetak PDF', ['class' => 'btn btn-danger btn-flat']) ?>
            </div>


            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>
<div class="help-block"></div>

<!-- LAPORAN PEMAKAIAN OBAT PERDOKTER -->
<div class="card-body">
    <div class="alert alert-default  alert-dismissible">
        <div class="jenis-laporan-form box box-success">
            <h3 class="text-center">LAPORAN PEMAKAIAN OBAT OLEH DOKTER</h3>
            <?php $form = ActiveForm::begin([
                'action' => ['cetak-laporan/cetak-laporan-farmasi-dokter'],
                'method' => 'post',
                'options' => [
                    'target' => '_blank',
                    'autocomplete' => 'off'
                ],
            ]); ?>

            <div class="col-md-4">
                <label>Tanggal Mulai</label>
                <?= DatePicker::widget([
                            'name' => 'tanggal_mulai',
                            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                            'value' => date('d-M-Y'),
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-M-yyyy'
                            ]
                        ]);
                        ?>
            </div>
            <div class="col-md-4">
                <label>Tanggal Selesai</label>
                <?= DatePicker::widget([
                            'name' => 'tanggal_selesai',
                            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                            'value' => date('d-M-Y'),
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-M-yyyy'
                            ]
                        ]);
                        ?>
            </div>
            <div class="col-md-4">
                <label>Pilih Dokter</label>
                <?=  Select2::widget([
                            'name' => 'farmasi_dokter',
                            'data' => ArrayHelper::map(\app\models\SdmMPegawai::find()->where(' pgw_rpn_id = 1')->all(), 'pgw_id',function($model){
                                return $model->pgw_gelar_depan.' '.$model->pgw_nama.' '.$model->pgw_gelar_belakang;
                            }),
                            'options' => ['placeholder' => 'Select a state ...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]);?>
            </div>
            <div class="box-footer" style="margin-top: 10px;">
                <?= Html::submitButton('Cetak PDF', ['class' => 'btn btn-danger btn-flat']) ?>
            </div>


            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>
<div class="help-block"></div>

<!-- LAPORAN PEMAKAIAN OBAT PERPASIEN -->
<div class="card-body">
    <div class="alert alert-default  alert-dismissible">
        <div class="jenis-laporan-form box box-success">
            <h3 class="text-center">LAPORAN PEMAKAIAN OBAT OLEH PASIEN</h3>
            <?php $form = ActiveForm::begin([
                'action' => ['cetak-laporan/cetak-laporan-farmasi-pasien'],
                'method' => 'post',
                'options' => [
                    'target' => '_blank',
                    'autocomplete' => 'off'
                ],
            ]); ?>

            <div class="col-md-4">
                <label>Tanggal Mulai</label>
                <?= DatePicker::widget([
                            'name' => 'tanggal_mulai',
                            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                            'value' => date('d-M-Y'),
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-M-yyyy'
                            ]
                        ]);
                        ?>
            </div>
            <div class="col-md-4">
                <label>Tanggal Selesai</label>
                <?= DatePicker::widget([
                            'name' => 'tanggal_selesai',
                            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                            'value' => date('d-M-Y'),
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-M-yyyy'
                            ]
                        ]);
                        ?>
            </div>
            <div class="col-md-4">
                <label class="control-label" for="farmasi_pasien">Cari Nama / NO.MR / NO.REG Pasien</label>
                <input type="text" id="farmasi_pasien" class="form-control" name="FarmasiPasien"
                    placeholder="Nama / NO.MR / NO.REG Pasien..." autofocus="autofocus">
            </div>
            <div class="box-footer" style="margin-top: 10px;">
                <?= Html::submitButton('Cetak PDF', ['class' => 'btn btn-danger btn-flat']) ?>
            </div>


            <?php ActiveForm::end(); ?>
        </div>