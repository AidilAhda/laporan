<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SdmMAksesAplikasi;

/**
 * SdmMAksesAplikasiSearch represents the model behind the search form of `app\models\SdmMAksesAplikasi`.
 */
class SdmMAksesAplikasiSearch extends SdmMAksesAplikasi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['akp_id', 'akp_pgw_id', 'akp_apl_id', 'akp_all_id', 'akp_created_by', 'akp_updated_by', 'akp_deleted_by'], 'integer'],
            [['akp_created_at', 'akp_updated_at', 'akp_deleted_at'], 'safe'],
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
        $query = SdmMAksesAplikasi::find();

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
            'akp_id' => $this->akp_id,
            'akp_pgw_id' => $this->akp_pgw_id,
            'akp_apl_id' => $this->akp_apl_id,
            'akp_all_id' => $this->akp_all_id,
            'akp_created_at' => $this->akp_created_at,
            'akp_created_by' => $this->akp_created_by,
            'akp_updated_at' => $this->akp_updated_at,
            'akp_updated_by' => $this->akp_updated_by,
            'akp_deleted_at' => $this->akp_deleted_at,
            'akp_deleted_by' => $this->akp_deleted_by,
        ]);

        return $dataProvider;
    }
}
