<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "farmasi_m_barang".
 *
 * @property int $bar_id
 * @property string $bar_nama
 * @property string|null $bar_nama_generik
 * @property int $bar_sat_id
 * @property int|null $bar_gol_id
 * @property int|null $bar_kel_id
 * @property int|null $bar_jen_id
 * @property int|null $bar_kla_id
 * @property int|null $bar_sub_id
 * @property string|null $bar_retriksi
 * @property string|null $bar_deskripsi
 * @property int|null $bar_stok_mak
 * @property int|null $bar_stok_min
 * @property int|null $bar_harga_kemasan
 * @property int|null $bar_isi_kemasan
 * @property int|null $bar_harga_satuan_terakhir
 * @property int $bar_harga_satuan_tertinggi
 * @property string $bar_created_at
 * @property int|null $bar_created_by
 * @property string|null $bar_updated_at
 * @property int|null $bar_updated_by
 * @property string|null $bar_deleted_at
 * @property int|null $bar_deleted_by
 * @property string|null $bar_kekuatan
 * @property int|null $bar_peresepan_maksimal
 * @property string|null $bar_kandungan
 */
class FarmasiMBarang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'farmasi_m_barang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bar_nama', 'bar_sat_id', 'bar_harga_satuan_tertinggi'], 'required'],
            [['bar_sat_id', 'bar_gol_id', 'bar_kel_id', 'bar_jen_id', 'bar_kla_id', 'bar_sub_id', 'bar_stok_mak', 'bar_stok_min', 'bar_harga_kemasan', 'bar_isi_kemasan', 'bar_harga_satuan_terakhir', 'bar_harga_satuan_tertinggi', 'bar_created_by', 'bar_updated_by', 'bar_deleted_by', 'bar_peresepan_maksimal'], 'integer'],
            [['bar_retriksi', 'bar_deskripsi'], 'string'],
            [['bar_created_at', 'bar_updated_at', 'bar_deleted_at'], 'safe'],
            [['bar_nama', 'bar_nama_generik'], 'string', 'max' => 100],
            [['bar_kekuatan', 'bar_kandungan'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bar_id' => 'Bar ID',
            'bar_nama' => 'Bar Nama',
            'bar_nama_generik' => 'Bar Nama Generik',
            'bar_sat_id' => 'Bar Sat ID',
            'bar_gol_id' => 'Bar Gol ID',
            'bar_kel_id' => 'Bar Kel ID',
            'bar_jen_id' => 'Bar Jen ID',
            'bar_kla_id' => 'Bar Kla ID',
            'bar_sub_id' => 'Bar Sub ID',
            'bar_retriksi' => 'Bar Retriksi',
            'bar_deskripsi' => 'Bar Deskripsi',
            'bar_stok_mak' => 'Bar Stok Mak',
            'bar_stok_min' => 'Bar Stok Min',
            'bar_harga_kemasan' => 'Bar Harga Kemasan',
            'bar_isi_kemasan' => 'Bar Isi Kemasan',
            'bar_harga_satuan_terakhir' => 'Bar Harga Satuan Terakhir',
            'bar_harga_satuan_tertinggi' => 'Bar Harga Satuan Tertinggi',
            'bar_created_at' => 'Bar Created At',
            'bar_created_by' => 'Bar Created By',
            'bar_updated_at' => 'Bar Updated At',
            'bar_updated_by' => 'Bar Updated By',
            'bar_deleted_at' => 'Bar Deleted At',
            'bar_deleted_by' => 'Bar Deleted By',
            'bar_kekuatan' => 'Bar Kekuatan',
            'bar_peresepan_maksimal' => 'Bar Peresepan Maksimal',
            'bar_kandungan' => 'Bar Kandungan',
        ];
    }

    /**
     * {@inheritdoc}
     * @return FarmasiMBarangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FarmasiMBarangQuery(get_called_class());
    }
}
