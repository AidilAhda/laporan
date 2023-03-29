<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ebs_surat_pernyataan".
 *
 * @property int $snyt_id
 * @property string $snyt_pasien_kode PK Pasien Kode
 * @property string $snyt_reg_kode PK Registrasi
 * @property string $snyt_tanggal
 * @property string $snyt_nama_pasien
 * @property float $snyt_jumlah_pembayaran
 * @property string $snyt_nama_penjamin
 * @property string $snyt_noidentitas_penjamin
 * @property string $snyt_nohp_penjamin
 * @property string $snyt_alamat_penjamin
 * @property string $snyt_hubungan_penjamin
 * @property string $snyt_jaminan
 * @property string $snyt_tgl_jatuhtempo
 * @property string|null $snyt_keterangan
 * @property int $snyt_status 0 => batal, 1 => menunggu jaminan, 2=>selesai
 * @property string|null $snyt_created_at
 * @property int|null $snyt_created_by
 * @property string|null $snyt_updated_at
 * @property int|null $snyt_updated_by
 * @property string|null $snyt_deleted_at
 * @property int|null $snyt_deleted_by
 */
class EbsSuratPernyataan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ebs_surat_pernyataan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['snyt_pasien_kode', 'snyt_reg_kode', 'snyt_tanggal', 'snyt_nama_pasien', 'snyt_jumlah_pembayaran', 'snyt_nama_penjamin', 'snyt_noidentitas_penjamin', 'snyt_nohp_penjamin', 'snyt_alamat_penjamin', 'snyt_hubungan_penjamin', 'snyt_jaminan', 'snyt_tgl_jatuhtempo', 'snyt_status'], 'required'],
            [['snyt_tanggal', 'snyt_tgl_jatuhtempo', 'snyt_created_at', 'snyt_updated_at', 'snyt_deleted_at'], 'safe'],
            [['snyt_jumlah_pembayaran'], 'number'],
            [['snyt_status', 'snyt_created_by', 'snyt_updated_by', 'snyt_deleted_by'], 'integer'],
            [['snyt_pasien_kode', 'snyt_reg_kode'], 'string', 'max' => 10],
            [['snyt_nama_pasien', 'snyt_nama_penjamin'], 'string', 'max' => 255],
            [['snyt_noidentitas_penjamin', 'snyt_nohp_penjamin'], 'string', 'max' => 20],
            [['snyt_alamat_penjamin', 'snyt_jaminan', 'snyt_keterangan'], 'string', 'max' => 500],
            [['snyt_hubungan_penjamin'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'snyt_id' => 'ID',
            'snyt_pasien_kode' => 'Pasien Kode',
            'snyt_reg_kode' => 'Reg Kode',
            'snyt_tanggal' => 'Tanggal',
            'snyt_nama_pasien' => 'Nama Pasien',
            'snyt_jumlah_pembayaran' => 'Jumlah Pembayaran',
            'snyt_nama_penjamin' => 'Nama Penjamin',
            'snyt_noidentitas_penjamin' => 'Noidentitas Penjamin',
            'snyt_nohp_penjamin' => 'Nohp Penjamin',
            'snyt_alamat_penjamin' => 'Alamat Penjamin',
            'snyt_hubungan_penjamin' => 'Hubungan Penjamin',
            'snyt_jaminan' => 'Jaminan',
            'snyt_tgl_jatuhtempo' => 'Tgl Jatuhtempo',
            'snyt_keterangan' => 'Keterangan',
            'snyt_status' => 'Status',
            'snyt_created_at' => 'Created At',
            'snyt_created_by' => 'Created By',
            'snyt_updated_at' => 'Updated At',
            'snyt_updated_by' => 'Updated By',
            'snyt_deleted_at' => 'Deleted At',
            'snyt_deleted_by' => 'Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return EbsSuratPernyataanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EbsSuratPernyataanQuery(get_called_class());
    }

    public function getDataRiwayat($NoPasien, $NoDaftar)
    {
        
         $Data = EbsSuratPernyataan::find()
        ->andWhere(['snyt_pasien_kode'=>$NoPasien, 'snyt_reg_kode'=>$NoDaftar])
        ->andWhere('snyt_deleted_at is null')->asArray()->all();

        return $Data;
    }
}
