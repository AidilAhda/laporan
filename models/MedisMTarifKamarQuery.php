<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MedisMTarifKamar]].
 *
 * @see MedisMTarifKamar
 */
class MedisMTarifKamarQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MedisMTarifKamar[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MedisMTarifKamar|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
