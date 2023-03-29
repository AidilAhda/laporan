<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ebs_biaya_ambulance".
 *
 * @property int $bynce_id id biaya ambulance
 * @property string $bynce_tgl_berangkat
 * @property string|null $bynce_pasien_kode
 * @property string|null $bynce_reg_kode
 * @property string $bynce_nama_pasien
 * @property string $bynce_alamat_tujuan alamat tujuan
 * @property int|null $bynce_jarak jarak tempuh
 * @property int $bynce_supir_id PK ebs_supir_ambulance
 * @property float $bynce_biaya
 * @property string|null $bynce_keterangan
 * @property string|null $bynce_created_at
 * @property int|null $bynce_created_by
 * @property string|null $bynce_updated_at
 * @property int|null $bynce_updated_by
 * @property string|null $bynce_deleted_at
 * @property int|null $bynce_deleted_by
 */
class EbsBiayaAmbulance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ebs_biaya_ambulance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bynce_tgl_berangkat', 'bynce_nama_pasien', 'bynce_alamat_tujuan', 'bynce_supir_id', 'bynce_biaya'], 'required'],
            [['bynce_tgl_berangkat', 'bynce_created_at', 'bynce_updated_at', 'bynce_deleted_at'], 'safe'],
            [['bynce_jarak', 'bynce_supir_id', 'bynce_created_by', 'bynce_updated_by', 'bynce_deleted_by'], 'integer'],
            [['bynce_biaya'], 'number'],
            [['bynce_keterangan'], 'string'],
            [['bynce_pasien_kode', 'bynce_reg_kode'], 'string', 'max' => 10],
            [['bynce_nama_pasien'], 'string', 'max' => 255],
            [['bynce_alamat_tujuan'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bynce_id' => 'Bynce ID',
            'bynce_tgl_berangkat' => 'Bynce Tgl Berangkat',
            'bynce_pasien_kode' => 'Bynce Pasien Kode',
            'bynce_reg_kode' => 'Bynce Reg Kode',
            'bynce_nama_pasien' => 'Bynce Nama Pasien',
            'bynce_alamat_tujuan' => 'Bynce Alamat Tujuan',
            'bynce_jarak' => 'Bynce Jarak',
            'bynce_supir_id' => 'Bynce Supir ID',
            'bynce_biaya' => 'Bynce Biaya',
            'bynce_keterangan' => 'Bynce Keterangan',
            'bynce_created_at' => 'Bynce Created At',
            'bynce_created_by' => 'Bynce Created By',
            'bynce_updated_at' => 'Bynce Updated At',
            'bynce_updated_by' => 'Bynce Updated By',
            'bynce_deleted_at' => 'Bynce Deleted At',
            'bynce_deleted_by' => 'Bynce Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return EbsBiayaAmbulanceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EbsBiayaAmbulanceQuery(get_called_class());
    }
	
	function getSupirambulance()
    {
        return $this->hasOne(EbsSupirAmbulance::className(),['spnce_id'=>'bynce_supir_id']);
    }

    public function getDataRiwayat($NoPasien, $NoDaftar)
    {
        
         $Data = EbsBiayaAmbulance::find()
        ->joinWith([ 'supirambulance'],true)
        ->andWhere(['bynce_pasien_kode'=>$NoPasien, 'bynce_reg_kode'=>$NoDaftar])
        ->andWhere('bynce_deleted_at is null')->asArray()->all();

        return $Data;
    }
	public function getDataAmbulance($NoPasien, $NoDaftar)
    {
        
         $Data = EbsBiayaAmbulance::find()
        ->joinWith([ 'supirambulance'],true)
        ->andWhere(['bynce_pasien_kode'=>$NoPasien, 'bynce_reg_kode'=>$NoDaftar])
        ->andWhere('bynce_deleted_at is null')->asArray()->one();

        return $Data;
    }
}

