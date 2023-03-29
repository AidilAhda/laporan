<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EbsNaikKelas;

/**
 * EbsNaikKelasSearch represents the model behind the search form of `app\models\EbsNaikKelas`.
 */
class EbsNaikKelasSearch extends EbsNaikKelas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nkls_id', 'nkls_kategori_waktu', 'nkls_persentase_biaya', 'nkls_created_by', 'nkls_updated_by', 'nkls_deleted_by'], 'integer'],
            [['nkls_pasien_kode', 'nkls_reg_kode', 'nkls_created_at', 'nkls_updated_at', 'nkls_deleted_at'], 'safe'],
            [['nkls_paket_jkn'], 'number'],
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
        $query = EbsNaikKelas::find();

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
            'nkls_id' => $this->nkls_id,
            'nkls_kategori_waktu' => $this->nkls_kategori_waktu,
            'nkls_persentase_biaya' => $this->nkls_persentase_biaya,
            'nkls_paket_jkn' => $this->nkls_paket_jkn,
            'nkls_created_at' => $this->nkls_created_at,
            'nkls_created_by' => $this->nkls_created_by,
            'nkls_updated_at' => $this->nkls_updated_at,
            'nkls_updated_by' => $this->nkls_updated_by,
            'nkls_deleted_at' => $this->nkls_deleted_at,
            'nkls_deleted_by' => $this->nkls_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'nkls_pasien_kode', $this->nkls_pasien_kode])
            ->andFilterWhere(['like', 'nkls_reg_kode', $this->nkls_reg_kode]);

        return $dataProvider;
    }
}
