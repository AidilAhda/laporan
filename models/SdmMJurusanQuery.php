<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SdmMJurusan]].
 *
 * @see SdmMJurusan
 */
class SdmMJurusanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SdmMJurusan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SdmMJurusan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
