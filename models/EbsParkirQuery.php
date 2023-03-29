<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EbsParkir]].
 *
 * @see EbsParkir
 */
class EbsParkirQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EbsParkir[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EbsParkir|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
