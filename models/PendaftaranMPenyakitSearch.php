<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PendaftaranMPenyakit;

/**
 * PendaftaranMPenyakitSearch represents the model behind the search form of `app\models\PendaftaranMPenyakit`.
 */
class PendaftaranMPenyakitSearch extends PendaftaranMPenyakit
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pmp_id', 'pmp_aktif', 'pmp_created_by', 'pmp_updated_by', 'pmp_deleted_by'], 'integer'],
            [['pmp_nama', 'pmp_created_at', 'pmp_updated_at', 'pmp_deleted_at'], 'safe'],
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
        $query = PendaftaranMPenyakit::find();

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
            'pmp_id' => $this->pmp_id,
            'pmp_aktif' => $this->pmp_aktif,
            'pmp_created_at' => $this->pmp_created_at,
            'pmp_created_by' => $this->pmp_created_by,
            'pmp_updated_at' => $this->pmp_updated_at,
            'pmp_updated_by' => $this->pmp_updated_by,
            'pmp_deleted_at' => $this->pmp_deleted_at,
            'pmp_deleted_by' => $this->pmp_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'pmp_nama', $this->pmp_nama]);

        return $dataProvider;
    }
}
