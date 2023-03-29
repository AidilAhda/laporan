<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SdmMAplikasiLevel;

/**
 * SdmMAplikasiLevelSearch represents the model behind the search form of `app\models\SdmMAplikasiLevel`.
 */
class SdmMAplikasiLevelSearch extends SdmMAplikasiLevel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['all_id', 'all_apl_id', 'all_created_by', 'all_updated_by', 'all_deleted_by'], 'integer'],
            [['all_nama', 'all_created_at', 'all_updated_at', 'all_deleted_at'], 'safe'],
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
        $query = SdmMAplikasiLevel::find();

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
            'all_id' => $this->all_id,
            'all_apl_id' => $this->all_apl_id,
            'all_created_at' => $this->all_created_at,
            'all_created_by' => $this->all_created_by,
            'all_updated_at' => $this->all_updated_at,
            'all_updated_by' => $this->all_updated_by,
            'all_deleted_at' => $this->all_deleted_at,
            'all_deleted_by' => $this->all_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'all_nama', $this->all_nama]);

        return $dataProvider;
    }
}
