<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MedisMTindakan]].
 *
 * @see MedisMTindakan
 */
class MedisMTindakanVedikaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MedisMTindakan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MedisMTindakan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
