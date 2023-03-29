<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EbsMShift]].
 *
 * @see EbsMShift
 */
class EbsMShiftQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EbsMShift[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EbsMShift|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
