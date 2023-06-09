<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sdm_m_pegawai".
 *
 * @property int $pgw_id
 * @property string $pgw_nomor
 * @property string $pgw_gelar_depan
 * @property string $pgw_nama
 * @property string $pgw_gelar_belakang
 * @property string|null $pgw_email
 * @property string|null $pgw_tempat_lahir
 * @property string|null $pgw_tanggal_lahir
 * @property string|null $pgw_jenis_kelamin
 * @property string|null $pgw_status_perkawinan
 * @property string|null $pgw_agama_id
 * @property string|null $pgw_alamat
 * @property string|null $pgw_rt
 * @property string|null $pgw_rw
 * @property string|null $pgw_desa_kelurahan
 * @property string|null $pgw_kecamatan
 * @property string|null $pgw_kabupaten_kota
 * @property string|null $pgw_provinsi
 * @property int|null $pgw_kode_pos
 * @property string|null $pgw_no_telepon_1
 * @property string|null $pgw_no_telepon_2
 * @property string|null $pgw_golongan_darah
 * @property string|null $pgw_npwp
 * @property string|null $pgw_nomor_ktp
 * @property int|null $pgw_tinggi_badan
 * @property int|null $pgw_berat_badan
 * @property string|null $pgw_rambut
 * @property string|null $pgw_bentuk_muka
 * @property string|null $pgw_warna_kulit
 * @property string|null $pgw_ciri_ciri_khas
 * @property string|null $pgw_cacat_tubuh
 * @property string|null $pgw_kegemaran_1
 * @property string|null $pgw_kegemaran_2
 * @property string|null $pgw_foto
 * @property int|null $pgw_status_kepegawaian_id
 * @property int|null $pgw_aktif 1=y,0=n
 * @property int|null $pgw_tipe_user
 * @property string|null $pgw_username
 * @property string|null $pgw_auth_key
 * @property string|null $pgw_password_hash
 * @property string|null $pgw_password_reset_token
 * @property string $pgw_created_at
 * @property int|null $pgw_created_by
 * @property string|null $pgw_updated_at
 * @property int|null $pgw_updated_by
 * @property string|null $pgw_deleted_at
 * @property int|null $pgw_deleted_by
 */
class SdmMPegawai extends \yii\db\ActiveRecord
{

