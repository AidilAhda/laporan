<?php
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SdmMAgama */

$this->title = 'Ekspor Laporan EMR';
$this->params['breadcrumbs'][] = ['label' => 'Laporan EMR', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="laporan-emr-index">

    <?= $this->render('_form', [
        'model' => $model,
        'jenis_laporan' => $jenis_laporan
    ]) ?>

</div>
