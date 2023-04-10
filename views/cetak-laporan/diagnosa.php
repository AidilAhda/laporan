<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use \app\models\MedisMIcd10cm;
use \app\models\SdmMUnit;

use yii\web\JsExpression;
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
            </div>
            <div class="row">
                <div class="col-md-4 ">
                    <label>Diagnosa</label>
                    <?php 
                $url = Url::to(['referensi-medis/icd10-select2']);
        //         echo"<pre>";
        // print_r($url);die();?>

                    <?= Select2::widget([
                        'name' =>'diagnosa1',
                        'id' => 'diagnosis',
                        'options' => ['placeholder' => 'Ketik Kode / Deskripsi ICD 10...','multiple'=> true],
                        'size' => Select2::SMALL,
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 3,
                            'language' => [
                                'errorLoading' => new JsExpression('function () {return "Menunggu hasil...";}'),
                                'inputTooShort' => new JsExpression('function () {return "Minimal 3 karakter...";}'),
                                'searching' => new JsExpression('function() {return "Mencari...";}'),
                            ],
                            'ajax' => [
                                'url' => $url,
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) {
                                    return {
                                        search:params.term
                                    };
                                }')
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('function(data) {
                                if(data.loading){
                                    return data.text;
                                }else{
                                    if(data.status){
                                        return data.text_full;
                                    }else{
                                        fmsg.e(data.text);
                                    }
                                }
                            }'),
                            'templateSelection' => new JsExpression('function (data) { return data.text }'),
                        ],
                        'pluginEvents' => [
                            "select2:select" => new JsExpression('function(obj) {
                                console.log(obj.params.data);
                                
                            }'),
                        ]
                    ]);?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="box-footer" style="margin-top: 10px;">
                        <?= Html::submitButton('Cetak ', ['class' => 'btn btn-success btn-flat']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>