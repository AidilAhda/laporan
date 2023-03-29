<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ebs_pembayaran_pasien".
 *
 * @property string $byr_kode Id Pembayaran Pasien
 * @property string $byr_pasien_kode No Pasien
 * @property string $byr_reg_kode No Registrasi
 * @property string $byr_tanggal Tanggal Pembayaran
 * @property int $byr_kob_id PK ebs_m_kode_pembayaran
 * @property string $byr_pmdd_kode PK pendaftaran_m_debitur_detail
 * @property float $byr_jumlah
 * @property string $byr_nama
 * @property string|null $byr_no_transaksi Id Kode Transaksi Obat/Tindakan
 * @property int $byr_lob_id PK ebs_m_loket_pembayaran
 * @property int $byr_shf_id PK ebs_m_shift
 * @property string|null $byr_keterangan
 * @property string|null $byr_created_at
 * @property int|null $byr_created_by
 * @property string|null $byr_updated_at
 * @property int|null $byr_updated_by
 * @property string|null $byr_deleted_at
 * @property int|null $byr_deleted_by
 */

class EbsPembayaranPasien extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ebs_pembayaran_pasien';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['byr_kode', 'byr_pasien_kode', 'byr_reg_kode', 'byr_kob_id', 'byr_pmdd_kode', 'byr_jumlah', 'byr_nama', 'byr_lob_id', 'byr_shf_id'], 'required'],
            [['byr_tanggal', 'byr_created_at', 'byr_updated_at', 'byr_deleted_at'], 'safe'],
            [['byr_kob_id', 'byr_lob_id', 'byr_shf_id', 'byr_created_by', 'byr_updated_by', 'byr_deleted_by'], 'integer'],
            [['byr_jumlah'], 'number'],
            [['byr_keterangan'], 'string'],
            [['byr_kode', 'byr_no_transaksi'], 'string', 'max' => 12],
            [['byr_pasien_kode', 'byr_reg_kode', 'byr_pmdd_kode'], 'string', 'max' => 10],
            [['byr_nama'], 'string', 'max' => 300],
            [['byr_kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'byr_kode' => 'Kode Pembayaran',
            'byr_pasien_kode' => 'No Pasien',
            'byr_reg_kode' => 'No Registrasi',
            'byr_tanggal' => 'Tanggal Pembayaran',
            'byr_kob_id' => 'Kode Jenis Pembayaran',
            'byr_pmdd_kode' => 'Kode Debitur Detail',
            'byr_jumlah' => 'Jumlah Pembayaran',
            'byr_nama' => 'Nama Bayar',
            'byr_no_transaksi' => 'No Transaksi',
            'byr_lob_id' => 'Loket Bayar ID',
            'byr_shf_id' => 'Shift Bayar ID',
            'byr_keterangan' => 'Keterangan',
            'byr_created_at' => 'Byr Created At',
            'byr_created_by' => 'Byr Created By',
            'byr_updated_at' => 'Byr Updated At',
            'byr_updated_by' => 'Byr Updated By',
            'byr_deleted_at' => 'Byr Deleted At',
            'byr_deleted_by' => 'Byr Deleted By',
        ];
    }


    /**
     * {@inheritdoc}
     * @return EbsPembayaranPasienQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EbsPembayaranPasienQuery(get_called_class());
    }
    function getDebiturdetail()
    {
        return $this->hasOne(PendaftaranMDebiturDetail::className(),['pmdd_kode'=>'byr_pmdd_kode']);
    }
     function getKodebayar()
    {
        return $this->hasOne(EbsMKodePembayaran::className(),['kob_id'=>'byr_kob_id']);
    }
	function getKasir()
    {
        return $this->hasOne(SdmMPegawai::className(),['pgw_id'=>'byr_created_by']);
    }
	function getShift()
    {
        return $this->hasOne(EbsMShift::className(),['shf_id'=>'byr_shf_id']);
    }
      function generateNoPembayaran()
    {
        $nobayar=NULL;
        $check=false;
        while(!$check){

            $max=self::find()->where("byr_kode like '".date('ymd')."%' ")->max('byr_kode');

            $max=$max==NULL ? 0 : $max;
            $nobayar=date('ymd').sprintf('%0'.Yii::$app->params['nobayar']['length'].'d',substr($max,-6)+1);

            $count_check=self::find()->where(["byr_kode"=>$nobayar])->asArray()->limit(1)->one();
            if($count_check==NULL){
                $check=true;
            }
        }
        return $nobayar;
    }   
    public function getDataRiwayatPembayaran($NoPasien, $NoDaftar)
    {
        
         $Data = EbsPembayaranPasien::find()
        ->joinWith([ 'debiturdetail', 'kodebayar'],true)
        ->andWhere(['byr_pasien_kode'=>$NoPasien, 'byr_reg_kode'=>$NoDaftar])
        ->andWhere('byr_deleted_at is null')->asArray()->all();

        return $Data;
    }
     public function getDataPembayaran($NoPasien, $NoDaftar, $KodeBayar)
    {
        
         $Data = EbsPembayaranPasien::find()
        ->joinWith([ 'debiturdetail', 'kodebayar'],true)
        ->andWhere(['byr_pasien_kode'=>$NoPasien, 'byr_reg_kode'=>$NoDaftar, 'byr_kob_id'=>$KodeBayar])
        ->andWhere('byr_deleted_at is null')->asArray()->all();

        return $Data;
    }
     public function getDataPembayaranLain($NoPasien, $NoDaftar, $KodeLain)
    {
        
         $Data = EbsPembayaranPasien::find()
        ->joinWith([ 'debiturdetail', 'kodebayar'],true)
        ->andWhere(['not in','byr_kob_id',$KodeLain])
        ->andWhere(['byr_pasien_kode'=>$NoPasien, 'byr_reg_kode'=>$NoDaftar])
        ->andWhere('byr_deleted_at is null')->asArray()->all();

        return $Data;
    }
	
	public function getDataRiwayatPembayaranObat($date)
    {

        $kode = 3;  // Kode Menu Pembayaran Obat byr_kob_id = 3
        $tanggal = date('Y-m-d 00:00:01',strtotime($date));
        $sampai = date('Y-m-d 23:59:59',strtotime($date));
        
        $Data = EbsPembayaranPasien::find()
        ->joinWith([ 'debiturdetail', 'kodebayar'],true)
        ->andWhere(['between','byr_tanggal', $tanggal, $sampai])
        ->andWhere(['byr_kob_id'=>$kode])
        ->andWhere('byr_deleted_at is null')
        ->orderBy(['byr_tanggal' => SORT_DESC])
        ->asArray()->all();

        return $Data;
    }
}

