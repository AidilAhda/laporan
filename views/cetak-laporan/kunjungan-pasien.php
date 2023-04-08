<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use \app\models\SdmMUnit;
use \app\models\PendaftaranLayanan;
/* @var $this yii\web\View */
/* @var $model app\models\SdmMAgama */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card-body">
    <div class="alert alert-default  alert-dismissible">
        <div class="jenis-laporan-form box box-success">
            <h3 class="text-center">LAPORAN KUNJUNGAN PASIEN
            </h3>
            <?php $form = ActiveForm::begin([
                'action' => ['cetak-laporan/cetak-laporan-kunjungan'],
                'method' => 'post',
                'options' => [
                    'target' => '_blank',
                    'autocomplete' => 'off'
                ],
            ]); ?>
            <div class="row">
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
                    <label>Installasi</label>
                    <?=  Select2::widget([
                            'name' => 'layanan',
                            'data' => ['1' => 'INSTALASI GAWAT DARURAT','2'=>'INSTALASI RAWAT JALAN','3'=>'INSTALASI RAWAT INAP'],
                            'options' => ['placeholder' => 'Pilih Installasi ...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]);?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="excel">
                        <label class="form-check-label" for="flexSwitchCheckDefault">EXPORT EXCEL?</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="box-footer" style="margin-top: 10px;">
                        <?= Html::submitButton('Cetak', ['class' => 'btn btn-success btn-flat']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>