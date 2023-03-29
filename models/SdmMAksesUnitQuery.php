<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SdmMAksesUnit]].
 *
 * @see SdmMAksesUnit
 */
class SdmMAksesUnitQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SdmMAksesUnit[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SdmMAksesUnit|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
