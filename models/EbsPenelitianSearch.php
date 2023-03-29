<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EbsPenelitian;

/**
 * EbsPenelitianSearch represents the model behind the search form of `app\models\EbsPenelitian`.
 */
class EbsPenelitianSearch extends EbsPenelitian
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tlt_id', 'tlt_tgl', 'tlt_nama', 'tlt_instansi_asal', 'tlt_tujuan', 'tlt_keterangan', 'tlt_created_at', 'tlt_updated_at', 'tlt_deleted_at'], 'safe'],
            [['tlt_biaya'], 'number'],
            [['tlt_created_by', 'tlt_updated_by', 'tlt_deleted_by'], 'integer'],
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
        $query = EbsPenelitian::find();

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
            'tlt_tgl' => $this->tlt_tgl,
            'tlt_biaya' => $this->tlt_biaya,
            'tlt_created_at' => $this->tlt_created_at,
            'tlt_created_by' => $this->tlt_created_by,
            'tlt_updated_at' => $this->tlt_updated_at,
            'tlt_updated_by' => $this->tlt_updated_by,
            'tlt_deleted_at' => $this->tlt_deleted_at,
            'tlt_deleted_by' => $this->tlt_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'tlt_id', $this->tlt_id])
            ->andFilterWhere(['like', 'tlt_nama', $this->tlt_nama])
            ->andFilterWhere(['like', 'tlt_instansi_asal', $this->tlt_instansi_asal])
            ->andFilterWhere(['like', 'tlt_tujuan', $this->tlt_tujuan])
            ->andFilterWhere(['like', 'tlt_keterangan', $this->tlt_keterangan]);

        return $dataProvider;
    }
}
