<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pendaftaran_m_debitur".
 *
 * @property string $pmd_kode
 * @property string $pmd_nama
 * @property int $pmd_aktif
 * @property string|null $pmd_created_at
 * @property int|null $pmd_created_by
 * @property string|null $pmd_updated_at
 * @property int|null $pmd_updated_by
 * @property string|null $pmd_deleted_at
 * @property int|null $pmd_deleted_by
 */
class PendaftaranMDebitur extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    static $prefix="pmd";
    public static function tableName()
    {
        return 'pendaftaran_m_debitur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pmd_kode', 'pmd_nama'], 'required'],
            [['pmd_aktif', 'pmd_created_by', 'pmd_updated_by', 'pmd_deleted_by'], 'integer'],
            [['pmd_created_at', 'pmd_updated_at', 'pmd_deleted_at'], 'safe'],
            [['pmd_kode'], 'string', 'max' => 10],
            [['pmd_nama'], 'string', 'max' => 255],
            [['pmd_kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pmd_kode' => 'Pmd Kode',
            'pmd_nama' => 'Pmd Nama',
            'pmd_aktif' => 'Pmd Aktif',
            'pmd_created_at' => 'Pmd Created At',
            'pmd_created_by' => 'Pmd Created By',
            'pmd_updated_at' => 'Pmd Updated At',
            'pmd_updated_by' => 'Pmd Updated By',
            'pmd_deleted_at' => 'Pmd Deleted At',
            'pmd_deleted_by' => 'Pmd Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PendaftaranMDebiturQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PendaftaranMDebiturQuery(get_called_class());
    }
       static function all()
    {
        return self::find()->active(self::$prefix)->notDeleted(self::$prefix)->asArray()->all();
    }
}
