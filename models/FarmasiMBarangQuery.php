<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[FarmasiMBarang]].
 *
 * @see FarmasiMBarang
 */
class FarmasiMBarangQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return FarmasiMBarang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return FarmasiMBarang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
