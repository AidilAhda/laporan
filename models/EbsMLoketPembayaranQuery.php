<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EbsMLoketPembayaran]].
 *
 * @see EbsMLoketPembayaran
 */
class EbsMLoketPembayaranQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EbsMLoketPembayaran[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EbsMLoketPembayaran|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
