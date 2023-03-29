<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MedisTindakanPasien]].
 *
 * @see MedisTindakanPasien
 */
class MedisTindakanPasienQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MedisTindakanPasien[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MedisTindakanPasien|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
