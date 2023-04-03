<?php
use app\models\FarmasiMBarang;
use app\models\FarmasiPenjualanDetailSub;

?>

<h3 align="center">LAPORAN PEMAKAIAN OBAT <?= $pasienf. '' ?> <br>
    Tanggal : <?= date('d-M-Y', strtotime($mulai)) ?> Sampai <?= date('d-M-Y', strtotime($selesai)) ?>
    <br>
</h3>
<table width="100%" border="1" cellspacing="0" style="text-align: center;vertical-align: middle;">
    <tr>
        <th>NO</th>
        <th>NAMA PASIEN</th>
        <th>NAMA OBAT</th>
        <th>TANGGAL RESEP</th>
        <th>RUANGAN</th>
        <th>JUMLAH</th>
        <th>SATUAN</th>
        <th>HARGA JUAL</th>
        <th>BIAYA LAYANAN</th>
        <th>SUBTOTAL</th>

    </tr>
    <?php $total_sub = 0;  
            $no = 1; foreach ($model as $val){
            $subDetail = FarmasiPenjualanDetailSub::find()->where(['pens_pend_id'=>$val['detail']['pjd_id']])->all();
            foreach ($subDetail as $sd){
            $barang = FarmasiMBarang::find()->where(['bar_id'=>$sd['pens_bar_id']])->one();
            // echo "<pre>";
            // print_r($subDetail);die();
                $total_sub += $sd['pens_subtotal'];
            }
        ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $val['pnj_nama_pasien']?></td>
        <td><?= $barang?$barang['bar_nama'] : '' ?></td>
        <td><?= $val?$val['pnj_tanggal_resep'] : '' ?></td>
        <td><?= $val['poli']? $val['poli']['unt_nama'] : ''?></td>
        <td><?= $sd?$sd['pens_jumlah'] : ''?></td>
        <td><?= $sd?$sd['pens_satuan'] : ''?></td>
        <td><?=  $sd?"Rp " .number_format($sd['pens_harga_jual'],2,',','.') : '' ?>
        <td><?=  $sd?"Rp " .number_format($sd['pens_biaya_layanan'],2,',','.') : '' ?>
        <td><?=  $sd?"Rp " .number_format($sd['pens_subtotal'],2,',','.') : '' ?>
        </td>
        </td>
    </tr>
    <?php } ?>
    <tr>
        <td colspan="9" align=center>TOTAL KESELURUHAN</td>
        <td><?="Rp " .number_format($total_sub,2,',','.') ?></td>
    </tr>
</table>