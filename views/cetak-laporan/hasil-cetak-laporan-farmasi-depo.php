<?php
use app\models\FarmasiMBarang;
use app\models\FarmasiPenjualanDetailSub;

?>

<h3 align="center">LAPORAN PEMAKAIAN OBAT <?= $ruangan ? $ruangan['unt_nama'] : ' PEMAKAIAN OBAT' ?> <br>
    Tanggal : <?= date('d-M-Y', strtotime($mulai)) ?> Sampai <?= date('d-M-Y', strtotime($selesai)) ?>
    <br>
</h3>
<table width="100%" border="1" cellspacing="0" style="text-align: center;vertical-align: middle;">
    <tr>
        <th>NO</th>
        <th>DEPO</th>
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
            $no = 1; foreach ($model as $sd){
           
                $total_sub += $sd['total'];
            
        ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $sd['depo']? $sd['depo']['unt_nama'] : ''?></td>
        <td><?= $sd['detail']['subdetail'] ? $sd['detail']['subdetail']['barang']['bar_nama']: ''; ?></td>
        <td><?= $sd?$sd['pnj_tanggal_resep'] : '' ?></td>
        <td><?= $sd['poli']? $sd['poli']['unt_nama'] : ''?></td>
        <td><?= $sd?$sd['jumlah'] : ''?></td>
        <td><?= $sd?$sd['pens_satuan'] : ''?></td>
        <td><?=  $sd?"Rp " .number_format($sd['pens_harga_jual'],2,',','.') : '' ?>
        <td><?=  $sd?"Rp " .number_format($sd['biaya_layanan'],2,',','.') : '' ?>
        <td><?=  $sd?"Rp " .number_format($sd['total'],2,',','.') : '' ?>
        </td>
        </td>
    </tr>
    <?php } ?>
    <tr>
        <td colspan="9" align=center>TOTAL KESELURUHAN</td>
        <td><?="Rp " .number_format($total_sub,2,',','.') ?></td>
    </tr>
</table>