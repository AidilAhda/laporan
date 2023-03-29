<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PendaftaranMCaraMasukUnit;

/**
 * PendaftaranMCaraMasukUnitSearch represents the model behind the search form of `app\models\PendaftaranMCaraMasukUnit`.
 */
class PendaftaranMCaraMasukUnitSearch extends PendaftaranMCaraMasukUnit
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cmu_kode', 'cmu_nama', 'cmu_created_at', 'cmu_updated_at', 'cmu_deleted_at'], 'safe'],
            [['cmu_aktif', 'cmu_created_by', 'cmu_updated_by', 'cmu_deleted_by'], 'integer'],
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
        $query = PendaftaranMCaraMasukUnit::find();

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
            'cmu_aktif' => $this->cmu_aktif,
            'cmu_created_at' => $this->cmu_created_at,
            'cmu_created_by' => $this->cmu_created_by,
            'cmu_updated_at' => $this->cmu_updated_at,
            'cmu_updated_by' => $this->cmu_updated_by,
            'cmu_deleted_at' => $this->cmu_deleted_at,
            'cmu_deleted_by' => $this->cmu_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'cmu_kode', $this->cmu_kode])
            ->andFilterWhere(['like', 'cmu_nama', $this->cmu_nama]);

        return $dataProvider;
    }
}
