<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use \app\models\SdmMUnit;
/* @var $this yii\web\View */
/* @var $model app\models\SdmMAgama */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card-body">
    <div class="alert alert-default  alert-dismissible">
        <div class="jenis-laporan-form box box-success">
            <h3 class="text-center">LAPORAN KUNJUNGAN PASIEN</h3>
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
                    <label>Ruangan</label>
                    <?=  Select2::widget([
                            'name' => 'ruangan',
                            'data' => ArrayHelper::map(SdmMUnit::find()->where(' unt_id = 85 or unt_id = 67 or unt_id =104 or unt_id =83')->all(), 'unt_id', 'unt_nama'),
                            'options' => ['placeholder' => 'Select a state ...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]);?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="rekap">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Rekap?</label>
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