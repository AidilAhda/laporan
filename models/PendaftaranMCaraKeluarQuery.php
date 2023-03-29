<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PendaftaranMCaraKeluar]].
 *
 * @see PendaftaranMCaraKeluar
 */
class PendaftaranMCaraKeluarQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PendaftaranMCaraKeluar[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PendaftaranMCaraKeluar|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
