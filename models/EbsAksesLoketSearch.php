<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EbsAksesLoket;

/**
 * EbsAksesLoketSearch represents the model behind the search form of `app\models\EbsAksesLoket`.
 */
class EbsAksesLoketSearch extends EbsAksesLoket
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alo_id', 'alo_user_id', 'alo_lob_id', 'alo_aktif', 'alo_created_by', 'alo_updated_by', 'alo_deleted_by'], 'integer'],
            [['alo_created_at', 'alo_updated_at', 'alo_deleted_at'], 'safe'],
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
        $query = EbsAksesLoket::find();

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
            'alo_id' => $this->alo_id,
            'alo_user_id' => $this->alo_user_id,
            'alo_lob_id' => $this->alo_lob_id,
            'alo_aktif' => $this->alo_aktif,
            'alo_created_at' => $this->alo_created_at,
            'alo_created_by' => $this->alo_created_by,
            'alo_updated_at' => $this->alo_updated_at,
            'alo_updated_by' => $this->alo_updated_by,
            'alo_deleted_at' => $this->alo_deleted_at,
            'alo_deleted_by' => $this->alo_deleted_by,
        ]);

        return $dataProvider;
    }
}
