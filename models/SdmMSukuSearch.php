<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SdmMSuku;

/**
 * SdmMSukuSearch represents the model behind the search form of `app\models\SdmMSuku`.
 */
class SdmMSukuSearch extends SdmMSuku
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['suk_id', 'suk_aktif', 'suk_created_by', 'suk_updated_by', 'suk_deleted_by'], 'integer'],
            [['suk_nama', 'suk_created_at', 'suk_updated_at', 'suk_deleted_at'], 'safe'],
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
        $query = SdmMSuku::find();

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
            'suk_id' => $this->suk_id,
            'suk_aktif' => $this->suk_aktif,
            'suk_created_at' => $this->suk_created_at,
            'suk_created_by' => $this->suk_created_by,
            'suk_updated_at' => $this->suk_updated_at,
            'suk_updated_by' => $this->suk_updated_by,
            'suk_deleted_at' => $this->suk_deleted_at,
            'suk_deleted_by' => $this->suk_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'suk_nama', $this->suk_nama]);

        return $dataProvider;
    }
}
