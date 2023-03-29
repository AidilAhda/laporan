<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pendaftaran_pasien".
 *
 * @property string $ps_kode
 * @property string $ps_no_identitas
 * @property int $ps_jenis_identitas 1=ktp,2=sim,3=passpor,4=nip
 * @property string $ps_nama
 * @property string $ps_tgl_lahir
 * @property string $ps_tempat_lahir
 * @property string $ps_jkel l,p
 * @property string|null $ps_goldar
 * @property int $ps_agama_id
 * @property int|null $ps_suku_id
 * @property int|null $ps_pendidikan_id
 * @property int|null $ps_jurusan_id
 * @property int|null $ps_pekerjaan_id
 * @property string|null $ps_tempat_kerja
 * @property string|null $ps_alamat_tempat_kerja
 * @property int|null $ps_kesatuan_id
 * @property string|null $ps_kesatuan_nomor
 * @property int|null $ps_pangkat_detail_id PK sdm_m_pangkat_detail
 * @property int|null $ps_penghasilan
 * @property string $ps_alamat
 * @property string $ps_no_telp
 * @property string $ps_kelurahan_id
 * @property int|null $ps_kewarganegaraan_id
 * @property string|null $ps_marital_status t=belum kawin, k=kawin,d=duda,j=janda
 * @property int|null $ps_kedudukan_keluarga 1=Kepala Keluarga,2=Istri,3=Anak
 * @property string|null $ps_nama_pasangan
 * @property int|null $ps_istri_ke
 * @property int|null $ps_anak_ke
 * @property int|null $ps_jml_anak
 * @property string|null $ps_ayah_nama
 * @property string|null $ps_ayah_no_rekam_medis
 * @property string|null $ps_ibu_nama
 * @property string|null $ps_ibu_no_rekam_medis
 * @property string|null $ps_created_at
 * @property int|null $ps_created_by
 * @property string|null $ps_updated_at
 * @property int|null $ps_updated_by
 * @property string|null $ps_deleted_at
 * @property int|null $ps_deleted_by
 */
