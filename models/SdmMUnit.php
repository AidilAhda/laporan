<?php
namespace app\models;
use Yii;
/**
 * This is the model class for table "sdm_m_unit".
 *
 * @property int $unt_id
 * @property int $unt_parent_id
 * @property string $unt_nama
 * @property int $unt_is_igd 0=>Tidak; 1=>Ya
 * @property int $unt_is_rj
 * @property int $unt_is_ri
 * @property int $unt_is_pnjg
 * @property int|null $unt_aktif 1=y,0=n
 * @property string|null $unt_created_at
 * @property int|null $unt_created_by
 * @property string|null $unt_updated_at
 * @property int|null $unt_updated_by
 * @property string|null $unt_deleted_at
 * @property int|null $unt_deleted_by
 */
class SdmMUnit extends \yii\db\ActiveRecord
{
    static $prefix="unt";
    public static function tableName()
    {
        return 'sdm_m_unit';
    }
    public function rules()
    {
        return [
            [['unt_parent_id', 'unt_nama'], 'required'],
            [['unt_parent_id', 'unt_is_igd', 'unt_is_rj', 'unt_is_ri', 'unt_is_pnjg', 'unt_aktif', 'unt_created_by', 'unt_updated_by', 'unt_deleted_by'], 'integer'],
            [['unt_created_at', 'unt_updated_at', 'unt_deleted_at'], 'safe'],
            [['unt_nama'], 'string', 'max' => 100],
        ];
    }
    public function attributeLabels()
    {
        return [
            'unt_id' => 'Unt ID',
            'unt_parent_id' => 'Unt Parent ID',
            'unt_nama' => 'Unt Nama',
            'unt_is_igd' => 'Unt Is Igd',
            'unt_is_rj' => 'Unt Is Rj',
            'unt_is_ri' => 'Unt Is Ri',
            'unt_is_pnjg' => 'Unt Is Pnjg',
            'unt_aktif' => 'Unt Aktif',
            'unt_created_at' => 'Unt Created At',
            'unt_created_by' => 'Unt Created By',
            'unt_updated_at' => 'Unt Updated At',
            'unt_updated_by' => 'Unt Updated By',
            'unt_deleted_at' => 'Unt Deleted At',
            'unt_deleted_by' => 'Unt Deleted By',
        ];
    }
    public static function find()
    {
        return new BaseQuery(get_called_class());
    }
    function getLayanan()
    {
        return $this->hasMany(Layanan::className(),['pl_unit_kode'=>'unt_id']);
    }
    function getKelompokunit()
    {
        return $this->hasMany(PendaftaranMKelompokUnitLayanan::className(),['kul_unit_id'=>'unt_id']);
    }
    static function all($kode=NULL)
    {
        $query= self::find();
        if($kode!=NULL){
            if(is_array($kode)){
                $query->where(['in','unt_id',$kode]);
            }else{
                $query->where(['unt_id'=>$kode]);
            }
        }
        return $query->select('unt_id as id,unt_nama as unit')->active(self::$prefix)->notDeleted(self::$prefix)->asArray()->all();
    }
    static public function getListUnit()
    {
        $data  = self::find()->select('unt_id as id,unt_nama as unit')->andWhere(['unt_aktif'=>1])->andWhere('unt_deleted_at is null')->asArray()->all();
        return $data;   
    }
    static public function getListPenunjang()
    {
        $data  = self::find()->select('unt_id as id,unt_nama as unit')->andWhere(['unt_aktif'=>1, 'unt_is_pnjg'=>1])->andWhere('unt_deleted_at is null')->asArray()->all();
        return $data;   
    }
}
