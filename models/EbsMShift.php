<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ebs_m_shift".
 *
 * @property int $shf_id Shift Id
 * @property string $shf_nama Shift Nama
 * @property int $shf_aktif 1 => aktif 0 => Tidak Aktif
 * @property string $shf_keterangan Keterangan Shift
 * @property string|null $shf_created_at
 * @property int|null $shf_created_by
 * @property string|null $shf_updated_at
 * @property int|null $shf_updated_by
 * @property string|null $shf_deleted_at
 * @property int|null $shf_deleted_by
 */
class EbsMShift extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ebs_m_shift';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shf_nama', 'shf_keterangan'], 'required'],
            [['shf_aktif', 'shf_created_by', 'shf_updated_by', 'shf_deleted_by'], 'integer'],
            [['shf_keterangan'], 'string'],
            [['shf_created_at', 'shf_updated_at', 'shf_deleted_at'], 'safe'],
            [['shf_nama'], 'string', 'max' => 100],
            [['shf_nama'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'shf_id' => 'Shf ID',
            'shf_nama' => 'Shf Nama',
            'shf_aktif' => 'Shf Aktif',
            'shf_keterangan' => 'Shf Keterangan',
            'shf_created_at' => 'Shf Created At',
            'shf_created_by' => 'Shf Created By',
            'shf_updated_at' => 'Shf Updated At',
            'shf_updated_by' => 'Shf Updated By',
            'shf_deleted_at' => 'Shf Deleted At',
            'shf_deleted_by' => 'Shf Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return EbsMShiftQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EbsMShiftQuery(get_called_class());
    }
	
	public static function getListShift()
    {
            $DataShift = EbsMShift::find()
            ->select(['shf_id', 'shf_nama'])->andWhere(['shf_aktif'=>1])
            ->andWhere('shf_deleted_at is null')->asArray()->all();

            $shift=[];
            if(count($DataShift)>0){
                foreach($DataShift as $dt){
                    $shift[]=['id'=>$dt['shf_id'],'nama'=>$dt['shf_nama']];
                }
            }

            return $shift;
    }
}
