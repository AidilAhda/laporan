<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pendaftaran_m_debitur_detail".
 *
 * @property string $pmdd_kode
 * @property string $pmdd_pmd_kode PK pendaftaran_m_debitur
 * @property string $pmdd_nama
 * @property int $pmdd_aktif
 * @property string $pmdd_created_at
 * @property int $pmdd_created_by
 * @property string|null $pmdd_updated_at
 * @property int|null $pmdd_updated_by
 * @property string|null $pmdd_deleted_at
 * @property int|null $pmdd_deleted_by
 */
class PendaftaranMDebiturDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    static $prefix="pmdd";
    public static function tableName()
    {
        return 'pendaftaran_m_debitur_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pmdd_kode', 'pmdd_pmd_kode', 'pmdd_nama', 'pmdd_aktif', 'pmdd_created_by'], 'required'],
            [['pmdd_aktif', 'pmdd_created_by', 'pmdd_updated_by', 'pmdd_deleted_by'], 'integer'],
            [['pmdd_created_at', 'pmdd_updated_at', 'pmdd_deleted_at'], 'safe'],
            [['pmdd_kode', 'pmdd_pmd_kode'], 'string', 'max' => 10],
            [['pmdd_nama'], 'string', 'max' => 255],
            [['pmdd_kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pmdd_kode' => 'Pmdd Kode',
            'pmdd_pmd_kode' => 'Pmdd Pmd Kode',
            'pmdd_nama' => 'Pmdd Nama',
            'pmdd_aktif' => 'Pmdd Aktif',
            'pmdd_created_at' => 'Pmdd Created At',
            'pmdd_created_by' => 'Pmdd Created By',
            'pmdd_updated_at' => 'Pmdd Updated At',
            'pmdd_updated_by' => 'Pmdd Updated By',
            'pmdd_deleted_at' => 'Pmdd Deleted At',
            'pmdd_deleted_by' => 'Pmdd Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PendaftaranMDebiturDetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PendaftaranMDebiturDetailQuery(get_called_class());
    }
     function getDebitur()
    {
        return $this->hasOne(PendaftaranMDebitur::className(),['pmd_kode'=>'pmdd_pmd_kode']);
    }
    static function all($kode=NULL)
    {
        $query= self::find();
        if($kode!=NULL){
            if(is_array($kode)){
                $query->where(['in','pmdd_kode',$kode]);
            }else{
                $query->where(['pmdd_pmd_kode'=>$kode]);
            }
        }else{
            $query->where(['not in','pmdd_kode',['1012']]);
        }
        return $query->select('pmdd_kode as kode,pmdd_nama as nama,pmdd_pmd_kode as debitur')->active(self::$prefix)->notDeleted(self::$prefix)->asArray()->all();
    }
    static function allWithoutUmum()
    {
        $query= self::find();
        $query->where(['not in','pmdd_kode',['1001']]);
        return $query->select('pmdd_kode as kode,pmdd_nama as nama,pmdd_pmd_kode as debitur')->active(self::$prefix)->notDeleted(self::$prefix)->asArray()->all();
    }
    public static function getListDebitur()
    {
            $debitur_detail_tmp=PendaftaranMDebiturDetail::all();
            $debitur_detail=[];
            if(count($debitur_detail_tmp)>0){
                foreach($debitur_detail_tmp as $ddt){
                    $debitur_detail[]=['id'=>$ddt['kode'],'nama'=>$ddt['nama']];
                }
            }

            return $debitur_detail;
    }
     public static function getListDebiturNotUmum()
    {
            $debitur_detail_tmp=PendaftaranMDebiturDetail::allWithoutUmum();
            $debitur_detail=[];
            if(count($debitur_detail_tmp)>0){
                foreach($debitur_detail_tmp as $ddt){
                    $debitur_detail[]=['id'=>$ddt['kode'],'nama'=>$ddt['nama']];
                }
            }

            return $debitur_detail;
    }
}
