<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ebs_parkir".
 *
 * @property int $prkr_id id pendapatan parkir
 * @property string $prkr_tgl
 * @property float $prkr_roda2_pagi
 * @property int $prkr_roda2_pagi_petugas
 * @property float $prkr_roda3_pagi
 * @property int $prkr_roda3_pagi_petugas
 * @property float $prkr_roda4_pagi
 * @property int $prkr_roda4_pagi_petugas
 * @property float $prkr_roda2_siang
 * @property int $prkr_roda2_siang_petugas
 * @property float $prkr_roda3_siang
 * @property int $prkr_roda3_siang_petugas
 * @property float $prkr_roda4_siang
 * @property int $prkr_roda4_siang_petugas
 * @property float $prkr_roda2_malam
 * @property int $prkr_roda2_malam_petugas
 * @property float $prkr_roda3_malam
 * @property int $prkr_roda3_malam_petugas
 * @property float $prkr_roda4_malam
 * @property int $prkr_roda4_malam_petugas
 * @property float $prkr_jumlah
 * @property int $prkr_kepala_unit
 * @property int $prkr_petugas_setor
 * @property string|null $prkr_keterangan
 * @property string|null $prkr_created_at
 * @property int|null $prkr_created_by
 * @property string|null $prkr_updated_at
 * @property int|null $prkr_updated_by
 * @property string|null $prkr_deleted_at
 * @property int|null $prkr_deleted_by
 */
class EbsParkir extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ebs_parkir';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prkr_tgl', 'prkr_roda2_pagi_petugas', 'prkr_roda3_pagi_petugas', 'prkr_roda4_pagi_petugas', 'prkr_roda2_siang_petugas', 'prkr_roda3_siang_petugas', 'prkr_roda4_siang_petugas', 'prkr_roda2_malam_petugas', 'prkr_roda3_malam_petugas', 'prkr_roda4_malam_petugas', 'prkr_jumlah', 'prkr_kepala_unit', 'prkr_petugas_setor'], 'required'],
            [['prkr_tgl', 'prkr_created_at', 'prkr_updated_at', 'prkr_deleted_at'], 'safe'],
            [['prkr_roda2_pagi', 'prkr_roda3_pagi', 'prkr_roda4_pagi', 'prkr_roda2_siang', 'prkr_roda3_siang', 'prkr_roda4_siang', 'prkr_roda2_malam', 'prkr_roda3_malam', 'prkr_roda4_malam', 'prkr_jumlah'], 'number'],
            [['prkr_roda2_pagi_petugas', 'prkr_roda3_pagi_petugas', 'prkr_roda4_pagi_petugas', 'prkr_roda2_siang_petugas', 'prkr_roda3_siang_petugas', 'prkr_roda4_siang_petugas', 'prkr_roda2_malam_petugas', 'prkr_roda3_malam_petugas', 'prkr_roda4_malam_petugas', 'prkr_kepala_unit', 'prkr_petugas_setor', 'prkr_created_by', 'prkr_updated_by', 'prkr_deleted_by'], 'integer'],
            [['prkr_keterangan'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'prkr_id' => 'ID',
            'prkr_tgl' => 'Tgl',
            'prkr_roda2_pagi' => 'Roda2 Pagi',
            'prkr_roda2_pagi_petugas' => 'Roda2 Pagi Petugas',
            'prkr_roda3_pagi' => 'Roda3 Pagi',
            'prkr_roda3_pagi_petugas' => 'Roda3 Pagi Petugas',
            'prkr_roda4_pagi' => 'Roda4 Pagi',
            'prkr_roda4_pagi_petugas' => 'Roda4 Pagi Petugas',
            'prkr_roda2_siang' => 'Roda2 Siang',
            'prkr_roda2_siang_petugas' => 'Roda2 Siang Petugas',
            'prkr_roda3_siang' => 'Roda3 Siang',
            'prkr_roda3_siang_petugas' => 'Roda3 Siang Petugas',
            'prkr_roda4_siang' => 'Roda4 Siang',
            'prkr_roda4_siang_petugas' => 'Roda4 Siang Petugas',
            'prkr_roda2_malam' => 'Roda2 Malam',
            'prkr_roda2_malam_petugas' => 'Roda2 Malam Petugas',
            'prkr_roda3_malam' => 'Roda3 Malam',
            'prkr_roda3_malam_petugas' => 'Roda3 Malam Petugas',
            'prkr_roda4_malam' => 'Roda4 Malam',
            'prkr_roda4_malam_petugas' => 'Roda4 Malam Petugas',
            'prkr_jumlah' => 'Jumlah',
            'prkr_kepala_unit' => 'Kepala Unit',
            'prkr_petugas_setor' => 'Petugas Setor',
            'prkr_keterangan' => 'Keterangan',
            'prkr_created_at' => 'Created At',
            'prkr_created_by' => 'Created By',
            'prkr_updated_at' => 'Updated At',
            'prkr_updated_by' => 'Updated By',
            'prkr_deleted_at' => 'Deleted At',
            'prkr_deleted_by' => 'Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return EbsParkirQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EbsParkirQuery(get_called_class());
    }
    function getKepalaunit()
    {
        return $this->hasOne(EbsPetugasParkir::className(),['pprkr_id'=>'prkr_kepala_unit']);
    }
    function getPetugassetor()
    {
        return $this->hasOne(EbsPetugasParkir::className(),['pprkr_id'=>'prkr_petugas_setor']);
    }
    function getKasir()
    {
        return $this->hasOne(SdmMPegawai::className(),['pgw_id'=>'prkr_created_by']);
    }
    public static function dataParkir()
    {
        $Data = EbsParkir::find()
        ->andWhere('prkr_deleted_at is null')->orderBy(['prkr_created_at'=>SORT_DESC])
        ->asArray()->all();

        $Jumlah = count($Data);

        return array('Data'=>$Data, 'Jumlah'=>$Jumlah);
    }
}
