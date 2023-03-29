<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\SdmMAgama */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jenis-laporan-form box box-primary">
    <?php $form = ActiveForm::begin(['options'=>['target'=>'_blank']]); ?>
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model,'jenis_laporan')->widget(Select2::className(),[
                    'data' =>  ArrayHelper::map($jenis_laporan,'jl_id','jl_nama'),
                    'options' => ['placeholder' => 'Pilih Jenis Laporan ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Jenis Laporan');
                ?>
            </div>
            <div class="col-md-4">
                <label>Tahun</label>
                <?php echo $form->field($model, 'tahun_laporan')->textInput()->label(false); ?>
            </div>            
        </div>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('Ekspor Laporan', ['class' => 'btn btn-success btn-flat']) ?>
            
    </div>
    <?php ActiveForm::end(); ?>
</div>
