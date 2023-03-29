<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EbsPetugasParkir]].
 *
 * @see EbsPetugasParkir
 */
class EbsPetugasParkirQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EbsPetugasParkir[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EbsPetugasParkir|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
