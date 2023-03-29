<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ebs_penelitian".
 *
 * @property string $tlt_id id penelitian
 * @property string $tlt_tgl
 * @property string $tlt_nama
 * @property string|null $tlt_instansi_asal
 * @property float $tlt_biaya
 * @property string|null $tlt_tujuan
 * @property string|null $tlt_keterangan
 * @property string|null $tlt_created_at
 * @property int|null $tlt_created_by
 * @property string|null $tlt_updated_at
 * @property int|null $tlt_updated_by
 * @property string|null $tlt_deleted_at
 * @property int|null $tlt_deleted_by
 */
class EbsPenelitian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ebs_penelitian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tlt_id', 'tlt_tgl', 'tlt_nama', 'tlt_biaya'], 'required'],
            [['tlt_tgl', 'tlt_created_at', 'tlt_updated_at', 'tlt_deleted_at'], 'safe'],
            [['tlt_biaya'], 'number'],
            [['tlt_created_by', 'tlt_updated_by', 'tlt_deleted_by'], 'integer'],
            [['tlt_id'], 'string', 'max' => 12],
            [['tlt_nama', 'tlt_instansi_asal'], 'string', 'max' => 100],
            [['tlt_tujuan'], 'string', 'max' => 200],
            [['tlt_keterangan'], 'string', 'max' => 250],
            [['tlt_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tlt_id' => 'ID',
            'tlt_tgl' => 'Tanggal',
            'tlt_nama' => 'Nama',
            'tlt_instansi_asal' => 'Instansi Asal',
            'tlt_biaya' => 'Biaya',
            'tlt_tujuan' => 'Tujuan',
            'tlt_keterangan' => 'Keterangan',
            'tlt_created_at' => 'Created At',
            'tlt_created_by' => 'Created By',
            'tlt_updated_at' => 'Updated At',
            'tlt_updated_by' => 'Updated By',
            'tlt_deleted_at' => 'Deleted At',
            'tlt_deleted_by' => 'Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return EbsPenelitianQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EbsPenelitianQuery(get_called_class());
    }

    function generateNoPenelitian()
    {
        $nopenelitian=NULL;
        $check=false;
        while(!$check){

            $max=self::find()->where("tlt_id like '".date('Ymd')."%' ")->max('tlt_id');

            $max=$max==NULL ? 0 : $max;
            $nopenelitian=date('Ymd').sprintf('%0'.Yii::$app->params['nopenelitian']['length'].'d',substr($max,-4)+1);

            $count_check=self::find()->where(["tlt_id"=>$nopenelitian])->asArray()->limit(1)->one();
            if($count_check==NULL){
                $check=true;
            }
        }
        return $nopenelitian;
    }   

    public static function dataPenelitian()
    {
        $Data = EbsPenelitian::find()
        ->andWhere('tlt_deleted_at is null')->orderBy(['tlt_created_at'=>SORT_DESC])
        ->asArray()->all();

        $Jumlah = count($Data);

        return array('Data'=>$Data, 'Jumlah'=>$Jumlah);
    }
}
