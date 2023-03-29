<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EbsDebiturLainnya]].
 *
 * @see EbsDebiturLainnya
 */
class EbsDebiturLainnyaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EbsDebiturLainnya[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EbsDebiturLainnya|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
