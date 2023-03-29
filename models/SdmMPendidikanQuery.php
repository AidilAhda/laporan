<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SdmMPendidikan]].
 *
 * @see SdmMPendidikan
 */
class SdmMPendidikanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SdmMPendidikan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SdmMPendidikan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
