<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PendaftaranMKelasRawat]].
 *
 * @see PendaftaranMKelasRawat
 */
class PendaftaranMKelasRawatQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PendaftaranMKelasRawat[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PendaftaranMKelasRawat|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
