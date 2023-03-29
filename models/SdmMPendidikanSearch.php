<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SdmMPendidikan;

/**
 * SdmMPendidikanSearch represents the model behind the search form of `app\models\SdmMPendidikan`.
 */
class SdmMPendidikanSearch extends SdmMPendidikan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pdd_id', 'pdd_kode', 'pdd_aktif', 'pdd_created_by', 'pdd_updated_by', 'pdd_deleted_by'], 'integer'],
            [['pdd_nama', 'pdd_created_at', 'pdd_updated_at', 'pdd_deleted_at'], 'safe'],
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
        $query = SdmMPendidikan::find();

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
            'pdd_id' => $this->pdd_id,
            'pdd_kode' => $this->pdd_kode,
            'pdd_aktif' => $this->pdd_aktif,
            'pdd_created_at' => $this->pdd_created_at,
            'pdd_created_by' => $this->pdd_created_by,
            'pdd_updated_at' => $this->pdd_updated_at,
            'pdd_updated_by' => $this->pdd_updated_by,
            'pdd_deleted_at' => $this->pdd_deleted_at,
            'pdd_deleted_by' => $this->pdd_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'pdd_nama', $this->pdd_nama]);

        return $dataProvider;
    }
}
