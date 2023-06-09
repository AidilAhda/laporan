<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medis_m_icd10cm".
 *
 * @property int $icd10_id
 * @property int $icd10_parent_id
 * @property string $icd10_kode
 * @property string $icd10_deskripsi
 * @property string|null $icd10_keterangan
 * @property int|null $icd10_aktif
 * @property string|null $icd10_created_at
 * @property int|null $icd10_created_by
 * @property string|null $icd10_updated_at
 * @property int|null $icd10_updated_by
 * @property string|null $icd10_deleted_at
 * @property int|null $icd10_deleted_by
 */
class MedisMIcd10cm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis_m_icd10cm';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icd10_parent_id', 'icd10_kode', 'icd10_deskripsi'], 'required'],
            [['icd10_parent_id', 'icd10_aktif', 'icd10_created_by', 'icd10_updated_by', 'icd10_deleted_by'], 'integer'],
            [['icd10_deskripsi', 'icd10_keterangan'], 'string'],
            [['icd10_created_at', 'icd10_updated_at', 'icd10_deleted_at'], 'safe'],
            [['icd10_kode'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'icd10_id' => 'Icd10 ID',
            'icd10_parent_id' => 'Icd10 Parent ID',
            'icd10_kode' => 'Icd10 Kode',
            'icd10_deskripsi' => 'Icd10 Deskripsi',
            'icd10_keterangan' => 'Icd10 Keterangan',
            'icd10_aktif' => 'Icd10 Aktif',
            'icd10_created_at' => 'Icd10 Created At',
            'icd10_created_by' => 'Icd10 Created By',
            'icd10_updated_at' => 'Icd10 Updated At',
            'icd10_updated_by' => 'Icd10 Updated By',
            'icd10_deleted_at' => 'Icd10 Deleted At',
            'icd10_deleted_by' => 'Icd10 Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return MedisMQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MedisMQuery(get_called_class());
    }
    public static function getDataQuery($search=null){
        $sql="
        WITH RECURSIVE rec_query AS (
            SELECT 
                a.icd10_id, a.icd10_parent_id, a.icd10_kode, a.icd10_deskripsi,a.icd10_deskripsi AS rumpun
            FROM ".self::tableName()." as a
            WHERE a.icd10_parent_id=0 AND a.icd10_aktif=1 AND a.icd10_deleted_at IS NULL
            UNION ALL
            SELECT 
                b.icd10_id, b.icd10_parent_id, b.icd10_kode, b.icd10_deskripsi, CONCAT(rec_query.rumpun, \" >> \", b.icd10_deskripsi) as rumpun
            FROM ".self::tableName()." as b
            JOIN rec_query ON b.icd10_parent_id = rec_query.icd10_id  AND b.icd10_aktif=1 AND b.icd10_deleted_at IS NULL
        )
        SELECT 
        icd10_id as id ,CONCAT('(',icd10_kode,') ',icd10_deskripsi) as text,CONCAT('(',rumpun,')',icd10_deskripsi) as text_rumpun,icd10_id,icd10_parent_id,icd10_kode,icd10_deskripsi,rumpun
        FROM rec_query 
        WHERE icd10_id NOT IN (SELECT DISTINCT icd10_parent_id FROM rec_query WHERE icd10_parent_id IS NOT NULL)
        ORDER BY icd10_kode ASC
        ";
        if($search){
            $sql="
            WITH RECURSIVE rec_query AS (
                SELECT 
                    a.icd10_id, a.icd10_parent_id, a.icd10_kode, a.icd10_deskripsi,a.icd10_deskripsi AS rumpun
                FROM ".self::tableName()." as a
                WHERE a.icd10_parent_id=0 AND a.icd10_aktif=1 AND a.icd10_deleted_at IS NULL
                UNION ALL
                SELECT 
                    b.icd10_id, b.icd10_parent_id, b.icd10_kode, b.icd10_deskripsi, CONCAT(rec_query.rumpun, \" >> \", b.icd10_deskripsi) as rumpun
                FROM ".self::tableName()." as b
                JOIN rec_query ON b.icd10_parent_id = rec_query.icd10_id AND b.icd10_aktif=1 AND b.icd10_deleted_at IS NULL
            )
            SELECT 
            icd10_id as id ,CONCAT('(',icd10_kode,') ',icd10_deskripsi) as text,CONCAT('(',rumpun,')',icd10_deskripsi) as text_rumpun,icd10_id,icd10_parent_id,icd10_kode,icd10_deskripsi,rumpun
            FROM rec_query 
            WHERE icd10_id NOT IN (SELECT DISTINCT icd10_parent_id FROM rec_query WHERE icd10_parent_id IS NOT NULL) AND (LOWER(icd10_kode) LIKE '%".strtolower($search)."%' OR LOWER(icd10_deskripsi) LIKE '%".strtolower($search)."%')
            ORDER BY icd10_kode ASC
            "; 
        }
        return \Yii::$app->db->createCommand($sql)->queryAll();
    }
}