<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EbsPembayaranPlafon]].
 *
 * @see EbsPembayaranPlafon
 */
class EbsPembayaranPlafonQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EbsPembayaranPlafon[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EbsPembayaranPlafon|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
