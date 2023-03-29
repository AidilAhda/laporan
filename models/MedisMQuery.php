<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MedisMIcd10cm]].
 *
 * @see MedisMIcd10cm
 */
class MedisMQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MedisMIcd10cm[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MedisMIcd10cm|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