class PendaftaranPasien extends \yii\db\ActiveRecord
{
     static 
        $prefix="ps",
        $jenis_identitas=[1=>'KTP',2=>'SIM',3=>'PASPOR',4=>'NIP'],
        $status_kawin=['t'=>'Belum Kawin','k'=>'Kawin','d'=>'Duda','j'=>'Janda'],
        $kddk=['k'=>'Kepala Keluarga','i'=>'Istri','a'=>'Anak'];
    public $umur,$kebiasaan,$riwayat_penyakit;
    public $anak_nama,$anak_tgl,$anak_status,$anak_mr;
    public $pen_nama,$pen_nomor;
    public $error_msg,$data;
    public $kunjungan,$umur_th,$umur_bln,$umur_hari;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran_pasien';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ps_nama','ps_jenis_identitas', 'ps_no_identitas', 'ps_tempat_lahir', 'ps_tgl_lahir','ps_goldar', 'ps_agama_id', 'ps_jkel','ps_suku_id','ps_pendidikan_id', 'ps_pekerjaan_id','ps_no_telp','ps_alamat','ps_kelurahan_id','ps_kewarganegaraan_id', 'ps_marital_status'], 'required','on'=>'pasien_baru','message'=>'{attribute} harus diisi'],
            [['ps_nama','ps_jenis_identitas', 'ps_no_identitas', 'ps_tempat_lahir', 'ps_tgl_lahir','ps_goldar', 'ps_agama_id', 'ps_jkel','ps_suku_id','ps_pendidikan_id', 'ps_pekerjaan_id','ps_no_telp','ps_alamat','ps_kelurahan_id','ps_kewarganegaraan_id', 'ps_marital_status'], 'required','on'=>'pasien_update','message'=>'{attribute} harus diisi'],
            
            [['ps_kesatuan_id','ps_pangkat_detail_id','ps_jenis_identitas', 'ps_agama_id', 'ps_suku_id', 'ps_pendidikan_id', 'ps_jurusan_id', 'ps_pekerjaan_id', 'ps_penghasilan', 'ps_kewarganegaraan_id', 'ps_istri_ke', 'ps_anak_ke', 'ps_jml_anak', 'ps_created_by', 'ps_updated_by', 'ps_deleted_by'], 'integer'],
            [['ps_tgl_lahir', 'ps_created_at', 'ps_updated_at', 'ps_deleted_at'], 'safe'],
            [['ps_alamat','ps_kebiasaan','ps_riwayat_penyakit'], 'string'],
            [['ps_kode', 'ps_kelurahan_id', 'ps_ayah_no_rekam_medis', 'ps_ibu_no_rekam_medis'], 'string', 'max' => 10],
            [['ps_no_identitas', 'ps_no_telp'], 'string', 'max' => 30],
            [['ps_kesatuan_nomor'],'string','max'=>20],
            [['ps_nama', 'ps_tempat_lahir', 'ps_tempat_kerja', 'ps_alamat_tempat_kerja', 'ps_nama_pasangan', 'ps_ayah_nama', 'ps_ibu_nama'], 'string', 'max' => 255],
            [['ps_jkel', 'ps_marital_status','ps_kedudukan_keluarga'], 'string', 'max' => 1],
            [['ps_goldar'], 'string', 'max' => 2],
            [['ps_kode'], 'unique'],
            [['kebiasaan','riwayat_penyakit'], 'each', 'rule' => ['integer']],
            [['anak_nama','anak_tgl','anak_status','pen_nama','pen_nomor'], 'each', 'rule' => ['string']],
            ['ps_jml_anak','checkAnak'],
            ['pen_nama','checkPenanggung'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ps_kode' => 'No. Rekam Medis',
            'ps_no_identitas' => 'No Identitas',
            'ps_jenis_identitas' => 'Jenis Identitas',
            'ps_nama' => 'Nama Pasien',
            'ps_tgl_lahir' => 'Tgl. Lahir',
            'ps_tempat_lahir' => 'Tempat Lahir',
            'ps_jkel' => 'Jenis kelamin',
            'ps_goldar' => 'Goldar',
            'ps_agama_id' => 'Agama',
            'ps_suku_id' => 'Suku',
            'ps_pendidikan_id' => 'Pendidikan',
            'ps_jurusan_id' => 'Jurusan',
            'ps_pekerjaan_id' => 'Pekerjaan',
            'ps_kesatuan_id'=>'Kesatuan',
            'ps_kesatuan_nomor'=>'Nomor Kesatuan',
            'ps_pangkat_detail_id'=>'Pangkat',
            'ps_tempat_kerja' => 'Nama Tempat Kerja',
            'ps_alamat_tempat_kerja' => 'Alamat Tempat Kerja',
            'ps_penghasilan' => 'Penghasilan',
            'ps_alamat' => 'Alamat',
            'ps_no_telp' => 'No Telp',
            'ps_kelurahan_id' => 'Kelurahan',
            'ps_kewarganegaraan_id' => 'Kewarganegaraan',
            'ps_marital_status' => 'Marital Status',
            'ps_kedudukan_keluarga' => 'Kedudukan Keluarga',
            'ps_nama_pasangan' => 'Nama Pasangan',
            'ps_istri_ke' => 'Istri Ke',
            'ps_anak_ke' => 'Anak Ke',
            'ps_jml_anak' => 'Jml Anak',
            'ps_ayah_nama' => 'Nama Ayah',
            'ps_ayah_no_rekam_medis' => 'No Rekam Medis Ayah',
            'ps_ibu_nama' => 'Nama Ibu',
            'ps_ibu_no_rekam_medis' => 'No Rekam Medis Ibu',
            'ps_kebiasaan'=>'Kebiasaan Sehari-hari',
            'ps_riwayat_penyakit'=>'Riwayat Penyakit',
            'ps_created_at' => 'Ps Created At',
            'ps_created_by' => 'Ps Created By',
            'ps_updated_at' => 'Ps Updated At',
            'ps_updated_by' => 'Ps Updated By',
            'ps_deleted_at' => 'Ps Deleted At',
            'ps_deleted_by' => 'Ps Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PendaftaranPasienQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PendaftaranPasienQuery(get_called_class());
    }

    public function behaviors()
    {
        return [
            [
                'class'=>TrimBehavior::className(),
            ],
        ];
    }
     function getPendidikan()
    {
        return $this->hasOne(Pendidikan::className(),['pdd_id'=>'ps_pendidikan_id']);
    }
    function getPekerjaan()
    {
        return $this->hasOne(Pekerjaan::className(),['pkj_id'=>'ps_pekerjaan_id']);
    }
    function getAgama()
    {
        return $this->hasOne(Agama::className(),['agm_id'=>'ps_agama_id']);
    }
    function getSuku()
    {
        return $this->hasOne(Suku::className(),['suk_id'=>'ps_suku_id']);
    }
    function getNegara()
    {
        return $this->hasOne(Negara::className(),['ngr_id'=>'ps_kewarganegaraan_id']);
    }
    function getPenanggung()
    {
        return $this->hasMany(PendaftaranPasienPenanggung::className(), ['pen_pasien_kode' => 'ps_kode']);
    }
    function getKelurahan()
    {
        return $this->hasOne(SdmMKelurahanDesa::className(),['kel_kode'=>'ps_kelurahan_id']);
    }
    function getAge($tgl_lahir)
    {
        $interval = date_diff(date_create(), date_create($tgl_lahir));

        return $interval->format('%Y').' Tahun '.$interval->format('%M').' Bulan '. $interval->format('%d').' Hari ';
    }
    function searchPasien($id)
    {
        //$id=trim($id);
        $model = PendaftaranPasien::find()->where(['like','ps_kode',$id])->asArray()->limit(1)->one();
        if($model!=NULL){
             $this->data=[
                'id' => $id,
                'biodata'=>$model,
            ];
          
            return true;
        }
        $this->error_msg="Data pasien tidak ditemukan, silahkan periksa kembali No. RM atau No. Identitas pasien";
        return false;
    }
    function biodataPasien($id)
    {
        $model = PendaftaranPasien::find()->with([
                'kelurahan'=>function($q){
                    $q->select(["kel_kode as id","concat('<b>KEL:</b> ',kel_nama,' <b>KEC: </b>',kec_nama,', <b>KAB:</b> ',kab_nama,', <b>PROV:</b> ',prv_nama) as text"])
                    ->joinWith(['kecamatan'=>function($q){
                        $q->joinWith(['kabupaten'=>function($q){
                            $q->joinWith(['provinsi'],false);
                        }],false);
                    }],false);
                }
            ])->where(['like','ps_kode',$id])->asArray()->limit(1)->one();

        if($model!=NULL){
          
            if($model['ps_tgl_lahir'] == '0000-00-00') {
                $model['ps_tgl_lahir'] = '0000-00-00';
                $umur = '-';
            } else {
                $model['ps_tgl_lahir']=date('d-m-Y',strtotime($model['ps_tgl_lahir']));
                $umur = $this->getAge($model['ps_tgl_lahir']);
            }
          
            return $this->data=[
                'id'=>$model['ps_kode'],
                'nama' => $model['ps_nama'],
                'tempatLahir' => $model['ps_tempat_lahir'],
                'tanggalLahir' => $model['ps_tgl_lahir'],
                'umur' => $umur,
                'jenisKelamin' => $model['ps_jkel'] == 'l' ? 'Laki-Laki' : 'Perempuan',
                'noIdentitas' => $model['ps_no_identitas'],
                'noTelepon' => $model['ps_no_telp'],
                'alamat' => $model['ps_alamat'],
            ];
        }
        return Null;
    }
}
