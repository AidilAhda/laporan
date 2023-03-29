<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medis_m_tindakan".
 *
 * @property int $tdk_id
 * @property int $tdk_parent_id
 * @property string $tdk_deskripsi
 * @property int|null $tdk_aktif 1=y,0=n
 * @property string $tdk_kode_jenis
 * @property string|null $tdk_created_at
 * @property int|null $tdk_created_by
 * @property string|null $tdk_updated_at
 * @property int|null $tdk_updated_by
 * @property string|null $tdk_deleted_at
 * @property int|null $tdk_deleted_by
 */
class MedisMTindakan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis_m_tindakan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tdk_parent_id', 'tdk_deskripsi', 'tdk_kode_jenis'], 'required'],
            [['tdk_parent_id', 'tdk_aktif', 'tdk_created_by', 'tdk_updated_by', 'tdk_deleted_by'], 'integer'],
            [['tdk_created_at', 'tdk_updated_at', 'tdk_deleted_at'], 'safe'],
            [['tdk_deskripsi'], 'string', 'max' => 3],
            [['tdk_kode_jenis'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tdk_id' => 'Tdk ID',
            'tdk_parent_id' => 'Tdk Parent ID',
            'tdk_deskripsi' => 'Tdk Deskripsi',
            'tdk_aktif' => 'Tdk Aktif',
            'tdk_kode_jenis' => 'Tdk Kode Jenis',
            'tdk_created_at' => 'Tdk Created At',
            'tdk_created_by' => 'Tdk Created By',
            'tdk_updated_at' => 'Tdk Updated At',
            'tdk_updated_by' => 'Tdk Updated By',
            'tdk_deleted_at' => 'Tdk Deleted At',
            'tdk_deleted_by' => 'Tdk Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return MedisMTindakanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MedisMTindakanQuery(get_called_class());
    }
	
	public static function getNamaTindakan($tdk_id)
	{
		
		$Data = MedisMTindakan::find()
		->andWhere(['tdk_id'=> $tdk_id])
		->asArray()
		->one();

		return $Data;
	}
}
