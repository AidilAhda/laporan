<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PendaftaranPasien]].
 *
 * @see PendaftaranPasien
 */
class PendaftaranPasienQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PendaftaranPasien[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PendaftaranPasien|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

     function deleted($prefix=NULL,$alias=NULL)
    {
        $this->andWhere(($alias!=NULL ? $alias.'.' : '').( $prefix ? $prefix.'_' : '' ).'deleted_at is not null');
        return $this;
    }
    function notDeleted($prefix=NULL,$alias=NULL)
    {
        $this->andWhere('ps_deleted_at is null');
        return $this;
    }
    function active($prefix=NULL,$alias=NULL)
    {
        $this->andWhere([($alias!=NULL ? $alias.'.' : '').( $prefix ? $prefix.'_' : '' )."aktif"=>1]);
        return $this;
    }
    function inActive($prefix=NULL,$alias=NULL)
    {
        $this->andWhere(($alias!=NULL ? $alias.'.' : '').( $prefix ? $prefix.'_' : '' ).'aktif=0');
        return $this;
    }
}
