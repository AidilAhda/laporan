<?php

use yii\jui\DatePicker;
use \yii\helpers\Html;
use kartik\select2\Select2;
use app\models\SdmMUnit;
?>
<div class="col-md-4">
  <div class="box box-success">
    <div class="box-header with-border">
		<div class="row">
		  <div class="col-md-8">
			<input type="text" class="form-control" id="CariNamaMonitoring" placeholder="Masukkan Kata Yang Dicari" onkeyup="filter()">
		  </div>
		  <div class="col-md-2">
			<button type="button" id="Data" class="btn ink-reaction btn-success btn-raised" onclick="filter()" data-toggle="tooltip" data-placement="bottom" data-original-title="Cari data" style="cursor: pointer"><i class="fa fa-fw fa-search"></i>Cari </button>
		  </div>
		</div>
    </div>
  </div>
</div>
<div class="col-md-8">
  <div class="box box-success">
    <div class="box-header with-border">
		<div class="row">
			<div class="col-md-3">
			  <header class="text-primary">Tanggal Dari</header>
			  <?php
				echo DatePicker::widget([
				  'name'  => 'TanggalMonitoring',
				  'value'  => date('d-m-Y', strtotime($tgl_mulai)),
				  'language' => 'id',
				  'dateFormat' => 'dd-MM-yyyy',
				  'options'=>['class'=>'form-control input-sm'],
					'clientOptions'=>[
						'changeMonth'=>true,
						'changeYear'=>true,
					]
				]);
			  ?>
			</div>
            <div class="col-md-3">
                <header class="text-primary">Tanggal Sampai</header>
                <?php
                echo DatePicker::widget([
                    'name'  => 'TanggalMonitoring_selesai',
                    'value'  => date('d-m-Y', strtotime($tgl_selesai)),
                    'language' => 'id',
                    'dateFormat' => 'dd-MM-yyyy',
                    'options'=>['class'=>'form-control input-sm'],
                    'clientOptions'=>[
                        'changeMonth'=>true,
                        'changeYear'=>true,
                    ]
                ]);
                ?>
            </div>
			<div class="col-md-3">
			  <header class="text-primary">Debitur </header>
			  <?= Html::dropDownList('DebiturMonitoring', 
			  							$Debitur,[
											'S'=>'-SEMUA-', 
											'1001' =>'UMUM',
											'1101'=>'BPJS Kesehatan', 
											'1102'=>'COVID-19', 
											'1103'=>'BPJS Ketenagakerjaan',
											'1201' =>'JAMKESDA',
											'1202'=>'JAMPERSAL',
											'1301' =>'KARYAWAN RS',
											'1401' => 'INHEALTH (ASKES KOMERSIAL)',
											'1501'=>'JASA RAHARJA',
											'1601'=>'BPJS Ketenagakerjaan'	
										], 
									['id'=>'DebiturMonitoring', 'class'=>'form-control']); ?>
			</div>
			<div class="col-md-3">
			  <header class="text-primary">Layanan </header>
			  <?= Html::dropDownList('LayananMonitoring', $layanan,['0'=>'-SEMUA-', '1'=>'IGD', '2'=>'RAWAT JALAN', '3'=>'RAWAT INAP', '4'=>'PENUNJANG'], ['id'=>'LayananMonitoring', 'class'=>'form-control']); ?>
			</div>
            <br>
            <div class="col-md-3">
                <label>Unit</label>
                <?= Select2::widget([
                    'name' => 'unitMonitoring',
                    'data' => yii\helpers\ArrayHelper::map(SdmMUnit::find()->where(['unt_aktif' => 1])->all(), 'unt_id', 'unt_nama'),
                    'options' => [
                        'placeholder' => 'Select ...',
                        'id' => 'unitMonitoring'
                    ],
                ]);
                ?>
            </div>
			<div class="col-md-3">
			  <button type="button" class="btn btn-success btn-show-data" data-toggle="tooltip" data-placement="bottom" data-original-title="Tampilkan Data" style="cursor: pointer; margin-top:10px;"><i class="fa fa-fw fa-user-md"></i></button>
			</div>
		</div>
    </div>
  </div>
</div>

    


    