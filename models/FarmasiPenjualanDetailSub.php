<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "farmasi_penjualan_detail_sub".
 *
 * @property int $id
 * @property int $pens_pend_id
 * @property int $pens_bar_id
 * @property string|null $pens_satuan
 * @property int $pens_jumlah
 * @property int|null $pens_stok
 * @property int $pens_harga_satuan
 * @property int $pens_harga_jual
 * @property int $pens_subtotal
 * @property string $pens_created_at
 * @property int|null $pens_created_by
 * @property string|null $pens_updated_at
 * @property int|null $pens_updated_by
 * @property string|null $pens_deleted_at
 * @property int|null $pens_deleted_by
 * @property string|null $pens_keterangan
 * @property int|null $pens_is_fornas
 * @property string|null $pens_exp_date
 * @property int|null $pens_retur
 * @property int|null $pens_jumlah_jual
 * @property int|null $pens_biaya_layanan
 */
class FarmasiPenjualanDetailSub extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'farmasi_penjualan_detail_sub';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pens_pend_id', 'pens_bar_id', 'pens_jumlah', 'pens_harga_satuan', 'pens_harga_jual', 'pens_subtotal'], 'required'],
            [['pens_pend_id', 'pens_bar_id', 'pens_jumlah', 'pens_stok', 'pens_harga_satuan', 'pens_harga_jual', 'pens_subtotal', 'pens_created_by', 'pens_updated_by', 'pens_deleted_by', 'pens_is_fornas', 'pens_retur', 'pens_jumlah_jual', 'pens_biaya_layanan'], 'integer'],
            [['pens_created_at', 'pens_updated_at', 'pens_deleted_at', 'pens_exp_date'], 'safe'],
            [['pens_keterangan'], 'string'],
            [['pens_satuan'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pens_pend_id' => 'Pens Pend ID',
            'pens_bar_id' => 'Pens Bar ID',
            'pens_satuan' => 'Pens Satuan',
            'pens_jumlah' => 'Pens Jumlah',
            'pens_stok' => 'Pens Stok',
            'pens_harga_satuan' => 'Pens Harga Satuan',
            'pens_harga_jual' => 'Pens Harga Jual',
            'pens_subtotal' => 'Pens Subtotal',
            'pens_created_at' => 'Pens Created At',
            'pens_created_by' => 'Pens Created By',
            'pens_updated_at' => 'Pens Updated At',
            'pens_updated_by' => 'Pens Updated By',
            'pens_deleted_at' => 'Pens Deleted At',
            'pens_deleted_by' => 'Pens Deleted By',
            'pens_keterangan' => 'Pens Keterangan',
            'pens_is_fornas' => 'Pens Is Fornas',
            'pens_exp_date' => 'Pens Exp Date',
            'pens_retur' => 'Pens Retur',
            'pens_jumlah_jual' => 'Pens Jumlah Jual',
            'pens_biaya_layanan' => 'Pens Biaya Layanan',
        ];
    }

    /**
     * {@inheritdoc}
     * @return FarmasiPenjualanDetailSubQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FarmasiPenjualanDetailSubQuery(get_called_class());
    }
    function getBarang()
    {
        return $this->hasOne(FarmasiMBarang::className(),['bar_id'=>'pens_bar_id']);
    }
}