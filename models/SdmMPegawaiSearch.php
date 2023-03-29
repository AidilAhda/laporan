<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SdmMPegawai;

/**
 * SdmMPegawaiSearch represents the model behind the search form of `app\models\SdmMPegawai`.
 */
class SdmMPegawaiSearch extends SdmMPegawai
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pgw_id', 'pgw_kode_pos', 'pgw_tinggi_badan', 'pgw_berat_badan', 'pgw_status_kepegawaian_id', 'pgw_aktif', 'pgw_tipe_user', 'pgw_created_by', 'pgw_updated_by', 'pgw_deleted_by'], 'integer'],
            [['pgw_nomor', 'pgw_gelar_depan', 'pgw_nama', 'pgw_gelar_belakang', 'pgw_email', 'pgw_tempat_lahir', 'pgw_tanggal_lahir', 'pgw_jenis_kelamin', 'pgw_status_perkawinan', 'pgw_agama_id', 'pgw_alamat', 'pgw_rt', 'pgw_rw', 'pgw_desa_kelurahan', 'pgw_kecamatan', 'pgw_kabupaten_kota', 'pgw_provinsi', 'pgw_no_telepon_1', 'pgw_no_telepon_2', 'pgw_golongan_darah', 'pgw_npwp', 'pgw_nomor_ktp', 'pgw_rambut', 'pgw_bentuk_muka', 'pgw_warna_kulit', 'pgw_ciri_ciri_khas', 'pgw_cacat_tubuh', 'pgw_kegemaran_1', 'pgw_kegemaran_2', 'pgw_foto', 'pgw_username', 'pgw_auth_key', 'pgw_password_hash', 'pgw_password_reset_token', 'pgw_created_at', 'pgw_updated_at', 'pgw_deleted_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SdmMPegawai::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'pgw_id' => $this->pgw_id,
            'pgw_tanggal_lahir' => $this->pgw_tanggal_lahir,
            'pgw_kode_pos' => $this->pgw_kode_pos,
            'pgw_tinggi_badan' => $this->pgw_tinggi_badan,
            'pgw_berat_badan' => $this->pgw_berat_badan,
            'pgw_status_kepegawaian_id' => $this->pgw_status_kepegawaian_id,
            'pgw_aktif' => $this->pgw_aktif,
            'pgw_tipe_user' => $this->pgw_tipe_user,
            'pgw_created_at' => $this->pgw_created_at,
            'pgw_created_by' => $this->pgw_created_by,
            'pgw_updated_at' => $this->pgw_updated_at,
            'pgw_updated_by' => $this->pgw_updated_by,
            'pgw_deleted_at' => $this->pgw_deleted_at,
            'pgw_deleted_by' => $this->pgw_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'pgw_nomor', $this->pgw_nomor])
            ->andFilterWhere(['like', 'pgw_gelar_depan', $this->pgw_gelar_depan])
            ->andFilterWhere(['like', 'pgw_nama', $this->pgw_nama])
            ->andFilterWhere(['like', 'pgw_gelar_belakang', $this->pgw_gelar_belakang])
            ->andFilterWhere(['like', 'pgw_email', $this->pgw_email])
            ->andFilterWhere(['like', 'pgw_tempat_lahir', $this->pgw_tempat_lahir])
            ->andFilterWhere(['like', 'pgw_jenis_kelamin', $this->pgw_jenis_kelamin])
            ->andFilterWhere(['like', 'pgw_status_perkawinan', $this->pgw_status_perkawinan])
            ->andFilterWhere(['like', 'pgw_agama_id', $this->pgw_agama_id])
            ->andFilterWhere(['like', 'pgw_alamat', $this->pgw_alamat])
            ->andFilterWhere(['like', 'pgw_rt', $this->pgw_rt])
            ->andFilterWhere(['like', 'pgw_rw', $this->pgw_rw])
            ->andFilterWhere(['like', 'pgw_desa_kelurahan', $this->pgw_desa_kelurahan])
            ->andFilterWhere(['like', 'pgw_kecamatan', $this->pgw_kecamatan])
            ->andFilterWhere(['like', 'pgw_kabupaten_kota', $this->pgw_kabupaten_kota])
            ->andFilterWhere(['like', 'pgw_provinsi', $this->pgw_provinsi])
            ->andFilterWhere(['like', 'pgw_no_telepon_1', $this->pgw_no_telepon_1])
            ->andFilterWhere(['like', 'pgw_no_telepon_2', $this->pgw_no_telepon_2])
            ->andFilterWhere(['like', 'pgw_golongan_darah', $this->pgw_golongan_darah])
            ->andFilterWhere(['like', 'pgw_npwp', $this->pgw_npwp])
            ->andFilterWhere(['like', 'pgw_nomor_ktp', $this->pgw_nomor_ktp])
            ->andFilterWhere(['like', 'pgw_rambut', $this->pgw_rambut])
            ->andFilterWhere(['like', 'pgw_bentuk_muka', $this->pgw_bentuk_muka])
            ->andFilterWhere(['like', 'pgw_warna_kulit', $this->pgw_warna_kulit])
            ->andFilterWhere(['like', 'pgw_ciri_ciri_khas', $this->pgw_ciri_ciri_khas])
            ->andFilterWhere(['like', 'pgw_cacat_tubuh', $this->pgw_cacat_tubuh])
            ->andFilterWhere(['like', 'pgw_kegemaran_1', $this->pgw_kegemaran_1])
            ->andFilterWhere(['like', 'pgw_kegemaran_2', $this->pgw_kegemaran_2])
            ->andFilterWhere(['like', 'pgw_foto', $this->pgw_foto])
            ->andFilterWhere(['like', 'pgw_username', $this->pgw_username])
            ->andFilterWhere(['like', 'pgw_auth_key', $this->pgw_auth_key])
            ->andFilterWhere(['like', 'pgw_password_hash', $this->pgw_password_hash])
            ->andFilterWhere(['like', 'pgw_password_reset_token', $this->pgw_password_reset_token]);

        return $dataProvider;
    }
}
