<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EbsBiayaAmbulance;

/**
 * EbsBiayaAmbulanceSearch represents the model behind the search form of `app\models\EbsBiayaAmbulance`.
 */
class EbsBiayaAmbulanceSearch extends EbsBiayaAmbulance
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bynce_id', 'bynce_jarak', 'bynce_supir_id', 'bynce_created_by', 'bynce_updated_by', 'bynce_deleted_by'], 'integer'],
            [['bynce_tgl_berangkat', 'bynce_pasien_kode', 'bynce_reg_kode', 'bynce_nama_pasien', 'bynce_alamat_tujuan', 'bynce_keterangan', 'bynce_created_at', 'bynce_updated_at', 'bynce_deleted_at'], 'safe'],
            [['bynce_biaya'], 'number'],
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
        $query = EbsBiayaAmbulance::find();

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
            'bynce_id' => $this->bynce_id,
            'bynce_tgl_berangkat' => $this->bynce_tgl_berangkat,
            'bynce_jarak' => $this->bynce_jarak,
            'bynce_supir_id' => $this->bynce_supir_id,
            'bynce_biaya' => $this->bynce_biaya,
            'bynce_created_at' => $this->bynce_created_at,
            'bynce_created_by' => $this->bynce_created_by,
            'bynce_updated_at' => $this->bynce_updated_at,
            'bynce_updated_by' => $this->bynce_updated_by,
            'bynce_deleted_at' => $this->bynce_deleted_at,
            'bynce_deleted_by' => $this->bynce_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'bynce_pasien_kode', $this->bynce_pasien_kode])
            ->andFilterWhere(['like', 'bynce_reg_kode', $this->bynce_reg_kode])
            ->andFilterWhere(['like', 'bynce_nama_pasien', $this->bynce_nama_pasien])
            ->andFilterWhere(['like', 'bynce_alamat_tujuan', $this->bynce_alamat_tujuan])
            ->andFilterWhere(['like', 'bynce_keterangan', $this->bynce_keterangan]);

        return $dataProvider;
    }
}
