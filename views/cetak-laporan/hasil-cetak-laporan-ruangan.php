<h3 align="center">RUANGAN <?= $ruangan['unt_nama'] ?></h3>
Tanggal : <?= date('d-M-Y', strtotime($mulai)) ?> Sampai <?= date('d-M-Y', strtotime($selesai)) ?>
<br>
<table width="100%" border="1" cellspacing="0">
    <tr>
        <th>No</th>
        <th>No Sep</th>
        <th>No RM</th>
        <th>Nama Pasien</th>
        <th>Ruangan</th>
        <th>Nama Dpjp</th>
        <th>Tgl Masuk</th>
        <th>Tgl Keluar</th>
    </tr>

    <?php  $no = 1; foreach ($model as $val){
            $dpjp = \app\models\PjpRi::find()->joinWith(['pegawai'])->where(['pjpri_reg_kode' => $val['pl_reg_kode'], 'pjpri_status' => 1])->andWhere('pjpri_deleted_at is null')->one();
        ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $val['registrasi']['reg_no_sep'] ?></td>
        <td><?= $val['registrasi']['reg_pasien_kode'] ?></td>
        <td><?= $val['registrasi']['pasien']['ps_nama'].'<BR> ('.$val['registrasi']['pasien']['ps_no_identitas'].')' ?>
        </td>
        <td><?= $val['pl_unit_kode'] ? $val['unit']['unt_nama'] : '' ?></td>
        <td><?= $dpjp ? ($dpjp->pegawai ? $dpjp->pegawai->pgw_nama : ''): ''  ?></td>
        <td><?= $val['pl_tgl_masuk'] ? date('d-M-Y H:i:s', strtotime($val['pl_tgl_masuk'])) : ''  ?></td>
        <td><?= $val['registrasi']['reg_tgl_keluar'] ? date('d-M-Y H:i:s', strtotime($val['registrasi']['reg_tgl_keluar'])) : ''  ?>
        </td>
    </tr>
    <?php } ?>
</table>