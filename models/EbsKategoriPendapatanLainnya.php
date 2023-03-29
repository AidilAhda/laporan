<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ebs_kategori_pendapatan_lainnya".
 *
 * @property int $katpen_id id kategori pendapatan lain
 * @property string $katpen_nama Nama Kategori Pendapatan Lain
 * @property int $katpen_aktif 1 => Aktif 0 => Tidak Aktif	
 * @property string|null $katpen_keterangan
 * @property string|null $katpen_created_at
 * @property int|null $katpen_created_by
 * @property string|null $katpen_updated_at
 * @property int|null $katpen_updated_by
 * @property string|null $katpen_deleted_at
 * @property int|null $katpen_deleted_by
 */
class EbsKategoriPendapatanLainnya extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ebs_kategori_pendapatan_lainnya';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['katpen_nama', 'katpen_aktif'], 'required'],
            [['katpen_aktif', 'katpen_created_by', 'katpen_updated_by', 'katpen_deleted_by'], 'integer'],
            [['katpen_keterangan'], 'string'],
            [['katpen_created_at', 'katpen_updated_at', 'katpen_deleted_at'], 'safe'],
            [['katpen_nama'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'katpen_id' => 'Katpen ID',
            'katpen_nama' => 'Katpen Nama',
            'katpen_aktif' => 'Katpen Aktif',
            'katpen_keterangan' => 'Katpen Keterangan',
            'katpen_created_at' => 'Katpen Created At',
            'katpen_created_by' => 'Katpen Created By',
            'katpen_updated_at' => 'Katpen Updated At',
            'katpen_updated_by' => 'Katpen Updated By',
            'katpen_deleted_at' => 'Katpen Deleted At',
            'katpen_deleted_by' => 'Katpen Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return EbsKategoriPendapatanLainnyaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EbsKategoriPendapatanLainnyaQuery(get_called_class());
    }

    public static function dataKategori()
    {
        $Data = EbsKategoriPendapatanLainnya::find()
        ->andWhere('katpen_deleted_at is null')->orderBy(['katpen_created_at'=>SORT_DESC])
        ->asArray()->all();

        $Jumlah = count($Data);

        return array('Data'=>$Data, 'Jumlah'=>$Jumlah);
    }

    public static function getListKategoriPendapatan()
    {
            $DataKategoriPendapatan = EbsKategoriPendapatanLainnya::find()
            ->select(['katpen_id', 'katpen_nama'])->andWhere(['katpen_aktif'=>1])
            ->andWhere('katpen_deleted_at is null')->asArray()->all();

            $kategori=[];
            if($DataKategoriPendapatan != null){
                foreach($DataKategoriPendapatan as $dt){
                    $kategori[]=['id'=>$dt['katpen_id'],'nama'=>$dt['katpen_nama']];
                }
            }

            return $kategori;
    }
}
