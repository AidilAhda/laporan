<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PendaftaranBiayaRawatjalan]].
 *
 * @see PendaftaranBiayaRawatjalan
 */
class PendaftaranBiayaRawatjalanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PendaftaranBiayaRawatjalan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PendaftaranBiayaRawatjalan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
