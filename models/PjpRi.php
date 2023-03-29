<?php

namespace app\models;

use Yii;
use app\models\SdmMPegawai;
use app\models\PendaftaranRegistrasi;
use app\models\other\BaseQuery;
use app\models\other\TrimBehavior;
use app\components\Akun;
/**
 * This is the model class for table "medis_pjp_ri".
 *
 * @property int $pjpri_id
 * @property string $pjpri_reg_kode PK pendaftaran_registrasi
 * @property int $pjpri_pgw_id PK sdm_m_pegawai
 * @property int $pjpri_status default 0, jika 1 => dokter utama,2 => dokter pendukung
 * @property string $pjpri_tgl_mulai
 * @property string|null $pjpri_tgl_akhir
 * @property string|null $pjpri_ket
 * @property string $pjpri_created_at
 * @property int $pjpri_created_by
 * @property string|null $pjpri_updated_at
 * @property int|null $pjpri_updated_by
 * @property string|null $pjpri_deleted_at
 * @property int|null $pjpri_deleted_by
 */
class PjpRi extends \yii\db\ActiveRecord
{
    public $error_msg,$model_data;
    const DPJP_UTAMA = 1;
    const DPJP_PENDUKUNG = 2;

    const prefix='pjpri';
    const alias='pjpri';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis_pjp_ri';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pjpri_reg_kode', 'pjpri_pgw_id', 'pjpri_status','pjpri_tgl_mulai'], 'required'],
            [['pjpri_pgw_id', 'pjpri_status', 'pjpri_created_by', 'pjpri_updated_by', 'pjpri_deleted_by'], 'integer'],
            [['pjpri_tgl_mulai', 'pjpri_tgl_akhir', 'pjpri_created_at', 'pjpri_updated_at', 'pjpri_deleted_at'], 'safe'],
            [['pjpri_ket'], 'string'],
            [['pjpri_reg_kode'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pjpri_id' => 'Pjpri ID',
            'pjpri_reg_kode' => 'Pjpri Reg Kode',
            'pjpri_pgw_id' => 'Dokter',
            'pjpri_status' => 'DPJP',
            'pjpri_tgl_mulai' => 'Tgl.Mulai',
            'pjpri_tgl_akhir' => 'Tgl.Akhir',
            'pjpri_ket' => 'Ket',
            'pjpri_created_at' => 'Pjpri Created At',
            'pjpri_created_by' => 'Pjpri Created By',
            'pjpri_updated_at' => 'Pjpri Updated At',
            'pjpri_updated_by' => 'Pjpri Updated By',
            'pjpri_deleted_at' => 'Pjpri Deleted At',
            'pjpri_deleted_by' => 'Pjpri Deleted By',
        ];
    }

    function beforeSave($model)
    {
        if($this->isNewRecord){
            $this->pjpri_created_by=Akun::user()->id;
            $this->pjpri_created_at=date('Y-m-d H:i:s');
        }else{
            $this->pjpri_updated_by=Akun::user()->id;
            $this->pjpri_updated_at=date('Y-m-d H:i:s');
        }
        return parent::beforeSave($model);
    }
    function setDelete(){
        $this->pjpri_deleted_at=date('Y-m-d H:i:s');
        $this->pjpri_deleted_by=Akun::user()->id;
    }
    function getPegawai()
    {
        return $this->hasOne(SdmMPegawai::className(),['pgw_id'=>'pjpri_pgw_id']);
    }
    function getRegistrasi()
    {
        return $this->hasOne(PendaftaranRegistrasi::className(),['reg_kode'=>'pjpri_reg_kode']);
    }
}
