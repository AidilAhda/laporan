<?php
namespace app\models;
use Yii;
use app\widgets\AuthUser;
use app\models\BaseQuery;
use app\models\BpjsApi;
use app\models\pendaftaran\Registrasi;
class Sep extends \yii\db\ActiveRecord
{
    public $error_msg,$keluhan,$scenario_name;
    public $penjamin_lakalantas;
    public $reg_data,$sep_data,$sep_data_old;
    const prefix="sep";
    public static function tableName()
    {
        return 'bpjskes_sep';
    }
    public function rules()
    {
        return [
            [['sep_pasien_kode','sep_tgl_sep','sep_tgl_rujukan', 'sep_asal_rujukan_kode', 'sep_jenis_pelayanan','sep_asal_rujukan_tingkat','sep_diagnosa_kode','sep_poli_kode','sep_tujuan_kunjungan'], 'required','on'=>['create_rj'],'message'=>'{attribute} harus diisi'],
            [['sep_pasien_kode','sep_tgl_sep','sep_tgl_rujukan', 'sep_asal_rujukan_kode', 'sep_jenis_pelayanan','sep_asal_rujukan_tingkat','sep_diagnosa_kode','sep_poli_kode','sep_tujuan_kunjungan','sep_laka_lantas_tgl_kejadian','sep_laka_lantas_ket','sep_laka_lantas_prov_kode','sep_laka_lantas_kab_kode','sep_laka_lantas_kec_kode'], 'required','on'=>['create_laka'],'message'=>'{attribute} harus diisi'],
            [['sep_pasien_kode','sep_no_rujukan','sep_tgl_sep','sep_tgl_rujukan', 'sep_asal_rujukan_kode', 'sep_jenis_pelayanan','sep_asal_rujukan_tingkat','sep_diagnosa_kode','sep_dpjp_kode'], 'required','on'=>['create_ri'],'message'=>'{attribute} harus diisi'],
            [['sep_no_sep','sep_tgl_checkout_sep'], 'required','on'=>'checkout_sep','message'=>'{attribute} harus diisi'],
            
            [['sep_tgl_rujukan', 'sep_tgl_sep','sep_tgl_checkout_sep', 'sep_laka_lantas_tgl_kejadian', 'sep_created_at', 'sep_updated_at', 'sep_deleted_at'], 'safe'],
            [['sep_asal_rujukan_tingkat', 'sep_jenis_pelayanan', 'sep_hak_kelas', 'sep_is_kontrol_post_ri', 'sep_is_poli_eksekutif', 'sep_is_bridging', 'sep_is_cob', 'sep_is_katarak', 'sep_is_duplikat', 'sep_is_laka_lantas', 'sep_laka_lantas_suplesi', 'sep_created_by', 'sep_updated_by', 'sep_deleted_by','sep_kelas_rawat_status'], 'integer'],
            [['sep_laka_lantas_ket','sep_kelas_rawat','sep_laka_lantas_prov_kode','sep_laka_lantas_kab_kode', 'sep_laka_lantas_kec_kode', 'sep_diagnosa_kode'], 'string'],
            [['sep_reg_kode', 'sep_pasien_kode', 'sep_asal_rujukan_kode', 'sep_poli_kode', 'sep_dpjp_kode'], 'string', 'max' => 100],
            [['sep_no_sep', 'sep_no_rujukan', 'sep_no_kartu', 'sep_no_telp'], 'string', 'max' => 50],
            [['sep_asal_rujukan_nama', 'sep_poli_nama', 'sep_diagnosa_nama', 'sep_dpjp_nama', 'sep_skdp_no_surat', 'sep_catatan', 'sep_laka_lantas_no_suplesi', 'sep_laka_lantas_prov_nama', 'sep_laka_lantas_kab_nama', 'sep_laka_lantas_kec_nama','sep_penanggung_jawab'], 'string', 'max' => 255],
            [['sep_jenis_pembiayaan','sep_tujuan_kunjungan','sep_penunjang_kode','sep_flag_prosedur','sep_ases_pelayanan'],'string','max'=>1],
        ];
    }
    public function attributeLabels()
    {
        return [
            'sep_id' => 'ID',
            'sep_reg_kode' => 'No. Registrasi',
            'sep_pasien_kode' => 'No. Rekam Medis',
            'sep_no_sep' => 'No. Sep',
            'sep_no_rujukan' => 'No. Rujukan',
            'sep_no_kartu' => 'No. Kartu',
            'sep_tgl_rujukan' => 'Tgl. Rujukan',
            'sep_tgl_sep' => 'Tgl. Sep',
            'sep_tgl_checkout_sep'=>'Tgl. Checkout SEP',
            'sep_asal_rujukan_kode' => 'Asal Rujukan',
            'sep_asal_rujukan_nama' => 'Sep Asal Rujukan Nama',
            'sep_asal_rujukan_tingkat' => 'Tingkat Faskes',
            'sep_jenis_pelayanan' => 'Jenis Pelayanan',
            'sep_hak_kelas' => 'Hak Kelas',
            'sep_kelas_rawat' => 'Naik Kelas Rawat',
            'sep_jenis_pembiayaan'=>'Jenis Pembiayaan',
            'sep_penanggung_jawab'=>'Penanggung Jawab',
            'sep_poli_kode' => 'Poliklinik',
            'sep_poli_nama' => 'Nama Poliklinik',
            'sep_diagnosa_kode' => 'Diagnosa',
            'sep_diagnosa_nama' => 'Nama Diagnosa',
            'sep_dpjp_kode' => 'Nama DPJP',
            'sep_dpjp_nama' => 'Nama Dpjp',
            'sep_skdp_no_surat' => 'SPRI/No. Surat Kontrol',
            'sep_no_telp' => 'No. Telp',
            'sep_catatan' => 'Catatan',
            'sep_is_kontrol_post_ri' => 'Kontrol Post Rawatinap ?',
            'sep_is_poli_eksekutif' => 'Poli Eksekutif ?',
            'sep_is_bridging' => 'Sep Is Bridging',
            'sep_is_cob' => 'Peserta Cob ?',
            'sep_is_katarak' => 'Peserta Katarak',
            'sep_tujuan_kunjungan'=>'Tujuan Kunjungan',
            'sep_flag_prosedur'=>'Flag Prosedur',
            'sep_penunjang_kode'=>'Penunjang',
            'sep_ases_pelayanan'=>'Asesmen Pelayanan',
            'sep_is_duplikat' => 'Sep Is Duplikat',
            'sep_is_laka_lantas' => 'Peserta Laka Lantas ?',
            'sep_laka_lantas_tgl_kejadian' => 'Tgl. Kejadian Laka Lantas',
            'sep_laka_lantas_ket' => 'Keterangan',
            'sep_laka_lantas_suplesi' => 'Peserta Suplesi ?',
            'sep_laka_lantas_no_suplesi' => 'No. Suplesi',
            'sep_laka_lantas_prov_kode' => 'Provinsi',
            'sep_laka_lantas_prov_nama' => 'Sep Laka Lantas Prov Nama',
            'sep_laka_lantas_kab_kode' => 'Kabupaten',
            'sep_laka_lantas_kab_nama' => 'Sep Laka Lantas Kab Nama',
            'sep_laka_lantas_kec_kode' => 'Kecamatan',
            'sep_laka_lantas_kec_nama' => 'Sep Laka Lantas Kec Nama',
            'sep_created_at' => 'Sep Created At',
            'sep_created_by' => 'Sep Created By',
            'sep_updated_at' => 'Sep Updated At',
            'sep_updated_by' => 'Sep Updated By',
            'sep_deleted_at' => 'Sep Deleted At',
            'sep_deleted_by' => 'Sep Deleted By',
        ];
    }
    public static function find()
    {
        return (new BaseQuery(get_called_class()))->setPrefix(self::prefix);
    }
    function attr()
    {
        $data=[];
        foreach($this->attributeLabels() as $key => $val){
            $data[$val]=$this->{$key};
        }
        return $data;
    }
    public function getRegistrasi()
    {
        return $this->hasOne(Registrasi::class, ['reg_kode' => 'sep_reg_kode']);
    }
    function insertSep()
    {
        if(!empty($this->reg_data->reg_no_sep)){
            $sep = Sep::find()->where(['sep_pasien_kode'=>$this->reg_data->reg_pasien_kode,'sep_no_sep'=>$this->reg_data->reg_no_sep])->limit(1)->one();
            if($sep!=NULL){ //jika sep tersimpan, update noreg
                $sep->sep_reg_kode=$this->reg_data->reg_kode;
                if(!$sep->save(false)){
                    return false;
                }
                $this->sep_data=$sep;
            }else{ //if no. sep using non bridging, get data from bpjs
                $count=Sep::find()->where(['sep_no_sep'=>$this->reg_data->reg_no_sep])->count();
                $duplikat=0;
                if($count>0){
                    $duplikat=1;
                }

                $br = new BpjsApi();
                $sep=$br->run([
                    'url'=>'sep/search',
                    'params'=>[
                        'no_sep'=>$this->reg_data->reg_no_sep
                    ]
                ]);
                if($sep){
                    if($sep->status){
                        $ds=$sep->data;
                        $data=[
                            'sep_reg_kode' =>$this->reg_data->reg_kode,
                            'sep_pasien_kode' =>$this->reg_data->reg_pasien_kode,
                            'sep_no_sep' => $ds->no_sep,
                            'sep_no_rujukan'=>$ds->no_rujukan,
                            'sep_no_kartu'=>$ds->no_kartu,
                            'sep_tgl_rujukan'=>$ds->tgl_rujukan!=NULL ? date('Y-m-d H:i:s',strtotime($ds->tgl_rujukan)) : NULL,
                            'sep_tgl_sep'=>$ds->tgl_sep!=NULL ? date('Y-m-d H:i:s',strtotime($ds->tgl_sep)) : NULL,
                            'sep_asal_rujukan_kode'=>$ds->asal_rujukan!=NULL ? explode('!#!',$ds->asal_rujukan->id)[0] : NULL,
                            'sep_asal_rujukan_nama'=>$ds->asal_rujukan!=NULL ? $ds->asal_rujukan->nama : NULL,
                            'sep_asal_rujukan_tingkat'=>$ds->asal_rujukan!=NULL ? $ds->asal_rujukan->tingkat : NULL,
                            'sep_jenis_pelayanan'=>$ds->jenis_layanan,
                            'sep_hak_kelas'=>$ds->kelas!=NULL ? explode('!#!',$ds->kelas->id)[0] : NULL,
                            'sep_kelas_rawat'=>$ds->kelas_rawat!=NULL ? explode('!#!',$ds->kelas_rawat->id)[0] : NULL,
                            'sep_kelas_rawat_status'=>0,
                            'sep_jenis_pembiayaan'=>$ds->pembiayaan,
                            'sep_penanggung_jawab'=>$ds->penanggung_jawab,
                            'sep_poli_kode'=>$ds->poliklinik!=NULL ? explode('!#!',$ds->poliklinik->id)[0] : NULL,
                            'sep_poli_nama'=>$ds->poliklinik!=NULL ? $ds->poliklinik->nama : NULL,
                            'sep_simrs_poli_kode'=>'',
                            'sep_diagnosa_kode'=>$ds->diagnosa!=NULL ? explode('!#!',$ds->diagnosa->id)[0] : NULL,
                            'sep_diagnosa_nama'=>$ds->diagnosa!=NULL ? $ds->diagnosa->nama : NULL,
                            'sep_dpjp_kode'=>$ds->dpjp!=NULL ? explode('!#!',$ds->dpjp->id)[0] : NULL,
                            'sep_dpjp_nama'=>$ds->dpjp!=NULL ? $ds->dpjp->nama : NULL,
                            'sep_simrs_dpjp_kode'=>'',
                            'sep_skdp_no_surat'=>$ds->no_surat_kontrol,
                            'sep_no_telp'=>$ds->no_telp,
                            'sep_catatan'=>$ds->catatan,
                            'sep_is_kontrol_post_ri'=>$ds->post_ri,
                            'sep_is_poli_eksekutif'=>$ds->poli_eksekutif,
                            'sep_is_bridging'=>0,
                            'sep_is_cob'=>$ds->cob,
                            'sep_is_katarak'=>$ds->katarak,
                            'sep_tujuan_kunjungan'=>$ds->tujuan_kunjungan,
                            'sep_flag_prosedur'=>$ds->flag_prosedur,
                            'sep_penunjang_kode'=>$ds->penunjang,
                            'sep_simrs_penunjang_kode'=>'',
                            'sep_ases_pelayanan'=>$ds->ases_pelayanan,
                            'sep_created_by'=>AuthUser::user()->id,
                            'sep_created_at'=>date('Y-m-d H:i:s'),
                            'sep_is_duplikat'=>$duplikat
                        ];

                        if($ds->laka_lantas!=NULL){
                            $prov=$ds->laka_lantas->provinsi!=NULL ? explode('!#!',$ds->laka_lantas->provinsi) : NULL;
                            $kab=$ds->laka_lantas->kabupaten!=NULL ? explode('!#!',$ds->laka_lantas->kabupaten) : NULL;
                            $kec=$ds->laka_lantas->kecamatan!=NULL ? explode('!#!',$ds->laka_lantas->kecamatan) : NULL;

                            $data['sep_is_laka_lantas']=$ds->laka_lantas->status;
                            $data['sep_laka_lantas_penjamin']=$ds->laka_lantas->penjamin;
                            $data['sep_laka_lantas_tgl_kejadian']=$ds->laka_lantas->tgl_kejadian!=NULL ? date('Y-m-d',strtotime($ds->laka_lantas->tgl_kejadian)) : NULL;
                            $data['sep_laka_lantas_ket']=$ds->laka_lantas->ket;

                            $data['sep_laka_lantas_prov_kode']=$prov!=NULL ? $prov[0] : NULL;
                            $data['sep_laka_lantas_prov_nama']=$prov!=NULL ? $prov[1] : NULL;

                            $data['sep_laka_lantas_kab_kode']=$kab!=NULL ? $kab[0] : NULL;
                            $data['sep_laka_lantas_kab_nama']=$kab!=NULL ? $kab[1] : NULL;

                            $data['sep_laka_lantas_kec_kode']=$kec!=NULL ? $kec[0] : NULL;
                            $data['sep_laka_lantas_kec_nama']=$kec!=NULL ? $kec[1] : NULL;
                        }
                    }
                }
                Yii::$app->db->createCommand()->insert(self::tableName(), $data)->execute();
            }
        }
        return true;
    }
}