<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EbsMMenu;

/**
 * EbsMMenuSearch represents the model behind the search form of `app\models\EbsMMenu`.
 */
class EbsMMenuSearch extends EbsMMenu
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mnu_id', 'mnu_aktif', 'mnu_tampil', 'mnu_created_by', 'mnu_updated_by', 'mnu_deleted_by'], 'integer'],
            [['mnu_nama', 'mnu_variabel', 'mnu_keterangan', 'mnu_created_at', 'mnu_updated_at', 'mnu_deleted_at'], 'safe'],
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
        $query = EbsMMenu::find();

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
            'mnu_id' => $this->mnu_id,
            'mnu_aktif' => $this->mnu_aktif,
            'mnu_tampil' => $this->mnu_tampil,
            'mnu_created_at' => $this->mnu_created_at,
            'mnu_created_by' => $this->mnu_created_by,
            'mnu_updated_at' => $this->mnu_updated_at,
            'mnu_updated_by' => $this->mnu_updated_by,
            'mnu_deleted_at' => $this->mnu_deleted_at,
            'mnu_deleted_by' => $this->mnu_deleted_by,
        ]);

        $query->andFilterWhere(['like', 'mnu_nama', $this->mnu_nama])
            ->andFilterWhere(['like', 'mnu_variabel', $this->mnu_variabel])
            ->andFilterWhere(['like', 'mnu_keterangan', $this->mnu_keterangan]);

        return $dataProvider;
    }
}