    public $pgw_perempuan;
    public $pgw_pria;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sdm_m_pegawai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pgw_nomor', 'pgw_gelar_depan', 'pgw_nama', 'pgw_gelar_belakang'], 'required'],
            [['pgw_tanggal_lahir', 'pgw_created_at', 'pgw_updated_at', 'pgw_deleted_at'], 'safe'],
            [['pgw_kode_pos', 'pgw_tinggi_badan', 'pgw_berat_badan', 'pgw_status_kepegawaian_id', 'pgw_aktif', 'pgw_tipe_user', 'pgw_created_by', 'pgw_updated_by', 'pgw_deleted_by'], 'integer'],
            [['pgw_nomor', 'pgw_nama', 'pgw_tempat_lahir', 'pgw_desa_kelurahan', 'pgw_kecamatan', 'pgw_kabupaten_kota', 'pgw_provinsi'], 'string', 'max' => 30],
            [['pgw_gelar_depan', 'pgw_gelar_belakang', 'pgw_jenis_kelamin'], 'string', 'max' => 10],
            [['pgw_email'], 'string', 'max' => 255],
            [['pgw_status_perkawinan'], 'string', 'max' => 20],
            [['pgw_agama_id', 'pgw_no_telepon_1', 'pgw_no_telepon_2'], 'string', 'max' => 15],
            [['pgw_alamat', 'pgw_foto', 'pgw_password_hash'], 'string', 'max' => 100],
            [['pgw_rt', 'pgw_rw'], 'string', 'max' => 5],
            [['pgw_golongan_darah'], 'string', 'max' => 3],
            [['pgw_npwp', 'pgw_nomor_ktp', 'pgw_rambut', 'pgw_bentuk_muka', 'pgw_warna_kulit', 'pgw_ciri_ciri_khas', 'pgw_cacat_tubuh', 'pgw_kegemaran_1', 'pgw_kegemaran_2', 'pgw_username', 'pgw_auth_key', 'pgw_password_reset_token'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pgw_id' => 'Pgw ID',
            'pgw_nomor' => 'Pgw Nomor',
            'pgw_gelar_depan' => 'Pgw Gelar Depan',
            'pgw_nama' => 'Pgw Nama',
            'pgw_gelar_belakang' => 'Pgw Gelar Belakang',
            'pgw_email' => 'Pgw Email',
            'pgw_tempat_lahir' => 'Pgw Tempat Lahir',
            'pgw_tanggal_lahir' => 'Pgw Tanggal Lahir',
            'pgw_jenis_kelamin' => 'Pgw Jenis Kelamin',
            'pgw_status_perkawinan' => 'Pgw Status Perkawinan',
            'pgw_agama_id' => 'Pgw Agama ID',
            'pgw_alamat' => 'Pgw Alamat',
            'pgw_rt' => 'Pgw Rt',
            'pgw_rw' => 'Pgw Rw',
            'pgw_desa_kelurahan' => 'Pgw Desa Kelurahan',
            'pgw_kecamatan' => 'Pgw Kecamatan',
            'pgw_kabupaten_kota' => 'Pgw Kabupaten Kota',
            'pgw_provinsi' => 'Pgw Provinsi',
            'pgw_kode_pos' => 'Pgw Kode Pos',
            'pgw_no_telepon_1' => 'Pgw No Telepon 1',
            'pgw_no_telepon_2' => 'Pgw No Telepon 2',
            'pgw_golongan_darah' => 'Pgw Golongan Darah',
            'pgw_npwp' => 'Pgw Npwp',
            'pgw_nomor_ktp' => 'Pgw Nomor Ktp',
            'pgw_tinggi_badan' => 'Pgw Tinggi Badan',
            'pgw_berat_badan' => 'Pgw Berat Badan',
            'pgw_rambut' => 'Pgw Rambut',
            'pgw_bentuk_muka' => 'Pgw Bentuk Muka',
            'pgw_warna_kulit' => 'Pgw Warna Kulit',
            'pgw_ciri_ciri_khas' => 'Pgw Ciri Ciri Khas',
            'pgw_cacat_tubuh' => 'Pgw Cacat Tubuh',
            'pgw_kegemaran_1' => 'Pgw Kegemaran 1',
            'pgw_kegemaran_2' => 'Pgw Kegemaran 2',
            'pgw_foto' => 'Pgw Foto',
            'pgw_status_kepegawaian_id' => 'Pgw Status Kepegawaian ID',
            'pgw_aktif' => 'Pgw Aktif',
            'pgw_tipe_user' => 'Pgw Tipe User',
            'pgw_username' => 'Pgw Username',
            'pgw_auth_key' => 'Pgw Auth Key',
            'pgw_password_hash' => 'Pgw Password Hash',
            'pgw_password_reset_token' => 'Pgw Password Reset Token',
            'pgw_created_at' => 'Pgw Created At',
            'pgw_created_by' => 'Pgw Created By',
            'pgw_updated_at' => 'Pgw Updated At',
            'pgw_updated_by' => 'Pgw Updated By',
            'pgw_deleted_at' => 'Pgw Deleted At',
            'pgw_deleted_by' => 'Pgw Deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SdmMPegawaiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SdmMPegawaiQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        // return static::findOne(['id' => $id,'aktif' => self::STATUS_ACTIVE]);
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
        ->bindValue(':id', $id)
        ->bindValue(':appkode',\Yii::$app->params['app']['id'])
        ->queryOne();
        if($pengguna){
            return static::findOne(['pgw_id' => $id,'pgw_deleted_at' => '']);
        }
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        // return static::findOne(['username' => $username,'aktif' => self::STATUS_ACTIVE]);
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
        ->bindValue(':username', $username)
        ->bindValue(':appkode',\Yii::$app->params['app']['id'])
        ->queryOne();
        if($pengguna){
            return static::findOne(['pgw_username' => $username,'pgw_deleted_at' => '']);
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function getLevelakses()
    {
        return $this->hasOne(SdmMAksesAplikasi::class, ['akp_pgw_id' => 'pgw_id']);
    }
}
