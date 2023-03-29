<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SdmMAksesUnit;

/**
 * SdmMAksesUnitSearch represents the model behind the search form of `app\models\SdmMAksesUnit`.
 */
class SdmMAksesUnitSearch extends SdmMAksesUnit
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aku_id', 'aku_pgw_id', 'aku_unt_id', 'aku_apl_id', 'aku_aktif', 'aku_created_by', 'aku_updated_by', 'aku_deleted_by'], 'integer'],
            [['aku_sk', 'aku_created_at', 'aku_updated_at', 'aku_deleted_at'], 'safe'],
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
        $query = SdmMAksesUnit::find();

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
            'aku_id' => $this->aku_id,
            'aku_pgw_id' => $this->aku_pgw_id,
            'aku_unt_id' => $this->aku_unt_id,
            'aku_apl_id' => $this->aku_apl_id,
            'aku_aktif' => $this->aku_aktif,
            'aku_created_at' => $this->aku_created_at,
            'aku_created_by' => $this->aku_created_by,
            'aku_updated_at' => $this->aku_updated_at,
            'aku_updated_by' => $this->aku_updated_by,
            'aku_deleted_at' => $this->aku_deleted_at,
            'aku_deleted_by' => $this->aku_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'aku_sk', $this->aku_sk]);

        return $dataProvider;
    }
}
