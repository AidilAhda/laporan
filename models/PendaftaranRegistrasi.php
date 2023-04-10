<?php
namespace app\models;
use app\widgets\AuthUser;
use app\models\Sep;
use Yii;
class PendaftaranRegistrasi extends \yii\db\ActiveRecord
{
    public $kunjungan,$unit,$data,$error_msg,$kiriman,$debitur,$nama;
    public static $igd=1,$rj=2,$ri=3,$pnj=4;
    static $prefix='reg';
    public static function tableName()
    {
        return 'pendaftaran_registrasi';
    }
    public function rules()
    {
        return [
            [['kiriman','reg_pmkd_kode', 'debitur','reg_pmdd_kode','unit'], 'required','on'=>'daftar_baru','message'=>'{attribute} harus diisi'],
            [['kiriman','reg_pmkd_kode', 'debitur','reg_pmdd_kode','unit'], 'required','on'=>'daftar_update','message'=>'{attribute} harus diisi'],

            [['debitur','reg_pmdd_kode'], 'required','on'=>'penanggung_update','message'=>'{attribute} harus diisi'],

            [['reg_tgl_masuk', 'reg_tgl_keluar', 'reg_created_at', 'reg_updated_at', 'reg_deleted_at'], 'safe'],
            [['reg_is_print', 'reg_status_bayar','reg_created_by', 'reg_updated_by', 'reg_deleted_by'], 'integer'],
            [['reg_kode', 'reg_pasien_kode', 'reg_pmkd_kode', 'reg_pmdd_kode'], 'string', 'max' => 10],
            [['reg_no_sep'], 'string', 'max' => 50],
            [['reg_kode'], 'unique'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'reg_kode' => 'No. Registrasi',
            'reg_pasien_kode' => 'No. Rekam Medis',
            'reg_tgl_masuk' => 'Tgl Masuk',
            'reg_tgl_keluar' => 'Tgl Keluar',
            'reg_pmkd_kode' => 'Detail Kiriman Dari',
            'reg_pmdd_kode' => 'Detail Cara Bayar',
            'reg_no_sep' => 'No Sep',
            'reg_is_print' => 'Reg Is Print',
            'reg_status_bayar' => 'Status Bayar',
            'reg_created_at' => 'Reg Created At',
            'reg_created_by' => 'Reg Created By',
            'reg_updated_at' => 'Reg Updated At',
            'reg_updated_by' => 'Reg Updated By',
            'reg_deleted_at' => 'Reg Deleted At',
            'reg_deleted_by' => 'Reg Deleted By',
        ];
    }
    static function find()
    {
        return new PendaftaranRegistrasiQuery(get_called_class());
    }
    public function behaviors()
    {
        return [
            [
                'class'=>TrimBehavior::className(),
            ],
        ];
    }
    function attr()
    {
        $data=[];
        foreach($this->attributeLabels() as $key => $val){
            $data[$val]=$this->{$key};
        }
        return $data;
    }
 
    function getLayanan()
    {
        return $this->hasMany(PendaftaranLayanan::className(),['pl_reg_kode'=>'reg_kode']);
    }
    function getLayananhasone()
    {
        return $this->hasOne(PendaftaranLayanan::className(),['pl_reg_kode'=>'reg_kode']);
    }
    public function getDebiturdetail()
    {
        return $this->hasOne(PendaftaranMDebiturDetail::className(), ['pmdd_kode' => 'reg_pmdd_kode']);
    }
    public function getKirimandetail()
    {
        return $this->hasOne(PendaftaranMKirimanDetail::className(), ['pmkd_kode' => 'reg_pmkd_kode']);
    }
    public function getPasien()
    {
        return $this->hasOne(PendaftaranPasien::className(), ['ps_kode' => 'reg_pasien_kode']);
    }
    public function getPasienluar()
    {
        return $this->hasOne(PendaftaranPasienLuar::className(), ['psl_kode' => 'reg_pasien_kode']);
    }

    public function getSepBpjs()
    {
        return $this->hasOne(Sep::className(), ['sep_reg_kode' => 'reg_no_sep']);
    }

    function getUnitLayanan()
    {
        $query=PendaftaranLayanan::find()->select('pl_unit_kode')->where(['pl_reg_kode'=>$this->reg_kode,"DATE_FORMAT(pl_tgl_masuk,'%Y-%m-%d %H:%i')"=>date('Y-m-d H:i',strtotime($this->reg_tgl_masuk))])->notDeleted(PendaftaranLayanan::$prefix)->asArray()->limit(1)->one();
        return $query!=NULL ? $query['pl_unit_kode'] : NULL;
    }

    static function countKunjungan($rm)
    {
        return self::find()->where(['reg_pasien_kode'=>$rm])->notDeleted(self::$prefix)->count();
    }
   
}