<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[FarmasiPenjualanDetail]].
 *
 * @see FarmasiPenjualanDetail
 */
class FarmasiPenjualanDetailQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return FarmasiPenjualanDetail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return FarmasiPenjualanDetail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
