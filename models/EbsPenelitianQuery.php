<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EbsPenelitian]].
 *
 * @see EbsPenelitian
 */
class EbsPenelitianQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EbsPenelitian[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EbsPenelitian|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
