<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EbsSuratPernyataan]].
 *
 * @see EbsSuratPernyataan
 */
class EbsSuratPernyataanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EbsSuratPernyataan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EbsSuratPernyataan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
