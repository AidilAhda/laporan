<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EbsPetugasParkir;

/**
 * EbsPetugasParkirSearch represents the model behind the search form of `app\models\EbsPetugasParkir`.
 */
class EbsPetugasParkirSearch extends EbsPetugasParkir
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pprkr_id', 'pprkr_jabatan', 'pprkr_status', 'pprkr_created_by', 'pprkr_updated_by', 'pprkr_deleted_by'], 'integer'],
            [['pprkr_noidentitas', 'pprkr_nama', 'pprkr_tgl_lahir', 'pprkr_jenis_kelamin', 'pprkr_alamat', 'pprkr_nohp', 'pprkr_created_at', 'pprkr_updated_at', 'pprkr_deleted_at'], 'safe'],
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
        $query = EbsPetugasParkir::find();

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
            'pprkr_id' => $this->pprkr_id,
            'pprkr_tgl_lahir' => $this->pprkr_tgl_lahir,
            'pprkr_jabatan' => $this->pprkr_jabatan,
            'pprkr_status' => $this->pprkr_status,
            'pprkr_created_at' => $this->pprkr_created_at,
            'pprkr_created_by' => $this->pprkr_created_by,
            'pprkr_updated_at' => $this->pprkr_updated_at,
            'pprkr_updated_by' => $this->pprkr_updated_by,
            'pprkr_deleted_at' => $this->pprkr_deleted_at,
            'pprkr_deleted_by' => $this->pprkr_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'pprkr_noidentitas', $this->pprkr_noidentitas])
            ->andFilterWhere(['like', 'pprkr_nama', $this->pprkr_nama])
            ->andFilterWhere(['like', 'pprkr_jenis_kelamin', $this->pprkr_jenis_kelamin])
            ->andFilterWhere(['like', 'pprkr_alamat', $this->pprkr_alamat])
            ->andFilterWhere(['like', 'pprkr_nohp', $this->pprkr_nohp]);

        return $dataProvider;
    }
}
