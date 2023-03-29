<?php

namespace app\models;

use Yii;

class PelaporanDataKlaim extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pelaporan_data_klaim';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pdk_reg_kode', 'pdk_kode_klaim','pdk_status_klaim'], 'required'],
            [['pdk_status_klaim'], 'integer'],
            [['pdk_created_at', 'pdk_updated_at', 'pdk_deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pdk_id' => 'ID',
            'pdk_reg_kode' => 'No Registrasi Pasien',
            'pdk_kode_klaim' => 'Kode Klaim',
            'pdk_status_klaim' => 'Status Klaim',
        ];
    }
}
