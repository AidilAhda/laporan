<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ebs_pendapatan_lainnya".
 *
 * @property string $pdtl_id id pendapatan lain
 * @property int $pdtl_katpen_id FK ebs kategori pendapatan lain
 * @property string $pdtl_tanggal
 * @property string $pdtl_nama
 * @property string|null $pdtl_instansi_asal
 * @property float $pdtl_biaya
 * @property string|null $pdtl_tujuan
 * @property string|null $pdtl_keterangan
 * @property string|null $pdtl_created_at
 * @property int|null $pdtl_created_by
 * @property string|null $pdtl_updated_at
 * @property int|null $pdtl_updated_by
 * @property string|null $pdtl_deleted_at
 * @property int|null $pdtl_deleted_by
 */
class EbsPendapatanLainnya extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ebs_pendapatan_lainnya';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pdtl_id', 'pdtl_katpen_id', 'pdtl_tanggal', 'pdtl_nama'], 'required'],
            [['pdtl_katpen_id', 'pdtl_created_by', 'pdtl_updated_by', 'pdtl_deleted_by'], 'integer'],
            [['pdtl_tanggal', 'pdtl_created_at', 'pdtl_updated_at', 'pdtl_deleted_at'], 'safe'],
            [['pdtl_biaya'], 'number'],
            [['pdtl_id'], 'string', 'max' => 12],
            [['pdtl_nama', 'pdtl_instansi_asal'], 'string', 'max' => 100],
            [['pdtl_tujuan'], 'string', 'max' => 200],
            [['pdtl_keterangan'], 'string', 'max' => 250],
            [['pdtl_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pdtl_id' => 'Pdtl ID',
            'pdtl_katpen_id' => 'Pdtl Katpen ID',
            'pdtl_tanggal' => 'Pdtl Tanggal',
            'pdtl_nama' => 'Pdtl Nama',
            'pdtl_instansi_asal' => 'Pdtl Instansi Asal',
            'pdtl_biaya' => 'Pdtl Biaya',
            'pdtl_tujuan' => 'Pdtl Tujuan',
            'pdtl_keterangan' => 'Pdtl Keterangan',
            'pdtl_created_at' => 'Pdtl Created At',
            'pdtl_created_by' => 'Pdtl Created By',
            'pdtl_updated_at' => 'Pdtl Updated At',
            'pdtl_updated_by' => 'Pdtl Updated By',
            'pdtl_deleted_at' => 'Pdtl Deleted At',
            'pdtl_deleted_by' => 'Pdtl Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return EbsPendapatanLainnyaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EbsPendapatanLainnyaQuery(get_called_class());
    }

    public function getKategori()
    {
        return $this->hasOne(EbsKategoriPendapatanLainnya::className(), ['katpen_id' => 'pdtl_katpen_id']);
    }

    function generateNoPendapatanLainnya()
    {
        $nopendapatanlainnya=NULL;
        $check=false;
        while(!$check){

            $max=self::find()->where("pdtl_id like '".date('Ymd')."%' ")->max('pdtl_id');

            $max=$max==NULL ? 0 : $max;
            $nopendapatanlainnya=date('Ymd').sprintf('%0'.Yii::$app->params['nopendapatanlainnya']['length'].'d',substr($max,-4)+1);

            $count_check=self::find()->where(["pdtl_id"=>$nopendapatanlainnya])->asArray()->limit(1)->one();
            if($count_check==NULL){
                $check=true;
            }
        }
        return $nopendapatanlainnya;
    }   

    public static function dataPendapatanLainnya()
    {
        $Data = EbsPendapatanLainnya::find()
        ->joinWith(['kategori'],true)
        ->andWhere('pdtl_deleted_at is null')->orderBy(['pdtl_created_at'=>SORT_DESC])
        ->asArray()->all();

        $Jumlah = count($Data);

        return array('Data'=>$Data, 'Jumlah'=>$Jumlah);
    }
}
