<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EbsMKodePembayaran]].
 *
 * @see EbsMKodePembayaran
 */
class EbsMKodePembayaranQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EbsMKodePembayaran[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EbsMKodePembayaran|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
