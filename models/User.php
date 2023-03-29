<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
	public static function tableName()
    {
        return '{{sdm_m_pegawai}}';
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($pgw_id)
    {
        // return static::findOne($pgw_id);
		$pengguna=\Yii::$app->db->createCommand('
            SELECT
                a.akp_id,a.akp_pgw_id,a.akp_apl_id,a.akp_all_id,b.pgw_nomor,b.`pgw_gelar_depan`,b.`pgw_nama`,b.`pgw_gelar_belakang`,c.all_nama,d.apl_kode,d.apl_nama
                FROM sdm_m_akses_aplikasi a
                INNER JOIN sdm_m_pegawai b ON a.akp_pgw_id=b.pgw_id
                INNER JOIN sdm_m_aplikasi_level c ON a.akp_all_id=c.all_id
                INNER JOIN sdm_m_aplikasi d ON a.akp_apl_id=d.apl_id
            WHERE b.pgw_id=:id AND b.pgw_aktif=1 AND d.apl_kode=:appkode
            ORDER BY b.pgw_created_at DESC
        ')
        ->bindValue(':id', $pgw_id)
        ->bindValue(':appkode',\Yii::$app->params['app']['id'])
        ->queryOne();
        if($pengguna){
            return static::find()->where(['pgw_id' => $pgw_id])->andWhere(['IS','pgw_deleted_at',null])->one();
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
          // return static::findOne(['access_token' => $token]);
		  throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($pgw_username)
    {
        // return static::findOne(['pgw_username' => $pgw_username]);
		$pengguna=\Yii::$app->db->createCommand('
            SELECT
                a.akp_id,a.akp_pgw_id,a.akp_apl_id,a.akp_all_id,
                b.pgw_nomor,b.pgw_gelar_depan,b.pgw_nama,b.pgw_gelar_belakang,b.pgw_username,b.pgw_password_hash,
                c.all_nama,d.apl_kode,d.apl_nama
            FROM sdm_m_akses_aplikasi a
                INNER JOIN sdm_m_pegawai b ON a.akp_pgw_id=b.pgw_id
                INNER JOIN sdm_m_aplikasi_level c ON a.akp_all_id=c.all_id
                INNER JOIN sdm_m_aplikasi d ON a.akp_apl_id=d.apl_id
            WHERE b.pgw_username=:username AND b.pgw_aktif=1 AND d.apl_kode=:appkode
            ORDER BY b.pgw_created_at DESC
        ')
        ->bindValue(':username', $pgw_username)
        ->bindValue(':appkode',\Yii::$app->params['app']['id'])
        ->queryOne();
        if($pengguna){
            return static::find()->where(['pgw_username' => $pgw_username])->andWhere(['IS','pgw_deleted_at',null])->one();
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->pgw_id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->pgw_auth_key;
		// return false;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($pgw_auth_key)
    {
        return $this->pgw_auth_key === $pgw_auth_key;
		// return false;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($pgw_password)
    {
		return Yii::$app->getSecurity()->validatePassword($pgw_password, $this->pgw_password_hash);
    }

    public function setPassword($pgw_password)
    {
        $this->pgw_password_hash = Yii::$app->security->generatePasswordHash($pgw_password);
    }

    public function generateAuthKey()
    {
        $this->pgw_auth_key = Yii::$app->security->generateRandomString();
    }
}