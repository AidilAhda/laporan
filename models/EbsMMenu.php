<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ebs_m_menu".
 *
 * @property int $mnu_id Menu Id
 * @property string $mnu_nama Nama Menu
 * @property string $mnu_variabel Variable Form Input
 * @property int $mnu_aktif 1 => aktif 0 => Tidak Aktif
 * @property int $mnu_tampil 1 => Tampil 0 => Tidak Tampil
 * @property string|null $mnu_keterangan
 * @property string|null $mnu_created_at
 * @property int|null $mnu_created_by
 * @property string|null $mnu_updated_at
 * @property int|null $mnu_updated_by
 * @property string|null $mnu_deleted_at
 * @property int|null $mnu_deleted_by
 */
class EbsMMenu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ebs_m_menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mnu_nama', 'mnu_variabel'], 'required'],
            [['mnu_aktif', 'mnu_tampil', 'mnu_created_by', 'mnu_updated_by', 'mnu_deleted_by'], 'integer'],
            [['mnu_keterangan'], 'string'],
            [['mnu_created_at', 'mnu_updated_at', 'mnu_deleted_at'], 'safe'],
            [['mnu_nama'], 'string', 'max' => 255],
            [['mnu_variabel'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mnu_id' => 'Mnu ID',
            'mnu_nama' => 'Mnu Nama',
            'mnu_variabel' => 'Mnu Variabel',
            'mnu_aktif' => 'Mnu Aktif',
            'mnu_tampil' => 'Mnu Tampil',
            'mnu_keterangan' => 'Mnu Keterangan',
            'mnu_created_at' => 'Mnu Created At',
            'mnu_created_by' => 'Mnu Created By',
            'mnu_updated_at' => 'Mnu Updated At',
            'mnu_updated_by' => 'Mnu Updated By',
            'mnu_deleted_at' => 'Mnu Deleted At',
            'mnu_deleted_by' => 'Mnu Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return EbsMMenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EbsMMenuQuery(get_called_class());
    }

    public function getMainMenu()
    {
        
        $Data = EbsMMenu::find()
        ->andWhere(['mnu_tampil'=>'1'])
        ->andWhere('mnu_deleted_at is null')
        ->asArray()
        ->all();

        return $Data;
    }
	public static function dataMenu()
    {
        $Data = EbsMMenu::find()
        ->andWhere('mnu_deleted_at is null')->orderBy(['mnu_created_at'=>SORT_DESC])
        ->asArray()->all();

        $Jumlah = count($Data);

        return array('Data'=>$Data, 'Jumlah'=>$Jumlah);
    }
}
