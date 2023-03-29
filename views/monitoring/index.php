<?php


use app\assets\AppAsset;

use yii\web\View;
use yii\helpers\Url;
use yii\jui\DatePicker;
use \yii\helpers\Html;


$this->registerJs($this->render('index.js'), View::POS_END);
AppAsset::register($this);

?>

<section class="content-header">
  <h1>
    ..: Data Pasien RSUD Bangkinang :..   
  </h1>
  <ol class="breadcrumb">
<!--     <li>
      <span id="dayname">Day</span>,
      <span id="daynum">00</span>
      <span id="month">Month</span>
      <span id="year">Year</span>
    </li>
    <li class="active">
      <span id="hour">00</span>:
      <span id="minutes">00</span>:
      <span id="seconds">00</span>
      <span id="period">AM</span>
    </li> -->
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <?php echo $this->render('index_cari',[
        'tgl_mulai' =>$tgl_mulai,
        'tgl_selesai' => $tgl_selesai,
        'Debitur'=>$Debitur,
        'layanan'=>$layanan,
          'unit' => $unit
      ]); ?>
      <!-- /.box -->
    </div>
    <div class="col-md-12">
      <?php echo $this->render('index_list',[
        'data'=>$data              
      ]); ?>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->
