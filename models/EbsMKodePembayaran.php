<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ebs_m_kode_pembayaran".
 *
 * @property int $kob_id Kode Bayar Id
 * @property string $kob_nama Kode Bayar Nama
 * @property int $kob_aktif 1 => aktif 0 => Tidak Aktif	
 * @property int $kob_plafon 0 => Bukan Pembayaran Plafon 1 => Pembayaran Plafon
 * @property string $kob_keterangan Keterangan Kode Pembayaran
 * @property string|null $kob_created_at
 * @property int|null $kob_created_by
 * @property string|null $kob_updated_at
 * @property int|null $kob_updated_by
 * @property string|null $kob_deleted_at
 * @property int|null $kob_deleted_by
 */
class EbsMKodePembayaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ebs_m_kode_pembayaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kob_nama', 'kob_keterangan'], 'required'],
            [['kob_aktif', 'kob_plafon', 'kob_created_by', 'kob_updated_by', 'kob_deleted_by'], 'integer'],
            [['kob_keterangan'], 'string'],
            [['kob_created_at', 'kob_updated_at', 'kob_deleted_at'], 'safe'],
            [['kob_nama'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kob_id' => 'Kob ID',
            'kob_nama' => 'Kob Nama',
            'kob_aktif' => 'Kob Aktif',
            'kob_plafon' => 'Kob Plafon',
            'kob_keterangan' => 'Kob Keterangan',
            'kob_created_at' => 'Kob Created At',
            'kob_created_by' => 'Kob Created By',
            'kob_updated_at' => 'Kob Updated At',
            'kob_updated_by' => 'Kob Updated By',
            'kob_deleted_at' => 'Kob Deleted At',
            'kob_deleted_by' => 'Kob Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return EbsMKodePembayaranQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EbsMKodePembayaranQuery(get_called_class());
    }
}
