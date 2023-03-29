<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EbsNaikKelas]].
 *
 * @see EbsNaikKelas
 */
class EbsNaikKelasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EbsNaikKelas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EbsNaikKelas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
