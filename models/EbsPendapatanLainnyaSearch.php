<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EbsPendapatanLainnya;

/**
 * EbsPendapatanLainnyaSearch represents the model behind the search form of `app\models\EbsPendapatanLainnya`.
 */
class EbsPendapatanLainnyaSearch extends EbsPendapatanLainnya
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pdtl_id', 'pdtl_tanggal', 'pdtl_nama', 'pdtl_instansi_asal', 'pdtl_tujuan', 'pdtl_keterangan', 'pdtl_created_at', 'pdtl_updated_at', 'pdtl_deleted_at'], 'safe'],
            [['pdtl_katpen_id', 'pdtl_created_by', 'pdtl_updated_by', 'pdtl_deleted_by'], 'integer'],
            [['pdtl_biaya'], 'number'],
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
        $query = EbsPendapatanLainnya::find();

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
            'pdtl_katpen_id' => $this->pdtl_katpen_id,
            'pdtl_tanggal' => $this->pdtl_tanggal,
            'pdtl_biaya' => $this->pdtl_biaya,
            'pdtl_created_at' => $this->pdtl_created_at,
            'pdtl_created_by' => $this->pdtl_created_by,
            'pdtl_updated_at' => $this->pdtl_updated_at,
            'pdtl_updated_by' => $this->pdtl_updated_by,
            'pdtl_deleted_at' => $this->pdtl_deleted_at,
            'pdtl_deleted_by' => $this->pdtl_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'pdtl_id', $this->pdtl_id])
            ->andFilterWhere(['like', 'pdtl_nama', $this->pdtl_nama])
            ->andFilterWhere(['like', 'pdtl_instansi_asal', $this->pdtl_instansi_asal])
            ->andFilterWhere(['like', 'pdtl_tujuan', $this->pdtl_tujuan])
            ->andFilterWhere(['like', 'pdtl_keterangan', $this->pdtl_keterangan]);

        return $dataProvider;
    }
}
