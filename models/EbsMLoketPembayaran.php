<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ebs_m_loket_pembayaran".
 *
 * @property int $lob_id Loket Bayar Id
 * @property string $lob_nama Nama Loket
 * @property int $lob_aktif 1 => aktif 0 => Tidak Aktif	
 * @property string $lob_keterangan Keterangan Loket Bayar
 * @property string|null $lob_created_at
 * @property int|null $lob_created_by
 * @property string|null $lob_updated_at
 * @property int|null $lob_updated_by
 * @property string|null $lob_deleted_at
 * @property int|null $lob_deleted_by
 */
class EbsMLoketPembayaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ebs_m_loket_pembayaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lob_nama', 'lob_keterangan'], 'required'],
            [['lob_aktif', 'lob_created_by', 'lob_updated_by', 'lob_deleted_by'], 'integer'],
            [['lob_keterangan'], 'string'],
            [['lob_created_at', 'lob_updated_at', 'lob_deleted_at'], 'safe'],
            [['lob_nama'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lob_id' => 'Lob ID',
            'lob_nama' => 'Lob Nama',
            'lob_aktif' => 'Lob Aktif',
            'lob_keterangan' => 'Lob Keterangan',
            'lob_created_at' => 'Lob Created At',
            'lob_created_by' => 'Lob Created By',
            'lob_updated_at' => 'Lob Updated At',
            'lob_updated_by' => 'Lob Updated By',
            'lob_deleted_at' => 'Lob Deleted At',
            'lob_deleted_by' => 'Lob Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return EbsMLoketPembayaranQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EbsMLoketPembayaranQuery(get_called_class());
    }
}
