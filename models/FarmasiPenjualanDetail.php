<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "farmasi_penjualan_detail".
 *
 * @property int $pjd_id
 * @property int $pjd_pnj_id FK faramsi_penjualan
 * @property int $pjd_bar_id FK farmasi_m_barang
 * @property int|null $pjd_sat_id
 * @property int $pjd_jumlah
 * @property int $pjd_stok_saat_jual
 * @property int $pjd_harga_satuan
 * @property string|null $pjd_catatan
 * @property int|null $pjd_jumlah_retur
 * @property string|null $pjd_exp_date
 * @property int|null $pjd_subtotal_retur
 * @property int $pjd_subtotal
 * @property string|null $pjd_is_fornas
 * @property string $pjd_created_at
 * @property int|null $pjd_created_by
 * @property string|null $pjd_updated_at
 * @property int|null $pjd_updated_by
 * @property string|null $pjd_deleted_at
 * @property int|null $pjd_deleted_by
 * @property string|null $pjd_signa
 * @property string|null $pjd_keterangan
 */
class FarmasiPenjualanDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'farmasi_penjualan_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pjd_pnj_id', 'pjd_bar_id', 'pjd_jumlah', 'pjd_stok_saat_jual', 'pjd_harga_satuan', 'pjd_subtotal'], 'required'],
            [['pjd_pnj_id', 'pjd_bar_id', 'pjd_sat_id', 'pjd_jumlah', 'pjd_stok_saat_jual', 'pjd_harga_satuan', 'pjd_jumlah_retur', 'pjd_subtotal_retur', 'pjd_subtotal', 'pjd_created_by', 'pjd_updated_by', 'pjd_deleted_by'], 'integer'],
            [['pjd_catatan', 'pjd_is_fornas', 'pjd_keterangan'], 'string'],
            [['pjd_exp_date', 'pjd_created_at', 'pjd_updated_at', 'pjd_deleted_at'], 'safe'],
            [['pjd_signa'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pjd_id' => 'Pjd ID',
            'pjd_pnj_id' => 'Pjd Pnj ID',
            'pjd_bar_id' => 'Pjd Bar ID',
            'pjd_sat_id' => 'Pjd Sat ID',
            'pjd_jumlah' => 'Pjd Jumlah',
            'pjd_stok_saat_jual' => 'Pjd Stok Saat Jual',
            'pjd_harga_satuan' => 'Pjd Harga Satuan',
            'pjd_catatan' => 'Pjd Catatan',
            'pjd_jumlah_retur' => 'Pjd Jumlah Retur',
            'pjd_exp_date' => 'Pjd Exp Date',
            'pjd_subtotal_retur' => 'Pjd Subtotal Retur',
            'pjd_subtotal' => 'Pjd Subtotal',
            'pjd_is_fornas' => 'Pjd Is Fornas',
            'pjd_created_at' => 'Pjd Created At',
            'pjd_created_by' => 'Pjd Created By',
            'pjd_updated_at' => 'Pjd Updated At',
            'pjd_updated_by' => 'Pjd Updated By',
            'pjd_deleted_at' => 'Pjd Deleted At',
            'pjd_deleted_by' => 'Pjd Deleted By',
            'pjd_signa' => 'Pjd Signa',
            'pjd_keterangan' => 'Pjd Keterangan',
        ];
    }

    /**
     * {@inheritdoc}
     * @return FarmasiPenjualanDetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FarmasiPenjualanDetailQuery(get_called_class());
    }

    function getPenjualan()
    {
        return $this->hasOne(FarmasiPenjualan::className(),['pnj_id'=>'pjd_pnj_id']);
    }

    function getBarang()
    {
        return $this->hasOne(FarmasiMBarang::className(),['bar_id'=>'pjd_bar_id']);
    }

}
