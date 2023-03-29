<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PendaftaranMPenyakit]].
 *
 * @see PendaftaranMPenyakit
 */
class PendaftaranMPenyakitQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PendaftaranMPenyakit[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PendaftaranMPenyakit|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
