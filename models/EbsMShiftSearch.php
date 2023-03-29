<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EbsMShift;

/**
 * EbsMShiftSearch represents the model behind the search form of `app\models\EbsMShift`.
 */
class EbsMShiftSearch extends EbsMShift
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shf_id', 'shf_aktif', 'shf_created_by', 'shf_updated_by', 'shf_deleted_by'], 'integer'],
            [['shf_nama', 'shf_keterangan', 'shf_created_at', 'shf_updated_at', 'shf_deleted_at'], 'safe'],
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
        $query = EbsMShift::find();

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
            'shf_id' => $this->shf_id,
            'shf_aktif' => $this->shf_aktif,
            'shf_created_at' => $this->shf_created_at,
            'shf_created_by' => $this->shf_created_by,
            'shf_updated_at' => $this->shf_updated_at,
            'shf_updated_by' => $this->shf_updated_by,
            'shf_deleted_at' => $this->shf_deleted_at,
            'shf_deleted_by' => $this->shf_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'shf_nama', $this->shf_nama])
            ->andFilterWhere(['like', 'shf_keterangan', $this->shf_keterangan]);

        return $dataProvider;
    }
}
