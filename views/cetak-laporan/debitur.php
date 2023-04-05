<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\SdmMAgama */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="card-body">
    <div class="alert alert-default  alert-dismissible">
        <div class="jenis-laporan-form box box-primary">
            <h3 class="text-center ">LAPORAN DEBITUR</h3>
            <?php $form = ActiveForm::begin([
                'action' => ['cetak-laporan/cetak-laporan-debitur'],
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
                    <label>Layanan</label>
                    <?=  Select2::widget([
                            'name' => 'ruangan',
                            'data' =>  ['1' => 'INSTALASI GAWAT DARURAT','2'=>'INSTALASI RAWAT JALAN','3'=>'INSTALASI RAWAT INAP'],
                            'options' => ['placeholder' => 'Pilih Layanan ...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]);?>
                </div>
                <div class="col-md-4">
                    <label>Debitur</label>
                    <?=  Select2::widget([
                            'name' => 'debitur',
                            'data' => ArrayHelper::map(\app\models\PendaftaranMDebiturDetail::find()->all(), 'pmdd_kode', 'pmdd_nama'),
                            'options' => ['placeholder' => 'Pilih Debitur...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]);?>
                </div>
            </div>
            <div class="box-footer" style="margin-top: 10px;">
                <?= Html::submitButton('Cetak', ['class' => 'btn btn-success btn-flat']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>