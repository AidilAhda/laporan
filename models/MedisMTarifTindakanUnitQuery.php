<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MedisMTarifTindakanUnit]].
 *
 * @see MedisMTarifTindakanUnit
 */
class MedisMTarifTindakanUnitQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MedisMTarifTindakanUnit[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MedisMTarifTindakanUnit|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
