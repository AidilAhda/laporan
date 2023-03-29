<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ebs_berita_acara".
 *
 * @property int $eber_kode kode berita acara
 * @property string|null $eber_tanggal_berita tanggal berita acara
 * @property string $eber_keterangan keterangan berita acara
 * @property string|null $eber_created_at
 * @property int|null $eber_created_by
 * @property string|null $eber_updated_at
 * @property int|null $eber_updated_by
 * @property int|null $eber_deleted_at
 * @property int|null $eber_deleted_by
 */
class EbsBeritaAcara extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ebs_berita_acara';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['eber_tanggal_berita', 'eber_created_at', 'eber_updated_at'], 'safe'],
            [['eber_keterangan'], 'required'],
            [['eber_keterangan'], 'string'],
            [['eber_created_by', 'eber_updated_by', 'eber_deleted_at', 'eber_deleted_by'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'eber_kode' => 'Eber Kode',
            'eber_tanggal_berita' => 'Eber Tanggal Berita',
            'eber_keterangan' => 'Eber Keterangan',
            'eber_created_at' => 'Eber Created At',
            'eber_created_by' => 'Eber Created By',
            'eber_updated_at' => 'Eber Updated At',
            'eber_updated_by' => 'Eber Updated By',
            'eber_deleted_at' => 'Eber Deleted At',
            'eber_deleted_by' => 'Eber Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return EbsBeritaAcaraQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EbsBeritaAcaraQuery(get_called_class());
    }
}
