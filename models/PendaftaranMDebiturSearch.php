<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PendaftaranMDebitur;

/**
 * PendaftaranMDebiturSearch represents the model behind the search form of `app\models\PendaftaranMDebitur`.
 */
class PendaftaranMDebiturSearch extends PendaftaranMDebitur
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pmd_kode', 'pmd_nama', 'pmd_created_at', 'pmd_updated_at', 'pmd_deleted_at'], 'safe'],
            [['pmd_aktif', 'pmd_created_by', 'pmd_updated_by', 'pmd_deleted_by'], 'integer'],
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
        $query = PendaftaranMDebitur::find();

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
            'pmd_aktif' => $this->pmd_aktif,
            'pmd_created_at' => $this->pmd_created_at,
            'pmd_created_by' => $this->pmd_created_by,
            'pmd_updated_at' => $this->pmd_updated_at,
            'pmd_updated_by' => $this->pmd_updated_by,
            'pmd_deleted_at' => $this->pmd_deleted_at,
            'pmd_deleted_by' => $this->pmd_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'pmd_kode', $this->pmd_kode])
            ->andFilterWhere(['like', 'pmd_nama', $this->pmd_nama]);

        return $dataProvider;
    }
}
