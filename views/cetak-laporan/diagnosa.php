<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use \app\models\MedisMIcd10cm;
use \app\models\SdmMUnit;
/* @var $this yii\web\View */
/* @var $model app\models\SdmMAgama */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="card-body">
    <div class="alert alert-default  alert-dismissible">
        <div class="jenis-laporan-form box box-primary">
            <h3 class="text-center ">LAPORAN DIAGNOSA</h3>
            <?php $form = ActiveForm::begin([
                'action' => ['cetak-laporan/cetak-laporan-diagnosa'],
                'method' => 'post',
                'options' => [
                    'target' => '_blank',
                    'autocomplete' => 'off'
                ],
            ]); ?>

            <div class="col-md-3">
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
            <div class="col-md-3">
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
            <div class="col-md-3">
                <label>Ruangan</label>
                <?=  Select2::widget([
                            'name' => 'ruangan',
                            'data' => ArrayHelper::map(SdmMUnit::find()->where('unt_is_rj=1 or unt_is_ri=1')->all(), 'unt_id', 'unt_nama'),
                            'options' => ['placeholder' => 'Select a state ...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]);?>
            </div>
            <div class="col-md-3">
                <label>Diagnosa</label>
                <?=  Select2::widget([
                            'name' => 'state',
                            'data' => ArrayHelper::map(MedisMIcd10cm::find()->limit(2000)->all(), 'icd10_kode', 'icd10_deskripsi'),
                            'options' => ['placeholder' => 'Pilih diagnosa ...','multiple'=>true],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]);?>
            </div>
            <div class="box-footer" style="margin-top: 10px;">
                <?= Html::submitButton('    Cetak ', ['class' => 'btn btn-success btn-flat']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>