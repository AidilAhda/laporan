<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EbsLog]].
 *
 * @see EbsLog
 */
class EbsLogQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EbsLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EbsLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
