<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ebs_naik_kelas".
 *
 * @property int $nkls_id
 * @property string $nkls_pasien_kode
 * @property string $nkls_reg_kode
 * @property string $nkls_kelas_awal Kelas awal pasien
 * @property string $nkls_kelas_akhir Kelas akhir pasien
 * @property int|null $nkls_kategori_waktu 1 = kurang dari 12 jam  2 = antara 12 jam sampai 24 jam  3 = selama 24 jam sampai 36 jam  4 = lebih dari 36 jam
 * @property int|null $nkls_persentase_biaya
 * @property float $nkls_paket_jkn total paket hasil grouping jkn
 * @property float $nkls_tanggungan_jkn Paket yang ditanggung JKN
 * @property float $nkls_tanggungan_pasien Paket yang ditanggung Pasien
 * @property string|null $nkls_keterangan
 * @property string|null $nkls_created_at
 * @property int|null $nkls_created_by
 * @property string|null $nkls_updated_at
 * @property int|null $nkls_updated_by
 * @property string|null $nkls_deleted_at
 * @property int|null $nkls_deleted_by
 */
class EbsNaikKelas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ebs_naik_kelas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nkls_pasien_kode', 'nkls_reg_kode', 'nkls_kelas_awal', 'nkls_kelas_akhir', 'nkls_paket_jkn'], 'required'],
            [['nkls_kategori_waktu', 'nkls_persentase_biaya', 'nkls_created_by', 'nkls_updated_by', 'nkls_deleted_by'], 'integer'],
            [['nkls_paket_jkn', 'nkls_tanggungan_jkn', 'nkls_tanggungan_pasien'], 'number'],
            [['nkls_created_at', 'nkls_updated_at', 'nkls_deleted_at'], 'safe'],
            [['nkls_pasien_kode', 'nkls_reg_kode'], 'string', 'max' => 10],
            [['nkls_kelas_awal', 'nkls_kelas_akhir'], 'string', 'max' => 3],
            [['nkls_keterangan'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'nkls_id' => 'Nkls ID',
            'nkls_pasien_kode' => 'Nkls Pasien Kode',
            'nkls_reg_kode' => 'Nkls Reg Kode',
            'nkls_kelas_awal' => 'Nkls Kelas Awal',
            'nkls_kelas_akhir' => 'Nkls Kelas Akhir',
            'nkls_kategori_waktu' => 'Nkls Kategori Waktu',
            'nkls_persentase_biaya' => 'Nkls Persentase Biaya',
            'nkls_paket_jkn' => 'Nkls Paket Jkn',
            'nkls_tanggungan_jkn' => 'Nkls Tanggungan Jkn',
            'nkls_tanggungan_pasien' => 'Nkls Tanggungan Pasien',
            'nkls_keterangan' => 'Nkls Keterangan',
            'nkls_created_at' => 'Nkls Created At',
            'nkls_created_by' => 'Nkls Created By',
            'nkls_updated_at' => 'Nkls Updated At',
            'nkls_updated_by' => 'Nkls Updated By',
            'nkls_deleted_at' => 'Nkls Deleted At',
            'nkls_deleted_by' => 'Nkls Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return EbsNaikKelasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EbsNaikKelasQuery(get_called_class());
    }

    public function getDataNaikKelas($NoPasien, $NoDaftar)
    {
        
         $Data = EbsNaikKelas::find()
        ->andWhere(['nkls_pasien_kode'=>$NoPasien, 'nkls_reg_kode'=>$NoDaftar])
        ->andWhere('nkls_deleted_at is null')->asArray()->limit(1)->one();

        return $Data;
    }

}
