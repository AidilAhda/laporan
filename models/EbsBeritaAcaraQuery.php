<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EbsBeritaAcara]].
 *
 * @see EbsBeritaAcara
 */
class EbsBeritaAcaraQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EbsBeritaAcara[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EbsBeritaAcara|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
