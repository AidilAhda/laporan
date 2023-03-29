<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SdmMNegara]].
 *
 * @see SdmMNegara
 */
class SdmMNegaraQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SdmMNegara[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SdmMNegara|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
