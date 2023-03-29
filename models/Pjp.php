<?php

namespace app\models;

use Yii;
use app\models\SdmMPegawai;
use app\models\PendaftaranLayanan;
use app\models\other\BaseQuery;
use app\models\other\TrimBehavior;
use app\components\Akun;
/**
 * This is the model class for table "medis_pjp".
 *
 * @property int $pjp_id
 * @property int $pjp_pl_id PK pendaftaran_layanan
 * @property int $pjp_pgw_id PK sdm_m_pegawai
 * @property int $pjp_status default 0, jika 1 => dokter utama,2 => dokter pendukung
 * @property string $pjp_tgl
 * @property string|null $pjp_ket
 * @property string $pjp_created_at
 * @property int $pjp_created_by
 * @property string|null $pjp_updated_at
 * @property int|null $pjp_updated_by
 * @property string|null $pjp_deleted_at
 * @property int|null $pjp_deleted_by
 */
class Pjp extends \yii\db\ActiveRecord
{
    const DPJP_UTAMA = 1;
    const DPJP_PENDUKUNG = 2;

    const prefix='pjp';
    const alias='pjp';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis_pjp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pjp_pl_id', 'pjp_pgw_id', 'pjp_status','pjp_tgl'], 'required'],
            [['pjp_pl_id', 'pjp_pgw_id', 'pjp_status', 'pjp_created_by', 'pjp_updated_by', 'pjp_deleted_by'], 'integer'],
            [['pjp_tgl', 'pjp_created_at', 'pjp_updated_at', 'pjp_deleted_at'], 'safe'],
            [['pjp_ket'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pjp_id' => 'Pjp ID',
            'pjp_pl_id' => 'Pjp Pl ID',
            'pjp_pgw_id' => 'Dokter',
            'pjp_status' => 'DPJP',
            'pjp_tgl' => 'Tanggal',
            'pjp_ket' => 'Pjp Ket',
            'pjp_created_at' => 'Pjp Created At',
            'pjp_created_by' => 'Pjp Created By',
            'pjp_updated_at' => 'Pjp Updated At',
            'pjp_updated_by' => 'Pjp Updated By',
            'pjp_deleted_at' => 'Pjp Deleted At',
            'pjp_deleted_by' => 'Pjp Deleted By',
        ];
    }



    function getPegawai()
    {
        return $this->hasOne(SdmMPegawai::className(),['pgw_id'=>'pjp_pgw_id']);
    }
    function getLayanan()
    {
        return $this->hasOne(PendaftaranLayanan::className(),['pl_id'=>'pjp_pl_id']);
    }
}
