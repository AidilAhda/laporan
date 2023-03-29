<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ebs_debitur_lainnya".
 *
 * @property string $dbl_pasien_kode PK Pendaftaran Pasien/Pasien Luar
 * @property string $dbl_registrasi_kode PK Pendaftaran Registrasi
 * @property string|null $dbl_tanggal
 * @property string $dbl_pmdd_kode PK pendaftaran_m_debitur_detail
 * @property string|null $dbl_created_at
 * @property int|null $dbl_created_by
 * @property string|null $dbl_updated_at
 * @property int|null $dbl_updated_by
 * @property string|null $dbl_deleted_at
 * @property int|null $dbl_deleted_by
 */
class EbsDebiturLainnya extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ebs_debitur_lainnya';
    }

    /**
     * {@inheritdoc}
     */
     public function rules()
    {
        return [
            [['dbl_pasien_kode', 'dbl_registrasi_kode', 'dbl_pmdd_kode'], 'required'],
            [['dbl_tanggal', 'dbl_created_at', 'dbl_updated_at', 'dbl_deleted_at'], 'safe'],
            [['dbl_created_by', 'dbl_updated_by', 'dbl_deleted_by'], 'integer'],
            [['dbl_pasien_kode', 'dbl_registrasi_kode', 'dbl_pmdd_kode'], 'string', 'max' => 10],
            [['dbl_pasien_kode', 'dbl_registrasi_kode', 'dbl_pmdd_kode'], 'unique', 'targetAttribute' => ['dbl_pasien_kode', 'dbl_registrasi_kode', 'dbl_pmdd_kode']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dbl_pasien_kode' => 'Pasien Kode',
            'dbl_registrasi_kode' => 'Registrasi Kode',
            'dbl_tanggal' => 'Tanggal',
            'dbl_pmdd_kode' => 'Kode Debitur',
            'dbl_created_at' => 'Dbl Created At',
            'dbl_created_by' => 'Dbl Created By',
            'dbl_updated_at' => 'Dbl Updated At',
            'dbl_updated_by' => 'Dbl Updated By',
            'dbl_deleted_at' => 'Dbl Deleted At',
            'dbl_deleted_by' => 'Dbl Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return EbsDebiturLainnyaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EbsDebiturLainnyaQuery(get_called_class());
    }
     public function getDebiturdetail()
    {
        return $this->hasOne(PendaftaranMDebiturDetail::className(), ['pmdd_kode' => 'dbl_pmdd_kode']);
    }
}
