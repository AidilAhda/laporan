<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ebs_petugas_parkir".
 *
 * @property int $pprkr_id id petugas parkir
 * @property string|null $pprkr_noidentitas
 * @property string $pprkr_nama
 * @property string $pprkr_tgl_lahir
 * @property string $pprkr_jenis_kelamin p/l
 * @property string $pprkr_alamat
 * @property string $pprkr_nohp
 * @property int $pprkr_jabatan 1 => kepala parkir, 2 => petugas parkir
 * @property int $pprkr_status 1 => aktif 0 => Tidak Aktif	
 * @property string|null $pprkr_created_at
 * @property int|null $pprkr_created_by
 * @property string|null $pprkr_updated_at
 * @property int|null $pprkr_updated_by
 * @property string|null $pprkr_deleted_at
 * @property int|null $pprkr_deleted_by
 */
class EbsPetugasParkir extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ebs_petugas_parkir';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pprkr_nama', 'pprkr_tgl_lahir', 'pprkr_jenis_kelamin', 'pprkr_alamat', 'pprkr_nohp'], 'required'],
            [['pprkr_tgl_lahir', 'pprkr_created_at', 'pprkr_updated_at', 'pprkr_deleted_at'], 'safe'],
            [['pprkr_jabatan', 'pprkr_status', 'pprkr_created_by', 'pprkr_updated_by', 'pprkr_deleted_by'], 'integer'],
            [['pprkr_noidentitas'], 'string', 'max' => 20],
            [['pprkr_nama'], 'string', 'max' => 100],
            [['pprkr_jenis_kelamin'], 'string', 'max' => 1],
            [['pprkr_alamat'], 'string', 'max' => 255],
            [['pprkr_nohp'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pprkr_id' => 'ID',
            'pprkr_noidentitas' => 'No Identitas',
            'pprkr_nama' => 'Nama',
            'pprkr_tgl_lahir' => 'Tanggal Lahir',
            'pprkr_jenis_kelamin' => 'Jenis Kelamin',
            'pprkr_alamat' => 'Alamat',
            'pprkr_nohp' => 'Nohp',
            'pprkr_jabatan' => 'Jabatan',
            'pprkr_status' => 'Status',
            'pprkr_created_at' => 'Created At',
            'pprkr_created_by' => 'Created By',
            'pprkr_updated_at' => 'Updated At',
            'pprkr_updated_by' => 'Updated By',
            'pprkr_deleted_at' => 'Deleted At',
            'pprkr_deleted_by' => 'Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return EbsPetugasParkirQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EbsPetugasParkirQuery(get_called_class());
    }

    public static function dataPetugas()
    {
        $Data = EbsPetugasParkir::find()
        ->andWhere('pprkr_deleted_at is null')->orderBy(['pprkr_created_at'=>SORT_DESC])
        ->asArray()->all();

        $Jumlah = count($Data);

        return array('Data'=>$Data, 'Jumlah'=>$Jumlah);
    }

    public static function getListPetugas($kodeJabatan)
    {
            $petugas_tmp=EbsPetugasParkir::find()
            ->andWhere(['pprkr_jabatan'=>$kodeJabatan, 'pprkr_status'=>1])
            ->andWhere('pprkr_deleted_at is null')->asArray()->all();

            $petugas_detail=[];
            if(count($petugas_tmp)>0){
                foreach($petugas_tmp as $ddt){
                    $petugas_detail[]=['id'=>$ddt['pprkr_id'],'nama'=>$ddt['pprkr_nama']];
                }
            }

            return $petugas_detail;
    }
}
