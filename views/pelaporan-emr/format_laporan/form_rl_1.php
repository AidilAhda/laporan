<?php
use yii\helpers\Url;

$logo1 = Url::base()."/images/dinkes.png";
$logo2 = Url::base()."/images/kampar.png";

?>

<table class="table no-padding" width="100%">
    <tr>
        <td width="10%">
            <img src="<?= $logo2 ?>" width="60px">
        </td>
        <td style="font-size:15px" width="80%">
            <center><b><?= Yii::$app->params['header']['nama_dinas'] ?></b><br/>
               <?= Yii::$app->params['header']['nama_rumah_sakit'] ?><br/>
               <?= Yii::$app->params['header']['alamat_rumah_sakit'] ?><br/>
               <?= Yii::$app->params['header']['kontak_rumah_sakit'] ?></center>
        </td>
        <td width="10%">
           <img src="<?= $logo1 ?>" width="60px">
        </td>
    </tr>
</table>
