<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SdmMKesatuan;

/**
 * SdmMKesatuanSearch represents the model behind the search form of `app\models\SdmMKesatuan`.
 */
class SdmMKesatuanSearch extends SdmMKesatuan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['smk_id', 'smk_aktif', 'smk_created_by', 'smk_updated_by', 'smk_deleted_by'], 'integer'],
            [['smk_nama', 'smk_created_at', 'smk_updated_at', 'smk_deleted_at'], 'safe'],
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
        $query = SdmMKesatuan::find();

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
            'smk_id' => $this->smk_id,
            'smk_aktif' => $this->smk_aktif,
            'smk_created_at' => $this->smk_created_at,
            'smk_created_by' => $this->smk_created_by,
            'smk_updated_at' => $this->smk_updated_at,
            'smk_updated_by' => $this->smk_updated_by,
            'smk_deleted_at' => $this->smk_deleted_at,
            'smk_deleted_by' => $this->smk_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'smk_nama', $this->smk_nama]);

        return $dataProvider;
    }
}
