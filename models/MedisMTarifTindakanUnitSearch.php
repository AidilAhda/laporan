<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MedisMTarifTindakanUnit;

/**
 * MedisMTarifTindakanUnitSearch represents the model behind the search form of `app\models\MedisMTarifTindakanUnit`.
 */
class MedisMTarifTindakanUnitSearch extends MedisMTarifTindakanUnit
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ttu_id', 'ttu_tarif_tindakan_id', 'ttu_unit_id', 'ttu_aktif', 'ttu_created_by', 'ttu_updated_by', 'ttu_deleted_by'], 'integer'],
            [['ttu_created_at', 'ttu_updated_at', 'ttu_deleted_at'], 'safe'],
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
        $query = MedisMTarifTindakanUnit::find();

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
            'ttu_id' => $this->ttu_id,
            'ttu_tarif_tindakan_id' => $this->ttu_tarif_tindakan_id,
            'ttu_unit_id' => $this->ttu_unit_id,
            'ttu_aktif' => $this->ttu_aktif,
            'ttu_created_at' => $this->ttu_created_at,
            'ttu_created_by' => $this->ttu_created_by,
            'ttu_updated_at' => $this->ttu_updated_at,
            'ttu_updated_by' => $this->ttu_updated_by,
            'ttu_deleted_at' => $this->ttu_deleted_at,
            'ttu_deleted_by' => $this->ttu_deleted_by,
        ]);

        return $dataProvider;
    }
}
