<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PendaftaranMKiriman]].
 *
 * @see PendaftaranMKiriman
 */
class PendaftaranMKirimanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PendaftaranMKiriman[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PendaftaranMKiriman|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
