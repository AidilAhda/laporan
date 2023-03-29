<?php

namespace app\models;

use Yii;
use app\widgets\AuthUser;

/**
 * This is the model class for table "sdm_m_akses_aplikasi".
 *
 * @property int $akp_id
 * @property int $akp_pgw_id
 * @property int $akp_apl_id
 * @property int|null $akp_all_id
 * @property string|null $akp_created_at
 * @property int|null $akp_created_by
 * @property string|null $akp_updated_at
 * @property int|null $akp_updated_by
 * @property string|null $akp_deleted_at
 * @property int|null $akp_deleted_by
 */
class SdmMAksesAplikasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sdm_m_akses_aplikasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['akp_pgw_id', 'akp_apl_id'], 'required'],
            [['akp_pgw_id', 'akp_apl_id', 'akp_all_id', 'akp_created_by', 'akp_updated_by', 'akp_deleted_by'], 'integer'],
            [['akp_created_at', 'akp_updated_at', 'akp_deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'akp_id' => 'Akp ID',
            'akp_pgw_id' => 'Akp Pgw ID',
            'akp_apl_id' => 'Akp Apl ID',
            'akp_all_id' => 'Akp All ID',
            'akp_created_at' => 'Akp Created At',
            'akp_created_by' => 'Akp Created By',
            'akp_updated_at' => 'Akp Updated At',
            'akp_updated_by' => 'Akp Updated By',
            'akp_deleted_at' => 'Akp Deleted At',
            'akp_deleted_by' => 'Akp Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SdmMAksesAplikasiQuery the active query used by this AR class.
     */
     public static function find()
    {
        return new SdmMAksesAplikasiQuery(get_called_class());
    }
	 function getAplikasi()
    {
        return $this->hasOne(SdmMAplikasi::className(),['apl_id'=>'akp_apl_id']);
    }
	function getPegawai()
    {
        return $this->hasOne(SdmMPegawai::className(),['pgw_id'=>'akp_pgw_id']);
    }
    function getAplikasilevel()
    {
        return $this->hasOne(SdmMAplikasiLevel::className(),['all_id'=>'akp_all_id']);
    }
    static function userAkses()
    {
        $data = self::find()->joinWith(['aplikasi','aplikasilevel'],false)->select(['all_nama'])->where(['akp_pgw_id'=>AuthUser::user()->id,'apl_kode'=>Yii::$app->params['app']['id']])->asArray()->all();
        if(count($data)>0){
            return array_column($data,'all_nama');
        }
        return NULL;
    }
	
	public static function getListPengguna($KodeAplikasi)
    {
            $AksesAplikasi = SdmMAksesAplikasi::find()
            ->select(['sdm_m_akses_aplikasi.*', 'sdm_m_pegawai.pgw_nama'])
            ->joinWith(['pegawai'], false)->andWhere(['akp_apl_id'=>$KodeAplikasi, 'akp_aktif'=>1])
            ->andWhere('akp_deleted_at is null')->asArray()->all();

            $pengguna=[];
            if(count($AksesAplikasi)>0){
                foreach($AksesAplikasi as $dt){
                    $pengguna[]=['id'=>$dt['akp_pgw_id'],'nama'=>$dt['pgw_nama']];
                }
            }

            return $pengguna;
    }
}
