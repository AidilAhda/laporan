<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SdmMNegara;

/**
 * SdmMNegaraSearch represents the model behind the search form of `app\models\SdmMNegara`.
 */
class SdmMNegaraSearch extends SdmMNegara
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ngr_id', 'ngr_aktif', 'ngr_created_by', 'ngr_updated_by', 'ngr_deleted_by'], 'integer'],
            [['ngr_kode', 'ngr_nama', 'ngr_created_at', 'ngr_updated_at', 'ngr_deleted_at'], 'safe'],
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
        $query = SdmMNegara::find();

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
            'ngr_id' => $this->ngr_id,
            'ngr_aktif' => $this->ngr_aktif,
            'ngr_created_at' => $this->ngr_created_at,
            'ngr_created_by' => $this->ngr_created_by,
            'ngr_updated_at' => $this->ngr_updated_at,
            'ngr_updated_by' => $this->ngr_updated_by,
            'ngr_deleted_at' => $this->ngr_deleted_at,
            'ngr_deleted_by' => $this->ngr_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'ngr_kode', $this->ngr_kode])
            ->andFilterWhere(['like', 'ngr_nama', $this->ngr_nama]);

        return $dataProvider;
    }
}
