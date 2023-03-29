<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ebs_supir_ambulance".
 *
 * @property int $spnce_id id supir ambulance
 * @property string|null $spnce_no_identitas
 * @property string $spnce_nama
 * @property string $spnce_tgl_lahir
 * @property string $spnce_alamat
 * @property string $spnce_no_hp
 * @property int $spnce_status 1 => aktif 0 => Tidak Aktif    
 * @property string|null $spnce_created_at
 * @property int|null $spnce_created_by
 * @property string|null $spnce_updated_at
 * @property int|null $spnce_updated_by
 * @property string|null $spnce_deleted_at
 * @property int|null $spnce_deleted_by
 */
class EbsSupirAmbulance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ebs_supir_ambulance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['spnce_nama', 'spnce_tgl_lahir', 'spnce_alamat', 'spnce_no_hp'], 'required'],
            [['spnce_tgl_lahir', 'spnce_created_at', 'spnce_updated_at', 'spnce_deleted_at'], 'safe'],
            [['spnce_status', 'spnce_created_by', 'spnce_updated_by', 'spnce_deleted_by'], 'integer'],
            [['spnce_no_identitas'], 'string', 'max' => 20],
            [['spnce_nama', 'spnce_no_hp'], 'string', 'max' => 100],
            [['spnce_alamat'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'spnce_id' => 'ID',
            'spnce_no_identitas' => 'No Identitas',
            'spnce_nama' => 'Nama',
            'spnce_tgl_lahir' => 'Tanggal Lahir',
            'spnce_alamat' => 'Alamat',
            'spnce_no_hp' => 'No Hp',
            'spnce_status' => 'Status',
            'spnce_created_at' => 'Created At',
            'spnce_created_by' => 'Created By',
            'spnce_updated_at' => 'Updated At',
            'spnce_updated_by' => 'Updated By',
            'spnce_deleted_at' => 'Deleted At',
            'spnce_deleted_by' => 'Deleted By',
        ];
    }
    /**
     * {@inheritdoc}
     * @return EbsSupirAmbulanceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EbsSupirAmbulanceQuery(get_called_class());
    }


    public static function dataSupir()
    {
        $Data = EbsSupirAmbulance::find()
        ->andWhere('spnce_deleted_at is null')->orderBy(['spnce_created_at'=>SORT_DESC])
        ->asArray()->all();

        $Jumlah = count($Data);

        return array('Data'=>$Data, 'Jumlah'=>$Jumlah);
    }

    public static function getListSupir()
    {
            $supir_tmp=EbsSupirAmbulance::find()
			->andWhere(['spnce_status'=>1])
            ->andWhere('spnce_deleted_at is null')->asArray()->all();
            $supir_detail=[];
            if(count($supir_tmp)>0){
                foreach($supir_tmp as $ddt){
                    $supir_detail[]=['id'=>$ddt['spnce_id'],'nama'=>$ddt['spnce_nama']];
                }
            }

            return $supir_detail;
    }
}
