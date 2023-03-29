<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PendaftaranMKebiasaan]].
 *
 * @see PendaftaranMKebiasaan
 */
class PendaftaranMKebiasaanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PendaftaranMKebiasaan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PendaftaranMKebiasaan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
