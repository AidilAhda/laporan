<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ebs_pembayaran_plafon".
 *
 * @property string $byp_kode Id Pembayaran Plafon
 * @property string $byp_pasien_kode No Pasien/Pasien Luar
 * @property string $byp_reg_kode No Registrasi
 * @property string $byp_tanggal
 * @property int $byp_kob_id PK ebs_m_kode_pembayaran
 * @property string $byp_pmdd_kode 	PK pendaftaran_m_debitur_detail	
 * @property float $byp_jumlah Jumlah yang dialihkan ke debitur
 * @property string|null $byp_tanggal_terima Tanggal terima pembayaran dari debitur
 * @property float|null $byp_jumah_terima Jumlah yang diterima dari debitur
 * @property string $byp_nama
 * @property int $byp_lob_id PK ebs_m_loket_pembayaran
 * @property int $byp_shf_id PK ebs_m_shift
 * @property string|null $byp_keterangan
 * @property string|null $byp_created_at
 * @property int|null $byp_created_by
 * @property string|null $byp_updated_at
 * @property int|null $byp_updated_by
 * @property string|null $byp_deleted_at
 * @property int|null $byp_deleted_by
 */
class EbsPembayaranPlafon extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ebs_pembayaran_plafon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['byp_kode', 'byp_pasien_kode', 'byp_reg_kode', 'byp_kob_id', 'byp_pmdd_kode', 'byp_jumlah', 'byp_nama', 'byp_lob_id', 'byp_shf_id'], 'required'],
            [['byp_tanggal', 'byp_tanggal_terima', 'byp_created_at', 'byp_updated_at', 'byp_deleted_at'], 'safe'],
            [['byp_kob_id', 'byp_lob_id', 'byp_shf_id', 'byp_created_by', 'byp_updated_by', 'byp_deleted_by'], 'integer'],
            [['byp_jumlah', 'byp_jumah_terima'], 'number'],
            [['byp_keterangan'], 'string'],
            [['byp_kode'], 'string', 'max' => 12],
            [['byp_pasien_kode', 'byp_reg_kode', 'byp_pmdd_kode'], 'string', 'max' => 10],
            [['byp_nama'], 'string', 'max' => 300],
            [['byp_kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'byp_kode' => 'Byp Kode',
            'byp_pasien_kode' => 'Byp Pasien Kode',
            'byp_reg_kode' => 'Byp Reg Kode',
            'byp_tanggal' => 'Byp Tanggal',
            'byp_kob_id' => 'Byp Kob ID',
            'byp_pmdd_kode' => 'Byp Pmdd Kode',
            'byp_jumlah' => 'Byp Jumlah',
            'byp_tanggal_terima' => 'Byp Tanggal Terima',
            'byp_jumah_terima' => 'Byp Jumah Terima',
            'byp_nama' => 'Byp Nama',
            'byp_lob_id' => 'Byp Lob ID',
            'byp_shf_id' => 'Byp Shf ID',
            'byp_keterangan' => 'Byp Keterangan',
            'byp_created_at' => 'Byp Created At',
            'byp_created_by' => 'Byp Created By',
            'byp_updated_at' => 'Byp Updated At',
            'byp_updated_by' => 'Byp Updated By',
            'byp_deleted_at' => 'Byp Deleted At',
            'byp_deleted_by' => 'Byp Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return EbsPembayaranPlafonQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EbsPembayaranPlafonQuery(get_called_class());
    }
    function getDebiturdetail()
    {
        return $this->hasOne(PendaftaranMDebiturDetail::className(),['pmdd_kode'=>'byp_pmdd_kode']);
    }
     function getKodebayar()
    {
        return $this->hasOne(EbsMKodePembayaran::className(),['kob_id'=>'byp_kob_id']);
    }
    function generateNoPembayaranPlafon()
    {
        $nobayar=NULL;
        $check=false;
        while(!$check){

            $max=self::find()->where("byp_kode like '".date('ymd')."%' ")->max('byp_kode');

            $max=$max==NULL ? 0 : $max;
            $nobayar=date('ymd').sprintf('%0'.Yii::$app->params['nobayarplafon']['length'].'d',substr($max,-6)+1);

            $count_check=self::find()->where(["byp_kode"=>$nobayar])->asArray()->limit(1)->one();
            if($count_check==NULL){
                $check=true;
            }
        }
        return $nobayar;
    } 
    public function getDataRiwayatPlafon($NoPasien, $NoDaftar)
    {
        
         $Data = EbsPembayaranPlafon::find()
        ->joinWith([ 'debiturdetail', 'kodebayar'],true)
        ->andWhere(['byp_pasien_kode'=>$NoPasien, 'byp_reg_kode'=>$NoDaftar])
        ->andWhere('byp_deleted_at is null')->asArray()->all();

        return $Data;
    }
    public function getDataPembayaranPlafon($NoPasien, $NoDaftar, $KodeBayar)
    {
        
         $Data = EbsPembayaranPlafon::find()
        ->joinWith([ 'debiturdetail', 'kodebayar'],true)
        ->andWhere(['byp_pasien_kode'=>$NoPasien, 'byp_reg_kode'=>$NoDaftar, 'byp_kob_id'=>$KodeBayar])
        ->andWhere('byp_deleted_at is null')->asArray()->all();

        return $Data;
    }
}
