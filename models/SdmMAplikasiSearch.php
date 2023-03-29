<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SdmMAplikasi;

/**
 * SdmMAplikasiSearch represents the model behind the search form of `app\models\SdmMAplikasi`.
 */
class SdmMAplikasiSearch extends SdmMAplikasi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['apl_id', 'apl_created_by', 'apl_updated_by', 'apl_deleted_by'], 'integer'],
            [['apl_nama', 'apl_created_at', 'apl_updated_at', 'apl_deleted_at'], 'safe'],
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
        $query = SdmMAplikasi::find();

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
            'apl_id' => $this->apl_id,
            'apl_created_at' => $this->apl_created_at,
            'apl_created_by' => $this->apl_created_by,
            'apl_updated_at' => $this->apl_updated_at,
            'apl_updated_by' => $this->apl_updated_by,
            'apl_deleted_at' => $this->apl_deleted_at,
            'apl_deleted_by' => $this->apl_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'apl_nama', $this->apl_nama]);

        return $dataProvider;
    }
}
