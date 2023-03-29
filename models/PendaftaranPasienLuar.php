<?php
namespace app\models;
use Yii;
use app\widgets\AuthUser;
use yii\web\NotFoundHttpException;
class PendaftaranPasienLuar extends \yii\db\ActiveRecord
{
    static 
        $prefix="psl",
        $jenis_identitas=[1=>'KTP',2=>'SIM',3=>'PASPOR',4=>'NIP'],
        $status_kawin=['t'=>'Belum Kawin','k'=>'Kawin','d'=>'Duda','j'=>'Janda'],
        $kddk=['k'=>'Kepala Keluarga','i'=>'Istri','a'=>'Anak'];
    public $umur,$kebiasaan,$riwayat_penyakit;
    public $pen_nama,$pen_nomor;
    public $error_msg,$data;
    public $kunjungan,$umur_th,$umur_bln,$umur_hari;
    public static function tableName()
    {
        return 'pendaftaran_pasien_luar';
    }
    public static function primaryKey()
    {
        return ['psl_kode'];
    }
    public function rules()
    {
        return [
            [['psl_nama','psl_jenis_identitas', 'psl_no_identitas', 'psl_tempat_lahir', 'psl_tgl_lahir','psl_goldar', 'psl_agama_id', 'psl_jkel','psl_no_telp','psl_alamat',
            'psl_kewarganegaraan_id', 'psl_marital_status', 'psl_status'], 'required','on'=>'pasienLuar_baru','message'=>'{attribute} harus diisi'],
            [['psl_nama','psl_jenis_identitas', 'psl_no_identitas', 'psl_tempat_lahir', 'psl_tgl_lahir','psl_goldar', 'psl_agama_id', 'psl_jkel','psl_no_telp','psl_alamat','psl_kewarganegaraan_id', 'psl_marital_status', 'psl_status'], 'required','on'=>'pasienLuar_update','message'=>'{attribute} harus diisi'],
            
            [['psl_jenis_identitas', 'psl_agama_id', 'psl_kewarganegaraan_id', 'psl_created_by', 'psl_updated_by', 'psl_deleted_by', 'psl_status'], 'integer'],
            [['psl_tgl_lahir', 'psl_created_at', 'psl_updated_at', 'psl_deleted_at'], 'safe'],
            [['psl_alamat'], 'string'],
            [['psl_kode'], 'string', 'max' => 10],
            [['psl_no_identitas', 'psl_no_telp'], 'string', 'max' => 30],
            [['psl_nama', 'psl_tempat_lahir', 'psl_nama_pasangan', 'psl_ayah_nama', 'psl_ibu_nama'], 'string', 'max' => 255],
            [['psl_jkel', 'psl_marital_status','psl_kedudukan_keluarga'], 'string', 'max' => 1],
            [['psl_goldar'], 'string', 'max' => 2],
            [['psl_kode'], 'unique'],
            [['pen_nama','pen_nomor'], 'each', 'rule' => ['string']],
            ['pen_nama','checkPenanggung'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'psl_kode' => 'No. Rekam Medis',
            'psl_no_identitas' => 'No Identitas',
            'psl_jenis_identitas' => 'Jenis Identitas',
            'psl_nama' => 'Nama Pasien',
            'psl_tgl_lahir' => 'Tgl. Lahir',
            'psl_tempat_lahir' => 'Tempat Lahir',
            'psl_jkel' => 'Jenis kelamin',
            'psl_goldar' => 'Goldar',
            'psl_agama_id' => 'Agama',
            'psl_alamat' => 'Alamat',
            'psl_no_telp' => 'No Telp',
            'psl_kewarganegaraan_id' => 'Kewarganegaraan',
            'psl_marital_status' => 'Marital Status',
            'psl_kedudukan_keluarga' => 'Kedudukan Keluarga',
            'psl_nama_pasangan' => 'Nama Pasangan',
            'psl_ayah_nama' => 'Nama Ayah',
            'psl_ibu_nama' => 'Nama Ibu',
            'psl_created_at' => 'Psl Created At',
            'psl_created_by' => 'Psl Created By',
            'psl_updated_at' => 'Psl Updated At',
            'psl_updated_by' => 'Psl Updated By',
            'psl_deleted_at' => 'Psl Deleted At',
            'psl_deleted_by' => 'Psl Deleted By',
            'psl_deleted_by' => 'Psl Deleted By',
            'psl_status' => 'Psl Status',
        ];
    }
    /**
     * {@inheritdoc}
     * @return PendaftaranPasienLuarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PendaftaranPasienLuarQuery(get_called_class());
    }
    public function behaviors()
    {
        return [
            [
                'class'=>TrimBehavior::className(),
            ],
        ];
    }
    function beforeSave($model)
    {
        if($this->psl_marital_status=='t'){
            $this->psl_nama_pasangan=NULL;
        }
        $this->psl_tgl_lahir=date('Y-m-d',strtotime($this->psl_tgl_lahir));
        if($this->isNewRecord){
            $this->psl_created_at=date('Y-m-d H:i:s');
            $this->psl_created_by=AuthUser::user()->id;
        }else{
            $this->psl_updated_at=date('Y-m-d H:i:s');
            $this->psl_updated_by=AuthUser::user()->id;
        }
        return parent::beforeSave($model);
    }
    function attr()
    {
        $data=[];
        foreach($this->attributeLabels() as $key => $val){
            $data[$val]=$this->{$key};
        }
        return $data;
    }
    function checkPenanggung($attribute, $params)
    {
        if(!$this->hasErrors()){
            if($this->pen_nama>0){
                if(count($this->pen_nama)<0 && count($this->pen_nomor)<0){
                    $this->addError($attribute, 'Silahkan lengkapi data penanggung !');
                }
            }
        }
    }
    function getAgama()
    {
        return $this->hasOne(Agama::className(),['agm_id'=>'psl_agama_id']);
    }
    function getNegara()
    {
        return $this->hasOne(Negara::className(),['ngr_id'=>'psl_kewarganegaraan_id']);
    }
    function getPenanggung()
    {
        return $this->hasMany(PendaftaranPasienPenanggung::className(), ['pen_pasien_kode' => 'psl_kode']);
    }
    static function formatRm($norm)
    {
        return sprintf('%0'.Yii::$app->params['rm']['length'].'d',$norm);
    }
    function getAge()
    {
        $interval = date_diff(date_create(), date_create($this->psl_tgl_lahir));
        $this->umur_th = $interval->format('%Y');
        $this->umur_bln = $interval->format('%M');
        $this->umur_hari = $interval->format('%d');
    }
    static function getData($rm)
    {
        return self::find()->select('psl_kode as no_pasien,psl_no_identitas,psl_nama,psl_jkel,psl_alamat,psl_tgl_lahir,psl_tempat_lahir,psl_no_telp')->where(['or',['psl_kode'=>$rm],['psl_no_identitas'=>$rm]])->notDeleted(self::$prefix)->asArray()->limit(1)->one();
    }
    static function getNik($rm)
    {
        $data=self::find()->select('psl_no_identitas')->where(['psl_kode'=>$rm,'psl_jenis_identitas'=>1])->asArray()->limit(1)->one();
        if($data!=NULL){
            return $data['psl_no_identitas'];
        }
        return NULL;
    }
    function generateRmPasienLuar()
    {
        $date = date('d-m-Y'); // Ganti manual dengan tanggal berikutnya jika pRM Pasien Luar Penuh misalkan : $date = '23-05-2021';
        $kode = 'L'.date('ymd', strtotime($date));

        $max=substr(self::find()->where(['like','psl_kode', $kode.'%',false])->max('psl_kode'),7);


        if($max == 999){
            $this->error_msg='Kode RM Pasien Luar untuk kode = '.$kode.' sudah penuh. Hub Administrator IT anda !';
            return false;
        } else {

            $rm=NULL;
            $check=false;
            while(!$check){
                $no_urut=NULL;
                //substr max rm
                if(!empty($max)){
                    $no_urut=$max;
                }
                $rm=$kode.sprintf('%0'.Yii::$app->params['rmPasienLuar']['length'].'d',$no_urut+1);
                $check_count=self::find()->where(['psl_kode'=>$rm])->asArray()->limit(1)->one();
                if($check_count==NULL){
                    $check=true;
                }
            }

            if($rm!=NULL){
                $this->psl_kode=$rm;
                return true;
            }
            $this->error_msg="Terjadi kesalahan generate No. RM, Hub. Administrator IT anda !";
            return false;
            
        }
    }
    function savePasienLuar()
    {
        if($this->psl_kode==NULL){
            if(!$this->generateRmPasienLuar()){
                return false;
            }
        }
        
        $log=[];
        if($this->scenario=="pasienLuar_update"){
            $log['sebelum']=$this->attr();
        }
        $this->kunjungan=PendaftaranRegistrasi::countKunjungan($this->psl_kode);
        $trans = self::getDb()->beginTransaction();
        try {
            $this->save(false);
            $riw=new PendaftaranPasienPenanggung();
            if(!$riw->savePasienLuarPenanggung($this)){
                $trans->rollBack();
                $this->error_msg="Error 4";
                return false;
            }
            if($this->scenario=="pasienLuar_update"){
                $log['sesudah']=$this->attr();
            }
            $this->kunjungan++;
            Log::saveLog(($this->scenario=="pasienLuar_baru"?"Buat":"Update")." PasienLuar",$log);
            $trans->commit();
            return true;
        } catch(\Exception $e) {
            $trans->rollBack();
            throw $e;
        } catch(\Throwable $e) {
            $trans->rollBack();
            throw $e;
        }
    }
    function searchPasienLuar($id)
    {
        $id=trim($id);
        $model = PendaftaranPasienLuar::find()->with([
                'penanggung'=>function($q){
             
                }
            ])->where(['like','psl_kode',$id])->asArray()->limit(1)->one();


    
        if($model!=NULL){
            $model['psl_tgl_lahir']=date('d-m-Y',strtotime($model['psl_tgl_lahir']));
    
            //custom penanggung
            if(count($model['penanggung'])>0){
                $model['penanggung']=array_map(function($q){
                    return ['debitur'=>$q['pen_pmd_kode'].'_'.$q['pen_pmdd_kode'],'nomor'=>$q['pen_no_kartu']];
                },$model['penanggung']);
            }
            
            //get latest rawatpoli/rawatinap
            $layanan=PendaftaranLayanan::searchLayanan($model['psl_kode']);
            $this->data=[
				'id'=>$model['psl_kode'],
                'biodata'=>$model,
                'layanan'=>$layanan,
            ];
            return true;
        }
        $this->error_msg="Data pasien tidak ditemukan, silahkan periksa kembali No. RM atau No. Identitas pasien";
        return false;
    }

    function biodataPasienLuar($id)
    {
          $model = PendaftaranPasienLuar::find()->with([
            ])->where(['like','psl_kode',$id])->asArray()->limit(1)->one();


        if($model!=NULL){
            $model['psl_tgl_lahir']=date('d-m-Y',strtotime($model['psl_tgl_lahir']));

            $interval = date_diff(date_create(), date_create($model['psl_tgl_lahir']));

            return $this->data=[
                'id'=>$model['psl_kode'],
                'nama' => $model['psl_nama'],
                'tempatLahir' => $model['psl_tempat_lahir'],
                'tanggalLahir' => $model['psl_tgl_lahir'],
                'umur' => [
                    'tahun' => $interval->format('%Y'),
                    'bulan' => $interval->format('%M'),
                    'hari' => $interval->format('%d'),
                ],
                'jenisKelamin' => $model['psl_jkel'] == 'l' ? 'Laki-Laki' : 'Perempuan',
                'noIdentitas' => $model['psl_no_identitas'],
                'noTelepon' => $model['psl_no_telp'],
                'alamat' => $model['psl_alamat'],
            ];
        }
        return Null;
    }
 
}
