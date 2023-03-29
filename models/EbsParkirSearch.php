<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EbsParkir;

/**
 * EbsParkirSearch represents the model behind the search form of `app\models\EbsParkir`.
 */
class EbsParkirSearch extends EbsParkir
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prkr_id', 'prkr_roda2_pagi_petugas', 'prkr_roda3_pagi_petugas', 'prkr_roda4_pagi_petugas', 'prkr_roda2_siang_petugas', 'prkr_roda3_siang_petugas', 'prkr_roda4_siang_petugas', 'prkr_roda2_malam_petugas', 'prkr_roda3_malam_petugas', 'prkr_roda4_malam_petugas', 'prkr_kepala_unit', 'prkr_petugas_setor', 'prkr_created_by', 'prkr_updated_by', 'prkr_deleted_by'], 'integer'],
            [['prkr_tgl', 'prkr_created_at', 'prkr_updated_at', 'prkr_deleted_at'], 'safe'],
            [['prkr_roda2_pagi', 'prkr_roda3_pagi', 'prkr_roda4_pagi', 'prkr_roda2_siang', 'prkr_roda3_siang', 'prkr_roda4_siang', 'prkr_roda2_malam', 'prkr_roda3_malam', 'prkr_roda4_malam', 'prkr_jumlah'], 'number'],
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
        $query = EbsParkir::find();

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
            'prkr_id' => $this->prkr_id,
            'prkr_tgl' => $this->prkr_tgl,
            'prkr_roda2_pagi' => $this->prkr_roda2_pagi,
            'prkr_roda2_pagi_petugas' => $this->prkr_roda2_pagi_petugas,
            'prkr_roda3_pagi' => $this->prkr_roda3_pagi,
            'prkr_roda3_pagi_petugas' => $this->prkr_roda3_pagi_petugas,
            'prkr_roda4_pagi' => $this->prkr_roda4_pagi,
            'prkr_roda4_pagi_petugas' => $this->prkr_roda4_pagi_petugas,
            'prkr_roda2_siang' => $this->prkr_roda2_siang,
            'prkr_roda2_siang_petugas' => $this->prkr_roda2_siang_petugas,
            'prkr_roda3_siang' => $this->prkr_roda3_siang,
            'prkr_roda3_siang_petugas' => $this->prkr_roda3_siang_petugas,
            'prkr_roda4_siang' => $this->prkr_roda4_siang,
            'prkr_roda4_siang_petugas' => $this->prkr_roda4_siang_petugas,
            'prkr_roda2_malam' => $this->prkr_roda2_malam,
            'prkr_roda2_malam_petugas' => $this->prkr_roda2_malam_petugas,
            'prkr_roda3_malam' => $this->prkr_roda3_malam,
            'prkr_roda3_malam_petugas' => $this->prkr_roda3_malam_petugas,
            'prkr_roda4_malam' => $this->prkr_roda4_malam,
            'prkr_roda4_malam_petugas' => $this->prkr_roda4_malam_petugas,
            'prkr_jumlah' => $this->prkr_jumlah,
            'prkr_kepala_unit' => $this->prkr_kepala_unit,
            'prkr_petugas_setor' => $this->prkr_petugas_setor,
            'prkr_created_at' => $this->prkr_created_at,
            'prkr_created_by' => $this->prkr_created_by,
            'prkr_updated_at' => $this->prkr_updated_at,
            'prkr_updated_by' => $this->prkr_updated_by,
            'prkr_deleted_at' => $this->prkr_deleted_at,
            'prkr_deleted_by' => $this->prkr_deleted_by,
        ]);

        return $dataProvider;
    }
}
